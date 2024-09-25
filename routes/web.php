<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AuthenticateUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});



Route::group(['as' => 'auth'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
    });

Route::group(['prefix' => '', 'as' => '', 'middleware' => AuthenticateUser::class], function () {

});
