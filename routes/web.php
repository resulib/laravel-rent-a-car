<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('user.home');

Route::prefix('/cars')->name('user.')->group(function () {
    Route::get('/', [CarController::class, 'userIndex'])->name('cars.index');
    Route::get('/{slug}', [CarController::class, 'show'])->name('cars.show');
});

Route::get('/{page:slug}', [PageController::class, 'show'])->name('page.show');

Route::get('admin/login', [AuthController::class, 'login'])->name('login');
Route::post('admin/login', [AuthController::class, 'loginPost'])->name('login.post');



Route::middleware(['web', 'auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('brands/create', [BrandController::class, 'store'])->name('brand.store');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');

    Route::get('models', [ModelController::class, 'index'])->name('model.index');
    Route::get('models/create', [ModelController::class, 'create'])->name('model.create');
    Route::post('models/create', [ModelController::class, 'store'])->name('model.store');
    Route::get('models/{model}/edit', [ModelController::class, 'edit'])->name('model.edit');
    Route::put('models/{model}', [ModelController::class, 'update'])->name('model.update');
    Route::delete('models/{model}', [ModelController::class, 'destroy'])->name('model.destroy');

    Route::get('cars', [CarController::class, 'adminIndex'])->name('car.index');
    Route::get('cars/create', [CarController::class, 'create'])->name('car.create');
    Route::post('cars/create', [CarController::class, 'store'])->name('car.store');
    Route::get('car-models-by-brand', [ModelController::class, 'modelsByBrand'])->name('car.modelsByBrand');
    Route::get('cars/{car}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::put('cars/{car}', [CarController::class, 'update'])->name('car.update');
    Route::delete('cars/image/delete', [CarController::class, 'deleteImage'])->name('car.image.delete');
    Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('car.destroy');

    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});





