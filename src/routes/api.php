<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Route;

require_once 'API/SMSVerification.php';
require_once 'API/Auth.php';

Route::middleware('auth:api')->group(function () {
    require_once 'API/Audience.php';
    require_once 'API/User.php';
});
