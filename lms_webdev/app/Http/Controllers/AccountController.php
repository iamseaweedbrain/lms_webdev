<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
}
