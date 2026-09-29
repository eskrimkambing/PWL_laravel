<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pembeli;
use App\Models\Product;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin', [
            'totalProduk' => Product::count(),
            'totalKategori' => Kategori::count(),
            'totalPembeli' => Pembeli::count(),
        ]);
    }
}
