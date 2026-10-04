<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        $pesanans = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->latest()->get();

        return view('pesanans.index', compact('pesanans'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        // Pembeli hanya boleh melihat pesanannya sendiri
        if (session('role') === 'pembeli') {
            abort_unless(
                (int) $pesanan->pembeli_id ===
                (int) session('user_id'),
                403
            );
        }

        return view('pesanans.show', compact('pesanan'));
    }

    // Membuat token pembayaran Midtrans
    public function bayar($id)
    {
        abort_unless(session('role') === 'pembeli', 403);

        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        // Memastikan pesanan milik pembeli yang login
        abort_unless(
            (int) $pesanan->pembeli_id ===
            (int) session('user_id'),
            403
        );

        if ($pesanan->status_pembayaran === 'Dibayar') {
            return back()->with(
                'error',
                'Pesanan ini sudah dibayar.'
            );
        }

        if ($pesanan->detailPesanans->isEmpty()) {
            return back()->with(
                'error',
                'Detail pesanan tidak ditemukan.'
            );
        }

        $pembeli = $pesanan->pembeli;

        if (!$pembeli) {
            return back()->with(
                'error',
                'Data pembeli tidak ditemukan.'
            );
        }

        if (!config('services.midtrans.server_key')) {
            return back()->with(
                'error',
                'Server Key Midtrans belum dikonfigurasi.'
            );
        }

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config(
            'services.midtrans.is_production',
            false
        );
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $items = [];

        foreach ($pesanan->detailPesanans as $detail) {
            if (!$detail->product) {
                return back()->with(
                    'error',
                    'Data produk tidak ditemukan.'
                );
            }

            $namaProduk = $detail->product->name
                ?? $detail->product->nama_produk
                ?? 'Produk';

            $items[] = [
                'id' => (string) $detail->product_id,
                'price' => (int) $detail->harga,
                'quantity' => (int) $detail->jumlah,
                'name' => mb_substr($namaProduk, 0, 50),
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'PZ-' . $pesanan->id_pesanan,
                'gross_amount' => (int) $pesanan->total_harga,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $pembeli->nama ?: 'Pembeli',
                'email' => $pembeli->email,
                'phone' => $pembeli->no_telp ?? '',
            ],
        ];

        try {
            $token = Snap::getSnapToken($params);

            $pesanan->update([
                'snap_token' => $token,
            ]);

            return redirect()
                ->route('pesanans.show', $pesanan->id_pesanan)
                ->with('success', 'Token pembayaran berhasil dibuat.')
                ->with('snap_token', $token);

        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                'Pembayaran gagal dibuat. Periksa konfigurasi Midtrans dan log Laravel.'
            );
        }
    }

    // Memperbarui status pesanan oleh admin
    public function update(Request $request, $id)
    {
        abort_unless(session('role') === 'admin', 403);

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