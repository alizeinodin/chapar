<?php


use App\Http\Controllers\v1\PrivateChat\PrivateChatController;
use Illuminate\Support\Facades\Route;

Route::apiResource('chat', PrivateChatController::class)
    ->except([
        'update'
    ]);
