<?php


use App\Http\Controllers\v1\Search\SearchController;
use Illuminate\Support\Facades\Route;

Route::controller(SearchController::class)->group(function () {
    Route::prefix('/search')->group(function () {
        Route::name('search.')->group(function () {
            Route::post('/user', 'search')
                ->name('user');
        });
    });
});
