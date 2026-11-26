<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan.
     */
    public function index(Request $request)
    {
        // Pastikan hanya admin dan pembeli yang bisa mengakses.
        if (!in_array(session('role'), ['admin', 'pembeli'])) {
            abort(403);
        }

        // TAMPILAN PEMBELI
        if (session('role') === 'pembeli') {

            $request->validate([
                'q' => 'nullable|string|max:100',
                'dari' => 'nullable|date_format:Y-m-d',
                'sampai' => 'nullable|date_format:Y-m-d|after_or_equal:dari',
            ], [
                'sampai.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
            ]);

            $cari = trim((string) $request->input('q', ''));
            $dari = $request->input('dari') ?: null;
            $sampai = $request->input('sampai') ?: null;

            $query = Pesanan::with([
                'pembeli',
                'detailPesanans.product'
            ])
                ->where('pembeli_id', session('user_id'));

            // Filter rentang tanggal pesanan dibuat.
            if ($dari) {
                $query->whereDate('created_at', '>=', $dari);
            }

            if ($sampai) {
                $query->whereDate('created_at', '<=', $sampai);
            }

            // Pencarian: ID pesanan, nama produk, jenis, metode pembayaran, atau status.
            if ($cari !== '') {
                $kata = '%' . $cari . '%';
                $idCari = ltrim($cari, '#');

                $query->where(function ($q) use ($kata, $idCari) {
                    if (ctype_digit($idCari)) {
                        $q->orWhere('id_pesanan', (int) $idCari);
                    }

                    $q->orWhere('jenis_pesanan', 'like', $kata)
                        ->orWhere('metode_pembayaran', 'like', $kata)
                        ->orWhere('status', 'like', $kata)
                        ->orWhere('status_pembayaran', 'like', $kata)
                        ->orWhereHas('detailPesanans.product', function ($p) use ($kata) {
                            $p->where('nama', 'like', $kata);
                        });
                });
            }

            $pesanans = $query->latest()->get();

            return view('pesanans.index', compact('pesanans', 'cari', 'dari', 'sampai'));
        }

        // TAMPILAN ADMIN

        // Validasi tanggal pencarian.
        $request->validate([
            'tanggal' => 'nullable|date_format:Y-m-d',
            'q' => 'nullable|string|max:100',
            'urut' => 'nullable|in:waktu,id,total',
            'urutan' => 'nullable|in:asc,desc',
        ]);

        // Jika belum memilih tanggal, tampilkan pesanan hari ini.
        $tanggal = $request->input('tanggal') ?: now()->toDateString();

        // Kata kunci pencarian, pengurutan, dan arah urutan.
        $cari = trim((string) $request->input('q', ''));
        $urut = $request->input('urut', 'waktu');
        $urutan = $request->input('urutan', 'desc');

        // Kolom yang boleh dipakai untuk pengurutan.
        $kolomUrut = [
            'waktu' => 'created_at',
            'id' => 'id_pesanan',
            'total' => 'total_harga',
        ];

        // Total seluruh pesanan.
        $totalPesanan = Pesanan::count();

        // Jumlah pesanan yang masuk hari ini.
        $totalPesananHariIni = Pesanan::whereDate(
            'created_at',
            now()->toDateString()
        )->count();

        // Query pesanan berdasarkan tanggal yang dipilih.
        $query = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->whereDate('created_at', $tanggal);

        // Pencarian: ID pesanan, nama penerima, no. HP, email, atau nama/email pembeli.
        if ($cari !== '') {
            $kataCari = '%' . $cari . '%';
            $idCari = ltrim($cari, '#');

            $query->where(function ($q) use ($kataCari, $idCari) {
                if (ctype_digit($idCari)) {
                    $q->orWhere('id_pesanan', (int) $idCari);
                }

                $q->orWhere('nama_penerima', 'like', $kataCari)
                    ->orWhere('no_telp', 'like', $kataCari)
                    ->orWhere('email', 'like', $kataCari)
                    ->orWhereHas('pembeli', function ($p) use ($kataCari) {
                        $p->where('nama', 'like', $kataCari)
                            ->orWhere('email', 'like', $kataCari);
                    });
            });
        }

        // Jumlah pesanan pada tanggal yang dipilih.
        $jumlahPesananTanggal = (clone $query)->count();

        // Total pendapatan pada tanggal yang dipilih.
        $totalPendapatan = (clone $query)->sum('total_harga');

        // Pengurutan sesuai pilihan (default: waktu, terbaru di atas).
        $kolom = $kolomUrut[$urut] ?? 'created_at';

        // Tampilkan pesanan dengan pagination 10 data per halaman.
        $pesanans = $query
            ->orderBy($kolom, $urutan)
            ->orderBy('id_pesanan', $urutan)
            ->paginate(10)
            ->withQueryString();

        // Kirim data ke halaman Kelola Pesanan admin.
        return view('pesanans.indexAdmin', compact(
            'pesanans',
            'tanggal',
            'totalPesanan',
            'totalPesananHariIni',
            'jumlahPesananTanggal',
            'totalPendapatan',
            'cari',
            'urut',
            'urutan'
        ));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        // Pembeli hanya boleh melihat pesanan miliknya.
        if (session('role') === 'pembeli') {

            abort_unless(
                (int) $pesanan->pembeli_id === (int) session('user_id'),
                403
            );
        } elseif (session('role') !== 'admin') {

            abort(403);
        }

        // Pisahkan tampilan admin dan pembeli.
        if (session('role') === 'admin') {
            return view('pesanans.showAdmin', compact('pesanan'));
        }

        return view('pesanans.show', compact('pesanan'));
    }

    /**
     * Membuat token pembayaran Midtrans.
     */
    public function bayar($id)
    {
        // Hanya pembeli yang boleh melakukan pembayaran.
        abort_unless(session('role') === 'pembeli', 403);

        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        // Pastikan pesanan milik pembeli yang login.
        abort_unless(
            (int) $pesanan->pembeli_id === (int) session('user_id'),
            403
        );

        // Periksa status pembayaran.
        if ($pesanan->status_pembayaran === 'Dibayar') {
            return back()->with(
                'error',
                'Pesanan ini sudah dibayar.'
            );
        }

        // Periksa detail pesanan.
        if ($pesanan->detailPesanans->isEmpty()) {
            return back()->with(
                'error',
                'Detail pesanan tidak ditemukan.'
            );
        }

        $pembeli = $pesanan->pembeli;

        // Periksa konfigurasi Midtrans.
        if (!config('services.midtrans.server_key')) {
            return back()->with(
                'error',
                'Server Key Midtrans belum dikonfigurasi.'
            );
        }

        // Konfigurasi Midtrans.
        Config::$serverKey = config('services.midtrans.server_key');

        Config::$isProduction = (bool) config(
            'services.midtrans.is_production',
            false
        );

        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Siapkan daftar produk untuk pembayaran.
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

        // Data pelanggan.
        $customerDetails = array_filter([
            'first_name' => $pesanan->nama_penerima
                ?: ($pembeli->nama ?? null)
                ?: 'Pembeli',

            'email' => $pembeli->email ?? null,

            'phone' => $pesanan->no_telp
                ?: ($pembeli->no_telp ?? null),
        ]);

        // Data transaksi Midtrans.
        $params = [
            'transaction_details' => [
                'order_id' => 'PZ-' . $pesanan->id_pesanan,
                'gross_amount' => (int) $pesanan->total_harga,
            ],

            'item_details' => $items,

            'customer_details' => $customerDetails,
        ];

        try {

            // Buat token pembayaran.
            $token = Snap::getSnapToken($params);

            // Simpan token ke database.
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

    /**
     * Menampilkan halaman edit pesanan khusus admin.
     */
    public function edit($id)
    {
        abort_unless(session('role') === 'admin', 403);

        $pesanan = Pesanan::with([
            'pembeli',
            'detailPesanans.product'
        ])->findOrFail($id);

        return view('pesanans.edit', compact('pesanan'));
    }

    /**
     * Memperbarui status pesanan oleh admin.
     */
    public function update(Request $request, $id)
    {
        abort_unless(session('role') === 'admin', 403);

        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Pengantaran,Selesai,Dibatalkan',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pesanans.indexAdmin')
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Memperbarui status pembayaran pesanan oleh admin.
     */
    public function updateStatusPembayaran(Request $request, $id)
    {
        abort_unless(session('role') === 'admin', 403);

        $request->validate([
            'status_pembayaran' => 'required|in:Belum Dibayar,Menunggu Pembayaran,Dibayar,Gagal',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // Kelola Transaksi membaca tanggal dari kolom dibayar_pada, jadi kolom ini
        // harus ikut terisi saat admin menandai "Dibayar" (dan dikosongkan kembali
        // kalau statusnya diubah menjadi bukan "Dibayar").
        $pesanan->update([
            'status_pembayaran' => $request->status_pembayaran,
            'dibayar_pada' => $request->status_pembayaran === 'Dibayar'
                ? ($pesanan->dibayar_pada ?? now())
                : null,
        ]);

        return back()->with(
            'success',
            'Status pembayaran berhasil diperbarui!'
        );
    }
}
