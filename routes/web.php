<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Layout');
});
Route::get('/product', function () {
    return Inertia::render('Product');
});
