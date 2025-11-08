<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    // pang create lang sha ng new account
    public function store(Request $request)
    {
        $user = new AccountModel();
        $user->user_id = uniqid('user_');
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = 'avatars/active-cat.jpg';
        $user->save();

        return redirect()->back()->with('success', 'User created!');
    }

    //panglogin to ofc
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            try {
                $currentSessionId = session()->getId();
                DB::table('sessions')->where('id', $currentSessionId)->update(['user_id' => Auth::id()]);
            } catch (\Exception $e) {
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }
    
    //panglogout sha beh
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            DB::table('sessions')->where('user_id', $user->user_id)->delete();
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landingpage');
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var AccountModel|null $user */
        $user = Auth::user();

        if (! ($user instanceof AccountModel) || ! Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        try {
            $currentSessionId = session()->getId();
            DB::table('sessions')
                ->where('user_id', $user->user_id)
                ->where('id', '!=', $currentSessionId)
                ->delete();
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
        }

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    /**
     * Update user profile settings (avatar, firstname, lastname).
     */
    public function updateSettings(Request $request)
    {
        /** @var AccountModel|null $user */
        $user = Auth::user();

        if (! ($user instanceof AccountModel)) {
            return redirect()->back()->withErrors(['user' => 'User not authenticated']);
        }

        $data = $request->validate([
            'firstname' => ['nullable', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('useraccount')->ignore($user->user_id, 'user_id')],
            'avatar' => ['nullable', 'string', 'max:255'],
        ]);

        if (!empty($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }

        if (array_key_exists('firstname', $data)) {
            $user->firstname = $data['firstname'];
        }
        if (array_key_exists('lastname', $data)) {
            $user->lastname = $data['lastname'];
        }

        if (array_key_exists('email', $data)) {
            $user->email = $data['email'];
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
