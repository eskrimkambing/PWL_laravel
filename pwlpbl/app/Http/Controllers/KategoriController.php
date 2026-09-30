<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::latest()->get();

        return view('kategoris.index', compact('kategoris'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('kategoris.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategoris.edit', compact('kategori'));
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);

        return redirect()
            ->route('kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()
            ->route('kategoris.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}