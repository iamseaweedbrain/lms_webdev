<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OtpResetModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\AccountModel;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ForgotPasswordOtpController extends Controller
{
    protected $otpTtlMinutes = 10;
    protected $maxAttempts = 5;
    protected $tokenMaxAgeHours = 1;

    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = AccountModel::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with that email.']);
        }

        $otp = random_int(100000, 999999);
        $otpHash = Hash::make($otp);
        $expiresAt = Carbon::now()->addMinutes($this->otpTtlMinutes);

        OtpResetModel::where('email', $request->email)->delete();

        OtpResetModel::create([
            'email' => $request->email,
            'otp_hash' => $otpHash,
            'expires_at' => $expiresAt,
        ]);

        try {
            Mail::to($request->email)->send(new OtpMail($otp, $this->otpTtlMinutes));
        } catch (\Throwable $e) {
            Log::error('OTP Mail failed to send: ' . $e->getMessage());
        }

        return redirect()->route('verify.otp', ['email' => $request->email])
                         ->with('success', 'An OTP has been sent to your email.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $record = OtpResetModel::where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid or expired code.']);
        }

        if ($record->attempts >= $this->maxAttempts) {
            $record->delete();
            return back()->withErrors(['otp' => 'Too many attempts. Please request a new code.']);
        }

        if (Carbon::now()->gt($record->expires_at)) {
            $record->delete();
            return back()->withErrors(['otp' => 'Code expired. Please request a new one.']);
        }

        if (!Hash::check(trim($request->otp), $record->otp_hash)) {
            $record->increment('attempts');
            return back()->withErrors(['otp' => 'Invalid code.']);
        }

        $payload = [
            'email' => $record->email,
            'iat' => time(),
        ];
        $resetToken = encrypt($payload);

        $record->delete();

        $record->delete();

        return redirect()->route('reset.password', ['reset_token' => $resetToken])
                        ->with('success', 'OTP verified. You may now reset your password.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors([
                'password' => 'Password and confirmation do not match.'
            ])->withInput();
        }

        try {
            $payload = decrypt($request->reset_token);
        } catch (\Throwable $e) {
            return back()->withErrors(['reset_token' => 'Invalid or expired reset token.']);
        }

        $email = $payload['email'] ?? null;
        $iat = $payload['iat'] ?? 0;
        //link check
        if (time() - $iat > $this->tokenMaxAgeHours * 3600) {
            return back()->withErrors(['reset_token' => 'The reset link has expired.']);
        }

        $user = AccountModel::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')
                        ->with('success', 'Password reset successful. You can now log in.');
    }
}
