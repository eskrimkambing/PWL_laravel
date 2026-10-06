<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PenggunaController;
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

    Route::get('/pengguna', [PenggunaController::class, 'index'])
        ->name('pengguna.index');

    Route::get('/pengguna/create', [PenggunaController::class, 'create'])
        ->name('pengguna.create');

    Route::post('/pengguna', [PenggunaController::class, 'store'])
        ->name('pengguna.store');

    Route::get('/pengguna/{role}/{id}/edit', [PenggunaController::class, 'edit'])
        ->name('pengguna.edit');

    Route::put('/pengguna/{role}/{id}', [PenggunaController::class, 'update'])
        ->name('pengguna.update');

    Route::delete('/pengguna/{role}/{id}', [PenggunaController::class, 'destroy'])
        ->name('pengguna.destroy');

    Route::get('/stoks', [StokController::class, 'index'])
        ->name('stoks.index');

    Route::get('/stoks/create', [StokController::class, 'create'])
        ->name('stoks.create');

    Route::post('/stoks', [StokController::class, 'store'])
        ->name('stoks.store');

    Route::get('/stoks/{id}/edit', [StokController::class, 'edit'])
        ->name('stoks.edit');

    Route::put('/stoks/{id}', [StokController::class, 'update'])
        ->name('stoks.update');

    Route::delete('/stoks/{id}', [StokController::class, 'destroy'])
        ->name('stoks.destroy');
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

    Route::post('/pesanans/{id}/bayar', [PesananController::class, 'bayar'])
        ->name('pesanans.bayar');

    Route::put('/pesanans/{id}', [PesananController::class, 'update'])
        ->name('pesanans.update');

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    Route::get('/profil', [ProfilController::class, 'show'])
        ->name('profil.show');

    Route::get('/profil/edit', [ProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::delete('/profil', [ProfilController::class, 'destroy'])
        ->name('profil.destroy');
});
