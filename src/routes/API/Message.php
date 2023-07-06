<?php

use App\Http\Controllers\v1\Message\MessageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('message', MessageController::class);
