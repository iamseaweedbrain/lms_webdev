<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PinnedClassesController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AccountController::class, 'store'])->name('storeSignUp');
Route::post('/login', [AccountController::class, 'login'])->name('retrieveLogIn');
Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
Route::post('/change-password', [AccountController::class, 'changePassword'])->name('change-password');
Route::post('/settings-update', [AccountController::class, 'updateSettings'])->name('settings-update');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
Route::post('/submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');

Route::view('/', 'landingpage')->name('landingpage');
Route::view('/login', 'auth.login')->name('login');
Route::view('/signup', 'auth.signup')->name('signup');
Route::view('/classes', 'classes')->name('classes');
Route::view('/add-class', 'add_class')->name('add_class');
Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
Route::get('/grades/{class?}', [SubmissionController::class, 'index'])->name('grades');
Route::view('/settings', 'settings')->name('settings');
Route::view('/student', 'student')->name('student');
Route::view('/notification', 'notification')->name('notification');
Route::view('/settings-edit', 'settings-edit')->name('settings-edit');
Route::get('/student_grade/{id}', [SubmissionController::class, 'show'])->name('student_grade');


Route::get('/classes', [PinnedClassesController::class, 'index'])->name('classes');

