<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landingpage')->name('landingpage');
Route::view('/login', 'auth.login')->name('login');
Route::view('/signup', 'auth.signup')->name('signup');
Route::view('/account-settings', 'account-settings')->name('account-settings');

