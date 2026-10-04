<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PembeliController extends Controller
{
    // Menampilkan semua data pembeli
    public function index()
    {
        $pembelis = Pembeli::latest('id_pembeli')->get();

        return view('pembelis.index', compact('pembelis'));
    }

    // Menampilkan form tambah pembeli
    public function create()
    {
        return view('pembelis.create');
    }

    // Menyimpan pembeli baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pembeli,email|unique:admin,email',
            'password' => 'required|string|min:6',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Pembeli::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('pembelis.index')
            ->with('success', 'Data pembeli berhasil ditambahkan.');
    }

    // Menampilkan detail pembeli
    public function show($id)
    {
        $pembeli = Pembeli::findOrFail($id);

        return view('pembelis.show', compact('pembeli'));
    }

    // Menampilkan form edit pembeli
    public function edit($id)
    {
        $pembeli = Pembeli::findOrFail($id);

        return view('pembelis.edit', compact('pembeli'));
    }

    // Memperbarui data pembeli
    public function update(Request $request, $id)
    {
        $pembeli = Pembeli::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('pembeli', 'email')
                    ->ignore($pembeli->id_pembeli, 'id_pembeli'),
                Rule::unique('admin', 'email'),
            ],
            'password' => 'nullable|string|min:6',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ];

        // Password hanya diganti jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pembeli->update($data);

        return redirect()
            ->route('pembelis.index')
            ->with('success', 'Data pembeli berhasil diperbarui.');
    }

    // Menghapus data pembeli
    public function destroy($id)
    {
        $pembeli = Pembeli::findOrFail($id);

        // Mencegah akun yang sedang login menghapus dirinya sendiri
        if (
            session('role') === 'pembeli' &&
            (int) session('user_id') === (int) $pembeli->id_pembeli
        ) {
            return back()->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dihapus.'
            );
        }

        $pembeli->delete();

        return redirect()
            ->route('pembelis.index')
            ->with('success', 'Data pembeli berhasil dihapus.');
    }
}
