<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Pessoa;
use App\Http\Controllers\Api\CustomerController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Suas rotas de API aqui:
Route::apiResource('seus-recursos', Pessoa::class);

Route::apiResource('customers', CustomerController::class);

Route::middleware('auth:api')->group(function () {
    
});