<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Pembeli;
use App\Models\Pesanan;
use App\Models\Product;
use App\Models\Stok;

class DashboardController extends Controller
{
    public function admin()
    {
        // ---------- Kartu total (tetap) ----------
        $totalProduk   = Product::count();
        $totalKategori = Kategori::count();
        $totalPembeli  = Pembeli::count();

        // ---------- Pendapatan (pesanan yang sudah Dibayar) ----------
        $dibayar = Pesanan::where('status_pembayaran', 'Dibayar')
            ->get(['id_pesanan', 'total_harga', 'dibayar_pada', 'created_at'])
            ->map(fn($p) => [
                'waktu' => $p->dibayar_pada ?? $p->created_at,
                'total' => (int) $p->total_harga,
            ])
            ->filter(fn($row) => $row['waktu'] !== null);

        // Per jam, hari ini
        $perJam = array_fill(0, 24, 0);
        foreach ($dibayar as $row) {
            if ($row['waktu']->isToday()) {
                $perJam[(int) $row['waktu']->format('G')] += $row['total'];
            }
        }
        $labelHari = [];
        for ($i = 0; $i < 24; $i++) {
            $labelHari[] = sprintf('%02d:00', $i);
        }
        $dataHari = array_values($perJam);

        // Per bulan, 12 bulan terakhir (dipotong di browser untuk 1/3/6/12 bulan)
        $labelBulan = [];
        $dataBulan  = [];
        $mulai = now()->subMonths(11)->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $tgl = $mulai->copy()->addMonths($i);
            $labelBulan[] = $tgl->copy()->locale('id')->translatedFormat('M Y');
            $dataBulan[]  = $dibayar
                ->filter(fn($row) => $row['waktu']->format('Y-m') === $tgl->format('Y-m'))
                ->sum('total');
        }

        // ---------- Rekap pesanan ----------
        $pesananSelesai    = Pesanan::where('status', 'Selesai')->count();
        $pesananBatal      = Pesanan::where('status', 'Dibatalkan')->count();
        $pesananBelum      = Pesanan::whereIn('status', ['Menunggu', 'Diproses'])->count();

        // ---------- Transaksi terakhir (sama dengan menu Kelola Transaksi) ----------
        $transaksiTerakhir = Pesanan::with('pembeli')
            ->whereNotNull('metode_pembayaran')
            ->latest('id_pesanan')
            ->take(5)
            ->get()
            ->map(fn($p) => [
                'id'      => $p->id_pesanan,
                'pembeli' => $p->nama_penerima
                    ?? $p->pembeli->nama
                    ?? $p->pembeli->email
                    ?? '-',
                'total'   => (int) $p->total_harga,
                'metode'  => $p->metode_pembayaran,
                'status'  => $p->status_pembayaran,
                'waktu'   => optional($p->dibayar_pada ?? $p->created_at)->diffForHumans() ?? '-',
            ]);

        // ---------- Produk terlaris (dari detail pesanan, tidak termasuk yang dibatalkan) ----------
        $terlaris = DetailPesanan::with('product')
            ->selectRaw('product_id, SUM(jumlah) as terjual')
            ->whereHas('pesanan', fn($q) => $q->where('status', '!=', 'Dibatalkan'))
            ->groupBy('product_id')
            ->orderByDesc('terjual')
            ->take(5)
            ->get();
        $labelTerlaris = $terlaris->map(fn($d) => $d->product->nama ?? 'Produk dihapus')->values();
        $dataTerlaris  = $terlaris->map(fn($d) => (int) $d->terjual)->values();

        // ---------- Produk per kategori ----------
        $perKategori = Product::selectRaw('kategori, COUNT(*) as jumlah')
            ->groupBy('kategori')
            ->pluck('jumlah', 'kategori');
        $labelKategori = $perKategori->keys()->values();
        $dataKategori  = $perKategori->values()->map(fn($v) => (int) $v)->values();

        // ---------- Stok per produk (8 stok paling sedikit) ----------
        $stokProduk = Stok::with('product')
            ->get()
            ->groupBy('product_id')
            ->map(fn($rows) => [
                'nama'   => $rows->first()->product->nama ?? 'Produk dihapus',
                'jumlah' => (int) $rows->sum('jumlah_stok'),
            ])
            ->sortBy('jumlah')
            ->take(8)
            ->values();
        $labelStok = $stokProduk->pluck('nama');
        $dataStok  = $stokProduk->pluck('jumlah');

        // ---------- Pengguna ----------
        $totalAdmin = Admin::count();

        return view('dashboard.admin_home', compact(
            'totalProduk',
            'totalKategori',
            'totalPembeli',
            'totalAdmin',
            'labelHari',
            'dataHari',
            'labelBulan',
            'dataBulan',
            'pesananSelesai',
            'pesananBelum',
            'pesananBatal',
            'transaksiTerakhir',
            'labelTerlaris',
            'dataTerlaris',
            'labelKategori',
            'dataKategori',
            'labelStok',
            'dataStok'
        ));
    }
}
