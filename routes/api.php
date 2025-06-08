<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Public routes (no auth required)
Route::get('/users', [UserController::class, 'apiIndex']);
Route::get('/ping', function() {
    return response()->json(['status' => 'OK']);
});

// Protected routes (require Sanctum auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users', [UserController::class, 'apiStore']);
    Route::put('/users/{user}', [UserController::class, 'apiUpdate']);
    Route::delete('/users/{user}', [UserController::class, 'apiDestroy']);
    Route::post('/users/{user}/change-password', [UserController::class, 'apiChangePassword']);
});
