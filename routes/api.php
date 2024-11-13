<?php

use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\BrandModelApiController;
use Illuminate\Support\Facades\Route;

Route::get('brands', [BrandApiController::class, 'index']);
Route::get('brand/{brand}', [BrandApiController::class, 'show']);
Route::post('model/store', [BrandModelApiController::class, 'store']);
