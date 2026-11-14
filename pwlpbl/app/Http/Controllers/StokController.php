<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    // Menampilkan semua data stok
    public function index()
    {
        // Satu baris per produk, stok = jumlah seluruh penambahan stok produk tsb
        $products = Product::withSum('stoks as total_stok', 'jumlah_stok')
            ->orderBy('id')
            ->get();

        $totalProduk = $products->count();
        $totalStok   = (int) $products->sum('total_stok');

        return view('stoks.index', compact('products', 'totalProduk', 'totalStok'));
    }

    // Menampilkan form tambah stok
    public function create()
    {
        $products = Product::all();

        return view('stoks.create', compact('products'));
    }

    // Menyimpan stok baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'tanggal_stok' => 'required|date',
            'jumlah_stok'  => 'required|integer|min:0',
            'status_stok'  => 'required|string|max:50',
        ]);

        Stok::create($validated);

        return redirect()
            ->route('stoks.index')
            ->with('success', 'Data stok berhasil ditambahkan!');
    }

    // Menampilkan form edit stok
    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        $products = Product::all();

        return view('stoks.edit', compact('stok', 'products'));
    }

    // Memperbarui stok
    public function update(Request $request, Stok $stok)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'tanggal_stok' => 'required|date',
            'jumlah_stok'  => 'required|integer|min:0',
            'status_stok'  => 'required|string|max:50',
        ]);

        $stok->update($validated);

        return redirect()
            ->route('stoks.index')
            ->with('success', 'Data stok berhasil diperbarui!');
    }

    // Mengatur stok sebuah produk ke angka tertentu (boleh 0 untuk Sold Out).
    // Selisihnya dicatat sebagai satu baris koreksi, sehingga total stok
    // produk (jumlah seluruh baris stok) sama persis dengan angka yang diisi.
    public function atur(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stok_baru' => 'required|integer|min:0|max:100000',
        ]);

        DB::transaction(function () use ($product, $validated) {
            // Kunci baris produk agar tidak bentrok dengan pesanan yang sedang masuk.
            Product::whereKey($product->id)->lockForUpdate()->first();

            $sekarang = (int) Stok::where('product_id', $product->id)->sum('jumlah_stok');
            $selisih  = (int) $validated['stok_baru'] - $sekarang;

            if ($selisih !== 0) {
                Stok::create([
                    'product_id'   => $product->id,
                    'tanggal_stok' => now()->toDateString(),
                    'jumlah_stok'  => $selisih,
                    'status_stok'  => 'Koreksi',
                ]);
            }
        });

        return redirect()
            ->route('stoks.index')
            ->with('success', 'Stok ' . $product->nama . ' diatur menjadi ' . $validated['stok_baru'] . '.');
    }

    // Menghapus stok
    public function destroy(Stok $stok)
    {
        $stok->delete();

        return redirect()
            ->route('stoks.index')
            ->with('success', 'Data stok berhasil dihapus!');
    }
}
