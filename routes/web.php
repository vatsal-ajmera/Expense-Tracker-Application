<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\SpendAnalyticsController;
use App\Http\Controllers\Admin\TransactionHistoryController;
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

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', [ProfileController::class, 'index'])->name('get');
            Route::post('save-avatar', [ProfileController::class, 'saveAvatar'])->name('avatar.post');
            Route::post('save-profile', [ProfileController::class, 'saveProfile'])->name('post');
        });

        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::get('/', [AccountsController::class, 'index'])->name('list');
            Route::get('/get-records', [AccountsController::class, 'getRecords'])->name('get-records');
            Route::get('/create', [AccountsController::class, 'create'])->name('create');
            Route::post('/save', [AccountsController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [AccountsController::class, 'edit'])->name('edit');
            Route::delete('/delete/{id}', [AccountsController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
            Route::get('/', [ExpenseCategoryController::class, 'index'])->name('list');
            Route::get('/get-records', [ExpenseCategoryController::class, 'getRecords'])->name('get-records');
            Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('create');
            Route::post('/save', [ExpenseCategoryController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [ExpenseCategoryController::class, 'edit'])->name('edit');
            Route::delete('/delete/{id}', [ExpenseCategoryController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
            Route::get('/', [ExpenseController::class, 'index'])->name('list');
            Route::get('/get-records', [ExpenseController::class, 'getRecords'])->name('get-records');
            Route::get('/create', [ExpenseController::class, 'create'])->name('create');
            Route::post('/save', [ExpenseController::class, 'save'])->name('save');
            Route::post('/update', [ExpenseController::class, 'update'])->name('update');
            Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit');
            Route::delete('/delete/{id}', [ExpenseController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'income', 'as' => 'income.'], function () {
            Route::get('/', [IncomeController::class, 'index'])->name('list');
            Route::get('/get-records', [IncomeController::class, 'getRecords'])->name('get-records');
            Route::get('/create', [IncomeController::class, 'create'])->name('create');
            Route::post('/save', [IncomeController::class, 'save'])->name('save');
            Route::get('/edit/{id}', [IncomeController::class, 'edit'])->name('edit');
            Route::delete('/delete/{id}', [IncomeController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'analytics', 'as' => 'analytics.'], function () {
            Route::get('/', [SpendAnalyticsController::class, 'index'])->name('spend_analytics');
            Route::get('/transaction-history', [SpendAnalyticsController::class, 'index'])->name('spend_analytics');
        });

        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
            Route::get('/history', [TransactionHistoryController::class, 'index'])->name('history');
            Route::get('/get-records', [TransactionHistoryController::class, 'getRecords'])->name('get-records');
        });
    });
});
