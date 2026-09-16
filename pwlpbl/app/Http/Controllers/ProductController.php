<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Mengambil data dari session; jika belum ada, pakai data awal menu Pizza Moza
    public function index(Request $request)
    {
        $products = $request->session()->get('products', [
            [
                'id'          => 1,
                'name'        => 'Pizza Meat Lovers Moza',
                'category'    => 'Pizza',
                'price'       => 45000,
                'portion'     => 'Medium (2-3 Orang)',
                'description' => 'Topping sosis sapi, daging cincang, dan ekstra keju mozzarella lumer.'
            ],
            [
                'id'          => 2,
                'name'        => 'Tape Bakar Keju Manis',
                'category'    => 'Tape Bakar',
                'price'       => 18000,
                'portion'     => '1 Porsi (1-2 Orang)',
                'description' => 'Tape singkong pilihan dibakar dengan taburan keju dan susu kental manis.'
            ]
        ]);

        // Simpan data default ke session agar siap dimanipulasi
        if (!$request->session()->has('products')) {
            $request->session()->put('products', $products);
        }

        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('products.create');
    }

    // Menambah data baru ke dalam session
    public function store(Request $request)
    {
        $products = $request->session()->get('products', []);

        $newProduct = [
            'id'          => time(), // Membuat ID unik simulasi menggunakan timestamp
            'name'        => $request->input('name'),
            'category'    => $request->input('category'),
            'price'       => (float) $request->input('price'),
            'portion'     => $request->input('portion'),
            'description' => $request->input('description'),
        ];

        $products[] = $newProduct;
        $request->session()->put('products', $products);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan ke katalog!');
    }

    // Menampilkan form edit produk berdasarkan ID
    public function edit(Request $request, $id)
    {
        $products = $request->session()->get('products', []);
        $product = collect($products)->firstWhere('id', (int) $id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }

        return view('products.edit', compact('product'));
    }

    // Memperbarui item dalam array session
    public function update(Request $request, $id)
    {
        $products = $request->session()->get('products', []);

        foreach ($products as $key => $item) {
            if ($item['id'] == (int) $id) {
                $products[$key]['name']        = $request->input('name');
                $products[$key]['category']    = $request->input('category');
                $products[$key]['price']       = (float) $request->input('price');
                $products[$key]['portion']     = $request->input('portion');
                $products[$key]['description'] = $request->input('description');
                break;
            }
        }

        $request->session()->put('products', $products);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    // Menghapus data dari array session
    public function destroy(Request $request, $id)
    {
        $products = $request->session()->get('products', []);
        
        // Filter array untuk membuang elemen dengan ID yang sesuai
        $filtered = array_values(array_filter($products, fn($item) => $item['id'] != (int) $id));

        $request->session()->put('products', $filtered);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}