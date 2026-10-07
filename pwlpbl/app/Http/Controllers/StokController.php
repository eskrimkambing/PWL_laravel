<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Product;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Menampilkan semua data stok
    public function index()
    {
        $stoks = Stok::with('product')
            ->latest('tanggal_stok')
            ->get();

        return view('stoks.index', compact('stoks'));
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

    // Menghapus stok
    public function destroy(Stok $stok)
    {
        $stok->delete();

        return redirect()
            ->route('stoks.index')
            ->with('success', 'Data stok berhasil dihapus!');
    }
}
