<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landingpage')->name('landingpage');
Route::view('/login', 'auth.login')->name('login');
Route::view('/signup', 'auth.signup')->name('signup');
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::view('/classes', 'classes')->name('classes');
Route::view('/grades', 'grades')->name('grades');
Route::view('/settings', 'settings')->name('settings');
Route::view('/student', 'student')->name('student');

