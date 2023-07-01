<?php

use App\Http\Controllers\v1\Audience\AudienceController;
use Illuminate\Support\Facades\Route;

Route::apiResource('audiences', AudienceController::class)
    ->except([
        'update',
    ]);
