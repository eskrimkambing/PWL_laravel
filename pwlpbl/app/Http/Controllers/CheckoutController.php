<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan daftar produk untuk pembeli
    public function index()
    {
        $products = Product::latest()->get();

        return view('checkout.index', compact('products'));
    }

    // Menyimpan pesanan dari pembeli
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'jenis_pesanan' => 'required|in:Makan di tempat,Dibungkus',
        ]);

        $produkDipilih = collect($request->products)
            ->filter(function ($jumlah) {
                return (int) $jumlah > 0;
            });

        if ($produkDipilih->isEmpty()) {
            return back()
                ->with('error', 'Silakan pilih minimal satu produk.');
        }

        $pesanan = DB::transaction(function () use ($produkDipilih, $request) {

            $totalHarga = 0;

            foreach ($produkDipilih as $productId => $jumlah) {

                $product = Product::findOrFail($productId);

                $subtotal = $product->price * (int) $jumlah;

                $totalHarga += $subtotal;
            }

            $pesanan = Pesanan::create([
                'pembeli_id' => session('user_id'),
                'total_harga' => $totalHarga,
                'jenis_pesanan' => $request->jenis_pesanan,
                'status' => 'Menunggu',
            ]);

            foreach ($produkDipilih as $productId => $jumlah) {

                $product = Product::findOrFail($productId);

                $jumlah = (int) $jumlah;

                $subtotal = $product->price * $jumlah;

                $pesanan->detailPesanans()->create([
                    'product_id' => $product->getKey(),
                    'jumlah' => $jumlah,
                    'harga' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            return $pesanan;
        });

        return redirect()
            ->route('pesanans.show', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}