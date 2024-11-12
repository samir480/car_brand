<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::get('/product', function () {
    return Inertia::render('Product');
});
Route::resource('brand', BrandController::class)->except([
    'show'
]);;
