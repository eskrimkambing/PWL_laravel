<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class ProfilAdminController extends Controller
{
    public function show()
    {
        $admin = Admin::findOrFail(session('user_id'));

        return view('profil.showAdmin', compact('admin'));
    }

    public function edit()
    {
        $admin = Admin::findOrFail(session('user_id'));

        return view('profil.editAdmin', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // maks 1 MB
        ]);

        $admin = Admin::findOrFail(session('user_id'));

        $data = [];

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

        if (!empty($data)) {
            $admin->update($data);
        }

        return redirect()
            ->route('admin.profil.show')
            ->with('sukses', 'Profil berhasil diperbarui');
    }
}