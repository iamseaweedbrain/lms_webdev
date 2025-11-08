<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AccountController::class, 'store'])->name('storeSignUp');
Route::post('/login', [AccountController::class, 'login'])->name('retrieveLogIn');
Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
Route::post('/change-password', [AccountController::class, 'changePassword'])->name('change-password');

Route::view('/', 'landingpage')->name('landingpage');
Route::view('/login', 'auth.login')->name('login');
Route::view('/signup', 'auth.signup')->name('signup');
Route::view('/dashboard', 'dashboard')->name('dashboard');
Route::view('/classes', 'classes')->name('classes');
Route::view('/grades', 'grades')->name('grades');
Route::view('/settings', 'settings')->name('settings');
Route::view('/student', 'student')->name('student');
Route::view('/notification', 'notification')->name('notification');
Route::view('/settings-edit', 'settings-edit')->name('settings-edit');
Route::post('/settings-update', [AccountController::class, 'updateSettings'])->name('settings-update');

