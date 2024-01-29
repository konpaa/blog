<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::get('confirm', [AuthController::class, 'confirm'])->name('confirm');
    Route::post('confirm/reset', [AuthController::class, 'resetConfirm']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('profile')->middleware(['auth:sanctum'])->group(function () {
    Route::get('self', [ProfileController::class, 'self']);
    Route::patch('self', [ProfileController::class, 'update']);
    Route::post('upload-files', [ProfileController::class, 'uploadFiles']);
    Route::delete('upload-files/{id}', [ProfileController::class, 'deleteFiles']);
});
