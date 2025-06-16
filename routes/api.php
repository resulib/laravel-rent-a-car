<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\API\CarController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/cars', [CarController::class, 'index']);
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

});
