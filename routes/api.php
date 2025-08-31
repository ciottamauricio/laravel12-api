<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\SocialUserController;

// Public routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::get('/test', function () {
    return response()->json(['message' => 'API Working!', 'timestamp' => now()]);
});

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Auth protected routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);
    
    // Customer CRUD
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('receipts', ReceiptController::class);

    Route::post('/social-user/fetch-save', [SocialUserController::class, 'fetchAndSave']);
    
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});