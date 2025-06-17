<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CarController;
use App\Http\Controllers\Api\V1\CarModelController;
use App\Http\Controllers\Api\V1\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/search', [CarController::class, 'search']);
    Route::get('/cars/{id}', [CarController::class, 'show']);
    Route::post('/cars', [CarController::class, 'store']);
    Route::put('/cars/{id}', [CarController::class, 'update']);
    Route::delete('/cars/{id}', [CarController::class, 'destroy']);

//    Route::get('/brands', [BrandController::class, 'index']);
//    Route::get('/brands/{id}', [BrandController::class, 'show']);
//    Route::post('/brands', [BrandController::class, 'store']);
//    Route::put('/brands/{id}', [BrandController::class, 'update']);
//    Route::delete('/brands/{id}', [BrandController::class, 'destroy']);

    Route::apiResource('brands', BrandController::class);
    Route::apiResource('models', CarModelController::class);
    Route::apiResource('pages', PageController::class);

    Route::get('/user', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'login']);


