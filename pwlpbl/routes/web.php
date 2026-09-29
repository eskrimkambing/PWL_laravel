<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Placeholder dashboard (nanti diganti sesuai penjelasanmu)
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', fn () => view('dashboard.admin'))->name('dashboard.admin');
});

Route::middleware('role:pembeli')->group(function () {
    Route::get('/pembeli/dashboard', fn () => view('dashboard.pembeli'))->name('dashboard.pembeli');
});


Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

Route::resource('kategoris', KategoriController::class);