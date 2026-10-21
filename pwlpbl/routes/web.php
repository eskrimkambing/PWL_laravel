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
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;


// ==========================================================
// ROUTE UMUM
// ==========================================================

Route::get('/', function () {
    return redirect()->route('login');
});


// ==========================================================
// AUTH
// ==========================================================

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


// ==========================================================
// ROUTE ADMIN
// ==========================================================

Route::middleware('role:admin')->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');


    // ======================================================
    // PRODUK
    // ======================================================

    Route::resource('products', ProductController::class);


    // ======================================================
    // KATEGORI
    // ======================================================

    Route::resource('kategoris', KategoriController::class);


    // ======================================================
    // PEMBELI
    // ======================================================

    Route::resource('pembelis', PembeliController::class);


    // ======================================================
    // PEMBAYARAN
    // ======================================================

    Route::resource('pembayaran', PembayaranController::class);


   // ======================================================
// KELOLA PESANAN ADMIN
// ======================================================

// Menampilkan semua pesanan
Route::get('/admin/pesanans', [PesananController::class, 'index'])
    ->name('admin.pesanans.indexAdmin');

// Detail pesanan (admin)
Route::get('/admin/pesanans/{id}', [PesananController::class, 'show'])
    ->name('admin.pesanans.show');

// Halaman edit pesanan
Route::get('/admin/pesanans/{id}/edit', [PesananController::class, 'edit'])
    ->name('admin.pesanans.edit');

// Simpan perubahan pesanan
Route::put('/admin/pesanans/{id}', [PesananController::class, 'update'])
    ->name('admin.pesanans.update');


    // ======================================================
    // PENGGUNA
    // ======================================================

    Route::get('/pengguna', [PenggunaController::class, 'index'])
        ->name('pengguna.index');

    Route::get('/pengguna/create', [PenggunaController::class, 'create'])
        ->name('pengguna.create');

    Route::post('/pengguna', [PenggunaController::class, 'store'])
        ->name('pengguna.store');

    Route::get('/pengguna/{role}/{id}/edit', [PenggunaController::class, 'edit'])
        ->name('pengguna.edit');

    Route::delete('/pengguna/{role}/{id}', [PenggunaController::class, 'destroy'])
        ->name('pengguna.destroy');


    // ======================================================
    // STOK
    // ======================================================

    Route::get('/stoks', [StokController::class, 'index'])
        ->name('stoks.index');

    Route::get('/stoks/create', [StokController::class, 'create'])
        ->name('stoks.create');

    Route::post('/stoks', [StokController::class, 'store'])
        ->name('stoks.store');

    Route::get('/stoks/{id}/edit', [StokController::class, 'edit'])
        ->name('stoks.edit');

    Route::put('/stoks/{stok}', [StokController::class, 'update'])
        ->name('stoks.update');

    Route::delete('/stoks/{stok}', [StokController::class, 'destroy'])
        ->name('stoks.destroy');

});


// ==========================================================
// ROUTE PEMBELI
// ==========================================================

Route::middleware('role:pembeli')->group(function () {

    // Dashboard Pembeli
    Route::get('/pembeli/dashboard', function () {

        $products = \App\Models\Product::latest()->get();

        return view('dashboard.pembeli', compact('products'));

    })->name('dashboard.pembeli');


    // ======================================================
    // PRODUK PEMBELI
    // ======================================================

    Route::get('/pembeli/products', [ProductController::class, 'pembeli'])
        ->name('pembeli.products');


    // ======================================================
    // KATEGORI PEMBELI
    // ======================================================

    Route::get('/pembeli/kategoris', [KategoriController::class, 'index'])
        ->name('pembeli.kategoris');


    // ======================================================
    // PESANAN PEMBELI
    // ======================================================

    Route::get('/pesanans', [PesananController::class, 'index'])
        ->name('pesanans.index');

    Route::get('/pesanans/{id}', [PesananController::class, 'show'])
        ->name('pesanans.show');

    Route::post('/pesanans/{id}/bayar', [PesananController::class, 'bayar'])
        ->name('pesanans.bayar');

    Route::put('/pesanans/{id}', [PesananController::class, 'update'])
        ->name('pesanans.update');


    // ======================================================
    // CHECKOUT
    // ======================================================

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');


    // ======================================================
    // PROFIL
    // ======================================================

    Route::get('/profil', [ProfilController::class, 'show'])
        ->name('profil.show');

    Route::get('/profil/edit', [ProfilController::class, 'edit'])
        ->name('profil.edit');

    Route::put('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');

    Route::delete('/profil', [ProfilController::class, 'destroy'])
        ->name('profil.destroy');

});