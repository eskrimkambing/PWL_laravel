<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pesanan;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan daftar produk + data penerima (diambil dari data pembeli)
    public function index()
    {
        $products = Product::latest()->get();

        $pembeli = Pembeli::findOrFail(session('user_id'));

        return view('checkout.index', compact('products', 'pembeli'));
    }

    // Menyimpan pesanan dari pembeli
    public function store(Request $request)
    {
        $request->validate([
            'products'          => 'required|array',
            'nama_penerima'     => 'required|string|max:100',
            'no_telp'           => 'required|string|max:20',
            'alamat'            => 'required|string|max:500',
            'catatan'           => 'nullable|string|max:500',
            'jenis_pesanan'     => 'required|in:Makan di tempat,Dibungkus',
            'metode_pembayaran' => 'required|in:Cash,Midtrans',
        ]);

        $pembeli = Pembeli::findOrFail(session('user_id'));

        $produkDipilih = collect($request->products)
            ->filter(function ($jumlah) {
                return is_numeric($jumlah) && (int) $jumlah > 0;
            });

        if ($produkDipilih->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Silakan pilih minimal satu produk.');
        }

        $pesanan = DB::transaction(function () use (
            $produkDipilih,
            $request,
            $pembeli
        ) {

            $totalHarga = 0;
            $daftarProduk = [];

            foreach ($produkDipilih as $productId => $jumlah) {

                $product = Product::findOrFail($productId);

                $jumlah = (int) $jumlah;

                $subtotal = $product->price * $jumlah;

                $totalHarga += $subtotal;

                $daftarProduk[] = [
                    'product' => $product,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];
            }

            $pesanan = Pesanan::create([
                'pembeli_id'        => $pembeli->id_pembeli,

                // Data penerima: disalin ke pesanan (boleh berbeda dari profil)
                'nama_penerima'     => $request->nama_penerima,
                'no_telp'           => $request->no_telp,
                'alamat'            => $request->alamat,
                'catatan'           => $request->catatan,

                'total_harga'       => $totalHarga,
                'jenis_pesanan'     => $request->jenis_pesanan,
                'status'            => 'Menunggu',
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $request->metode_pembayaran === 'Cash'
                    ? 'Belum Dibayar'
                    : 'Menunggu Pembayaran',
                'dibayar_pada'      => null,
            ]);

            foreach ($daftarProduk as $item) {

                $pesanan->detailPesanans()->create([
                    'product_id' => $item['product']->getKey(),
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['product']->price,
                    'subtotal' => $item['subtotal'],
                ]);

            }

            return $pesanan;
        });

        return redirect()
            ->route('pesanans.show', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}