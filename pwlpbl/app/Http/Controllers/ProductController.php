<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. READ: Mengambil semua data dari database
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    // Menampilkan produk khusus pembeli
    public function pembeli()
    {
        $products = Product::latest()->get();

        return view('pembelis.products', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $kategoris = \App\Models\Kategori::all();

        return view('products.create', compact('kategoris'));
    }

    // 2. Menyimpan data baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'category'    => 'required|string',
            'harga_satuan'=> 'required|numeric|min:0',
            'portion'     => 'required|string',
            'deskripsi'   => 'nullable|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        // Ubah file gambar jadi teks base64 sebelum disimpan
        $validated['image'] = $this->imageToBase64($request->file('image'));

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan ke database!');
    }

    // 3. EDIT: Mengambil data spesifik berdasarkan ID dari database
    public function edit(Product $product)
    {
        $kategoris = \App\Models\Kategori::all();

        return view('products.edit', compact('product', 'kategoris'));
    }

    // 4. EDIT: Memperbarui record di database
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'price'       => 'required|numeric|min:0',
            'portion'     => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageToBase64($request->file('image'));
        } else {
            unset($validated['image']);
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui!');
    }

    // 5. DELETE: Menghapus data dari database
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // Mengubah file gambar menjadi teks base64 (data URI)
    private function imageToBase64($file): string
    {
        return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
    }
}