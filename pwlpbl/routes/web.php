<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.proses');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.proses');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('role:admin')->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    Route::resource('products', ProductController::class);

    Route::resource('kategoris', KategoriController::class);

     Route::resource('stoks', StokController::class);
});

Route::middleware('role:pembeli')->group(function () {

    Route::get('/pembeli/dashboard', function () {
        return view('dashboard.pembeli');
    })->name('dashboard.pembeli');

    Route::get('/pembeli/products', [ProductController::class, 'index'])
        ->name('pembeli.products');

    Route::get('/pembeli/kategoris', [KategoriController::class, 'index'])
        ->name('pembeli.kategoris');

    Route::get('/pesanans', [PesananController::class, 'index'])
        ->name('pesanans.index');

    Route::get('/pesanans/{id}', [PesananController::class, 'show'])
        ->name('pesanans.show');

    Route::put('/pesanans/{id}', [PesananController::class, 'update'])
        ->name('pesanans.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});

Route::get('/profil', [ProfilController::class, 'show'])
        ->name('profil.show');

    Route::get('/profil/edit', [ProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::delete('/profil', [ProfilController::class, 'destroy'])
        ->name('profil.destroy');
