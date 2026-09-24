<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

Route::resource('kategoris', KategoriController::class);