<?php

use App\Http\Controllers\v1\SMS\SmsVerificationController;
use Illuminate\Support\Facades\Route;

Route::controller(SmsVerificationController::class)->group(function () {
    Route::prefix('/sms_verification')->group(function () {
        Route::name('sms_verification.')->group(function () {

            Route::post('/', 'send')
                ->name('send')
                ->middleware('sms.limitation');

            Route::post('/verify', 'verify')
                ->name('verify');
        });
    });
});
