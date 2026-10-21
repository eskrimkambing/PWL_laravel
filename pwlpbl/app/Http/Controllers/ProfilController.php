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
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // maks 1 MB
        ]);

        $pembeli = Pembeli::findOrFail(session('user_id'));

        $data = $request->only('nama', 'no_telp', 'alamat');

        // Upload foto baru -> simpan sebagai base64 di database
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $data['foto'] = 'data:' . $file->getMimeType() . ';base64,'
                . base64_encode(file_get_contents($file->getRealPath()));
        }

        // Hapus foto (checkbox "hapus_foto"), hanya jika tidak sedang upload foto baru
        if ($request->boolean('hapus_foto') && !$request->hasFile('foto')) {
            $data['foto'] = null;
        }

        $pembeli->update($data);

        return redirect()->route('profil.show')->with('sukses', 'Data berhasil diperbarui');
    }

    /**
     * Password asli tidak pernah ditampilkan (tersimpan hash).
     * Yang ditampilkan hanya representasi samar:
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

    /**
     * Pembeli menghapus akunnya sendiri.
     * Tidak bisa dihapus selama masih ada pesanan yang berjalan
     * (status selain Selesai dan Dibatalkan).
     */
    public function destroy(Request $request)
    {
        $idPembeli = session('user_id');

        $adaPesananBerjalan = Pesanan::where('pembeli_id', $idPembeli)
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->exists();

        if ($adaPesananBerjalan) {
            return redirect()->route('profil.show')
                ->with('error', 'Akun tidak bisa dihapus karena masih ada pesanan yang belum selesai.');
        }

        $pembeli = Pembeli::findOrFail($idPembeli);
        $pembeli->delete();

        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Akun berhasil dihapus');
    }
}