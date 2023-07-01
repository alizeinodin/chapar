<?php

use App\Http\Controllers\v1\Audience\AudienceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('audiences', AudienceController::class)
    ->except([
        'update',
    ]);
Route::controller(AudienceController::class)->group(function () {
    Route::prefix('/audiences')->group(function () {
        Route::name('audiences.')->group(function () {
            Route::post('/all', 'storeAll')
                ->name('storeAll');
        });
    });
});
