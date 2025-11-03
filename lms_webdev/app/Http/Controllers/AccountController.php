<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAccount;

class AccountController extends Controller
{
    // pang create lang sha ng new account
    public function store(Request $request)
    {
        $user = new UserAccount();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = 'avatars/active-cat.jpg';
        $user->save();

        return redirect()->back()->with('success', 'User created!');
    }
}
