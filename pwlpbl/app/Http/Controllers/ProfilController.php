<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use App\Models\Pesanan;          
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show()
    {
        $pembeli = Pembeli::findOrFail(session('user_id'));

        return view('profil.show', [
            'pembeli' => $pembeli,
            'passwordSamar' => $this->samarkanPassword($pembeli->password),
        ]);
    }

    public function edit()
    {
        $pembeli = Pembeli::findOrFail(session('user_id'));
        return view('profil.edit', compact('pembeli'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat'  => 'required|string',
        ]);

        $pembeli = Pembeli::findOrFail(session('user_id'));
        $pembeli->update($request->only('nama', 'no_telp', 'alamat'));

        return redirect()->route('profil.show')->with('sukses', 'Data berhasil diperbarui');
    }

    /**
     * Password asli tidak pernah ditampilkan (tersimpan hash).
     * Yang ditampilkan hanya representasi samar dari panjang aslinya:
     * 3 karakter pertama (dari hash) lalu sisanya "*".
     * Catatan: karena password disimpan hash (bcrypt), ini bukan 3 huruf
     * password asli, hanya tampilan placeholder yang konsisten.
     */
    private function samarkanPassword(string $hash): string
    {
        $depan = substr($hash, 0, 3);
        $sisa = str_repeat('*', 8); // panjang tampilan tetap, tidak membocorkan panjang hash asli
        return $depan . $sisa;
    }
    public function destroy(Request $request)
    {
        $idPembeli = session('user_id');

        // --- tambahan: cek dulu ada pesanan yang belum selesai atau tidak
        $adaPesananBelumSelesai = Pesanan::where('pembeli_id', $idPembeli)
            ->where('status', '!=', 'selesai')
            ->exists();

        if ($adaPesananBelumSelesai) {
            return redirect()->route('profil.show')
                ->with('error', 'Akun tidak bisa dihapus karena masih ada pesanan yang belum selesai.');
        }
        // --- sampai sini

        $pembeli = Pembeli::findOrFail($idPembeli);
        $pembeli->delete();

        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Akun berhasil dihapus');
    }
}