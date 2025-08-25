<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando!', 'timestamp' => now()]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Suas rotas de API aqui:
//Route::apiResource('seus-recursos', Pessoa::class);

Route::apiResource('customers', CustomerController::class);

//Route::middleware('auth:api')->group(function () {
    
//});