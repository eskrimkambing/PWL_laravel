<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 1. READ: Mengambil semua data dari database
    public function index()
    {
        $products = Product::with('sizes')->latest()->get();
        return view('products.index', compact('products'));
    }

    // Menampilkan produk khusus pembeli
    public function pembeli()
    {
        $products = Product::withStok()->latest()->get();

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
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|string',
            'portion'   => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sizes'          => 'required|array|min:1',
            'sizes.*.nama'   => 'required|string|max:50',
            'sizes.*.harga'  => 'required|numeric|min:0',
        ], [
            'sizes.required'      => 'Tambahkan minimal satu ukuran beserta harganya.',
            'sizes.min'           => 'Tambahkan minimal satu ukuran beserta harganya.',
            'sizes.*.nama.required'  => 'Nama ukuran wajib diisi.',
            'sizes.*.harga.required' => 'Harga setiap ukuran wajib diisi.',
            'sizes.*.harga.numeric'  => 'Harga ukuran harus berupa angka.',
        ]);

        $sizes = array_values($validated['sizes']);
        unset($validated['sizes']);

        // Harga produk = harga ukuran terendah (untuk tampilan "Mulai dari").
        $validated['price'] = min(array_map(fn ($s) => (float) $s['harga'], $sizes));
        $validated['portion'] = $validated['portion'] ?? '';

        // Gambar opsional: hanya diubah ke base64 kalau ada file yang diupload
        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageToBase64($request->file('image'));
        } else {
            unset($validated['image']);
        }

        DB::transaction(function () use ($validated, $sizes) {
            $product = Product::create($validated);
            $this->simpanUkuran($product, $sizes);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan ke database!');
    }

    // 3. EDIT: Mengambil data spesifik berdasarkan ID dari database
    public function edit(Product $product)
    {
        $kategoris = \App\Models\Kategori::all();

        $product->load('sizes');

        return view('products.edit', compact('product', 'kategoris'));
    }

    // 4. EDIT: Memperbarui record di database
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|string',
            'portion'   => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sizes'          => 'required|array|min:1',
            'sizes.*.nama'   => 'required|string|max:50',
            'sizes.*.harga'  => 'required|numeric|min:0',
        ], [
            'sizes.required'      => 'Tambahkan minimal satu ukuran beserta harganya.',
            'sizes.min'           => 'Tambahkan minimal satu ukuran beserta harganya.',
            'sizes.*.nama.required'  => 'Nama ukuran wajib diisi.',
            'sizes.*.harga.required' => 'Harga setiap ukuran wajib diisi.',
            'sizes.*.harga.numeric'  => 'Harga ukuran harus berupa angka.',
        ]);

        $sizes = array_values($validated['sizes']);
        unset($validated['sizes']);

        // Harga produk = harga ukuran terendah (untuk tampilan "Mulai dari").
        $validated['price'] = min(array_map(fn ($s) => (float) $s['harga'], $sizes));
        $validated['portion'] = $validated['portion'] ?? '';

        // Kalau tidak upload gambar baru, gambar lama tetap dipakai
        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageToBase64($request->file('image'));
        } else {
            unset($validated['image']);
        }

        DB::transaction(function () use ($product, $validated, $sizes) {
            $product->update($validated);
            $this->simpanUkuran($product, $sizes);
        });

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

    // Mengganti seluruh ukuran produk dengan daftar dari form.
    // Riwayat pesanan aman karena detail pesanan menyimpan nama ukuran & harga sendiri.
    private function simpanUkuran(Product $product, array $sizes): void
    {
        $product->sizes()->delete();

        foreach ($sizes as $i => $size) {
            $product->sizes()->create([
                'nama'   => trim($size['nama']),
                'harga'  => $size['harga'],
                'urutan' => $i,
            ]);
        }
    }

    // Mengubah file gambar menjadi teks base64 (data URI)
    private function imageToBase64($file): string
    {
        return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
    }
}
