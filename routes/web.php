<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\Google2FA;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

/*
    ## to enable Throttling
    use Illuminate\Cache\RateLimiting\Limit;
    RateLimiter::for('web', fn ($request) => Limit::perMinute(10)->by($request->ip()));
    Route::middleware('throttle:web')->group(function () {
    });
*/

Route::group(['as' => 'auth.'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::any('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot_password.post');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.post');
    Route::post('/post-login', [AuthController::class, 'post_login'])->name('post_login');
}); 

Route::group(['prefix' => '', 'as' => '', 'middleware' => [AuthenticateUser::class]], function () {
    Route::get('otp-verify', [AuthController::class, 'authenticate_user'])->name('otp_verify');
    Route::post('post-otp-verify', [AuthController::class, 'post_authenticate_user'])->name('post_otp_verify');

    Route::group(['prefix' => '', 'as' => '', 'middleware' => [AuthenticateUser::class, Google2FA::class]], function () {
        Route::get('change-language/{lang}', [LanguageController::class, 'changeAppLanguage'])->name('change_app_language');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
