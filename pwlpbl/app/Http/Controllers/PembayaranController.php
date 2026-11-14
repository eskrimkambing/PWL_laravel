<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Menampilkan transaksi berdasarkan tanggal pembayaran
    public function index(Request $request)
    {
        $request->validate([
            'tanggal' => 'nullable|date',
        ]);

        // Jika tanggal tidak dipilih, gunakan tanggal hari ini
        $tanggal = $request->filled('tanggal')
            ? $request->input('tanggal')
            : today()->format('Y-m-d');

        // Mengambil transaksi yang sudah dibayar sesuai tanggal
        $query = Pesanan::with('pembeli')
            ->whereNotNull('metode_pembayaran')
            ->where('status_pembayaran', 'Dibayar')
            ->whereNotNull('dibayar_pada')
            ->whereDate('dibayar_pada', $tanggal);

        // Maksimal 10 transaksi per halaman
        $pembayarans = $query
            ->orderBy('id_pesanan', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Menghitung total transaksi yang dibayar hari ini
        $totalTransaksiHariIni = Pesanan::whereNotNull('metode_pembayaran')
            ->where('status_pembayaran', 'Dibayar')
            ->whereNotNull('dibayar_pada')
            ->whereDate('dibayar_pada', today())
            ->count();

        return view('pembayaran.index', compact(
            'pembayarans',
            'totalTransaksiHariIni',
            'tanggal'
        ));
    }

    // Menampilkan form tambah pembayaran
    public function create()
    {
        $pesanans = Pesanan::with('pembeli')
            ->whereNull('metode_pembayaran')
            ->latest('id_pesanan')
            ->get();

        return view('pembayaran.create', compact('pesanans'));
    }

    // Menyimpan pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id_pesanan',
            'metode_pembayaran' => 'required|in:Cash,Midtrans',
            'status_pembayaran' => 'required|in:Belum Dibayar,Menunggu Pembayaran,Dibayar,Gagal',
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        $pesanan->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
            'dibayar_pada' => $request->status_pembayaran === 'Dibayar'
                ? now()
                : null,
        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil ditambahkan.');
    }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $pembayaran = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        return view('pembayaran.show', compact('pembayaran'));
    }

    // Menampilkan form edit pembayaran
    public function edit($id)
    {
        $pembayaran = Pesanan::findOrFail($id);

        return view('pembayaran.edit', compact('pembayaran'));
    }

    // Mengubah pembayaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Cash,Midtrans',
            'status_pembayaran' => 'required|in:Belum Dibayar,Menunggu Pembayaran,Dibayar,Gagal',
        ]);

        $pembayaran = Pesanan::findOrFail($id);

        $pembayaran->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
            'dibayar_pada' => $request->status_pembayaran === 'Dibayar'
                ? now()
                : null,
        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    // Menghapus data pembayaran
    public function destroy($id)
    {
        $pembayaran = Pesanan::findOrFail($id);

        $pembayaran->update([
            'metode_pembayaran' => null,
            'status_pembayaran' => 'Belum Dibayar',
            'dibayar_pada' => null,
            'snap_token' => null,
        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
