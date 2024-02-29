<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LoginVerifyOtpController;
use App\Http\Api\Controllers\Auth\RegisterController;
use App\Http\Api\Controllers\Auth\RegisterVerifyOtpController;
use App\Http\Api\Controllers\FitbitController;
use App\Http\Api\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::resource('register', RegisterController::class)->only(['index', 'store']);
Route::get('otp-register', [RegisterVerifyOtpController::class, 'otp'])->name('otp.register');
Route::post('otp-register', [RegisterVerifyOtpController::class, 'verifyOtp'])->name('otp.verify.register');
Route::post('resend-otp-register', [RegisterVerifyOtpController::class, 'resendOtpRegister'])->name('resend.otp.register');
Route::resource('login', LoginController::class)->only(['index', 'store']);
Route::get('otp-login', [LoginVerifyOtpController::class, 'otp'])->name('otp');
Route::post('otp-login', [LoginVerifyOtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('resend-otp', [LoginVerifyOtpController::class, 'resendOtpLogin'])->name('resend-otp');

// Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'viewProfile']);
    Route::put('profile', [ProfileController::class, 'updateProfile']);
    Route::get('change-email', [ProfileController::class, 'otp'])->name('otp.change.email');
    Route::post('change-email', [ProfileController::class, 'changeEmail'])->name('otp.change.email');
    Route::post('verify-email-otp', [ProfileController::class, 'verifyEmailOtp'])->name('otp.verify.change.email');
    Route::post('resend-email-otp', [ProfileController::class, 'resendEmailOtp'])->name('resend-otp.email');
    
    Route::get('fitbit/auth',[FitbitController::class, 'fitbitConnect']);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});