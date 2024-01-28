<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SelfController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('self', SelfController::class);
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
});
