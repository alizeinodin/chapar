<?php

use App\Http\Controllers\v1\SMS\SmsVerificationController;
use Illuminate\Support\Facades\Route;

# TODO add middleware for time limitation for send sms

Route::controller(SmsVerificationController::class)->group(function () {
    Route::prefix('/sms_verification')->group(function () {
        Route::name('sms_verification.')->group(function () {

            Route::post('/', 'send')
                ->name('send');

            Route::post('/verify', 'verify')
                ->name('verify');
        });
    });
});
