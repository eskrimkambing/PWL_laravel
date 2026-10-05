<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        $pembelis = Pembeli::all();

        return view('pengguna.index', compact('admins', 'pembelis'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:admin,pembeli',
            'email'    => ['required', 'email', Rule::unique('admin', 'email'), Rule::unique('pembeli', 'email')],
            'password' => 'required|min:6',
            'nama'     => 'nullable|string|max:100',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        if ($request->role === 'admin') {
            Admin::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } else {
            Pembeli::create([
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'nama'     => $request->nama,
                'no_telp'  => $request->no_telp,
                'alamat'   => $request->alamat,
            ]);
        }

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna berhasil ditambahkan');
    }

    public function edit(string $role, int $id)
    {
        $pengguna = $this->cariPengguna($role, $id);

        return view('pengguna.edit', compact('pengguna', 'role'));
    }

    public function update(Request $request, string $role, int $id)
    {
        $pengguna = $this->cariPengguna($role, $id);

        $request->validate([
            'email'    => [
                'required', 'email',
                Rule::unique('admin', 'email')->ignore($role === 'admin' ? $id : null, 'id_admin'),
                Rule::unique('pembeli', 'email')->ignore($role === 'pembeli' ? $id : null, 'id_pembeli'),
            ],
            'password' => 'nullable|min:6',
            'nama'     => 'nullable|string|max:100',
            'no_telp'  => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        $data = ['email' => $request->email];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($role === 'pembeli') {
            $data['nama']    = $request->nama;
            $data['no_telp'] = $request->no_telp;
            $data['alamat']  = $request->alamat;
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('sukses', 'Data pengguna diperbarui');
    }

    public function destroy(string $role, int $id)
    {
        if ($role === 'admin' && (int) $id === (int) session('user_id') && session('role') === 'admin') {
            return redirect()->route('pengguna.index')
                ->with('error', 'Tidak bisa menghapus akun admin yang sedang login.');
        }

        $pengguna = $this->cariPengguna($role, $id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna dihapus');
    }

    private function cariPengguna(string $role, int $id)
    {
        return $role === 'admin'
            ? Admin::findOrFail($id)
            : Pembeli::findOrFail($id);
    }
}