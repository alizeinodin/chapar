<?php


use App\Http\Controllers\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

# TODO add middleware for time limitation for send sms

Route::controller(AuthController::class)->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::name('auth.')->group(function () {

            Route::post('/register', 'register')
                ->name('register');

            Route::post('/login', 'login')
                ->name('login');

            Route::middleware('auth:api')->group(function () {
                Route::post('/logout', 'logout')
                    ->name('logout');
            });
        });
    });
});
