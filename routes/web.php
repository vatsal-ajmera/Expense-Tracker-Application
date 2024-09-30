<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\Google2FA;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});



Route::group(['as' => 'auth.'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/post-login', [AuthController::class, 'post_login'])->name('post_login');
});

Route::group(['prefix' => '', 'as' => '', 'middleware' => [AuthenticateUser::class]], function () {
    Route::get('otp-verify',[AuthController::class,'authenticate_user'])->name('otp_verify');
    Route::post('post-otp-verify',[AuthController::class,'post_authenticate_user'])->name('post_otp_verify');

    Route::group(['prefix' => '', 'as' => '', 'middleware' => [AuthenticateUser::class,Google2FA::class]], function () {

        Route::get('logout',[AuthController::class,'logout'])->name('logout');
        
        Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    });
});
