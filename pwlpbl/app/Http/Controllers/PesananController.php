<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Menampilkan semua pesanan untuk admin
    public function index()
    {
        $pesanans = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])
            ->latest()
            ->get();

        return view('pesanans.index', compact('pesanans'));
    }

    // Menampilkan detail satu pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])
            ->findOrFail($id);

        return view('pesanans.show', compact('pesanan'));
    }

    // Mengubah status pesanan oleh admin
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Dibatalkan',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('pesanans.index')
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
