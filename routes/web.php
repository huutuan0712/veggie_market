<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::middleware(['guest', 'web'])->group(function () {
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.submit');
Route::get('/reset-password/{token}', [AuthController::class, 'showRestPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.submitRest');

});

//Verify Email
Route::get('/email/verify', function () {
    return view('mail.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Link xác minh đã được gửi lại!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::resource('cart', \App\Http\Controllers\CartController::class);
Route::resource('checkout', \App\Http\Controllers\CheckOutController::class);


