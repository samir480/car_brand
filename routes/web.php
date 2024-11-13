<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\BrandModelController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('brand', BrandController::class)->except([
    'show'
]);
Route::resource('model', BrandModelController::class)->except([
    'show'
])->parameters([
    'model' => 'brand_model'
]);
