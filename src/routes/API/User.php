<?php

use App\Http\Controllers\v1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::prefix('/user')->group(function () {
        Route::name('user.')->group(function () {
            Route::get('/get', 'getUser')
                ->name('get');

            Route::middleware('auth:api')->group(function () {
                Route::patch('/', 'update')
                    ->name('update');
            });
        });
    });
});
