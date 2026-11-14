<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalisisKeputusanController extends Controller
{
    // Bobot AHP dari file Excel
    private $bobot = [
        'terakhir_belanja' => 0.2605,
        'jumlah_pesanan'   => 0.6333,
        'total_belanja'    => 0.1062,
    ];

    /**
     * Menampilkan halaman utama analisis.
     */
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            abort(400, 'Format bulan tidak valid.');
        }

        $data = $this->hitungPerangkingan($bulan);

        return view('analisis.index', [
            'bulan' => $bulan,
            'ranking' => $data,
            'topFive' => $data->take(5),
            'totalPelanggan' => $data->count(),
            'totalTransaksi' => $data->sum('jumlah_pesanan'),
            'totalBelanja' => $data->sum('total_belanja'),
            'pemenang' => $data->first(),
        ]);
    }

    /**
     * Menampilkan detail perhitungan AHP dan SAW.
     */
    public function detail(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));

        if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            abort(400, 'Format bulan tidak valid.');
        }

        $data = $this->hitungPerangkingan($bulan);

        return view('analisis.detail', [
            'bulan' => $bulan,
            'ranking' => $data,
            'bobot' => $this->bobot,
        ]);
    }

    /**
     * Mengambil transaksi dibayar dan menghitung nilai SAW.
     */
    private function hitungPerangkingan($bulan)
    {
        $tanggal = Carbon::createFromFormat('!Y-m', $bulan);

        $awalBulan = $tanggal->copy()->startOfMonth();

        // Untuk bulan berjalan, gunakan tanggal hari ini.
        // Untuk bulan sebelumnya, gunakan akhir bulan.
        $akhirPeriode = $tanggal->format('Y-m') === now()->format('Y-m')
            ? now()->endOfDay()
            : $tanggal->copy()->endOfMonth()->endOfDay();

        $pembeli = DB::table('pembeli as p')
            ->join('pesanans as ps', 'ps.pembeli_id', '=', 'p.id_pembeli')
            ->where('ps.status_pembayaran', 'Dibayar')
            ->whereBetween('ps.dibayar_pada', [
                $awalBulan->toDateTimeString(),
                $akhirPeriode->toDateTimeString()
            ])
            ->select(
                'p.id_pembeli',
                'p.nama',
                'p.email',
                DB::raw('COUNT(*) as jumlah_pesanan'),
                DB::raw('SUM(ps.total_harga) as total_belanja'),
                DB::raw('MAX(ps.dibayar_pada) as terakhir_belanja')
            )
            ->groupBy('p.id_pembeli', 'p.nama', 'p.email')
            ->get();

        // Belum ada transaksi dibayar pada periode ini.
        if ($pembeli->isEmpty()) {
            return collect();
        }

        // Menghitung kriteria C1: jarak hari sejak belanja terakhir.
        foreach ($pembeli as $item) {
            $hari = Carbon::parse($item->terakhir_belanja)
                ->startOfDay()
                ->diffInDays($akhirPeriode->copy()->startOfDay());

            // Ditambah 1 agar nilai tidak nol.
            $item->jarak_hari = $hari + 1;
        }

        // Nilai maksimum dan minimum untuk normalisasi SAW.
        $minHari = $pembeli->min('jarak_hari');
        $maxPesanan = $pembeli->max('jumlah_pesanan');
        $maxBelanja = $pembeli->max('total_belanja');

        foreach ($pembeli as $item) {

            // C1: Cost (semakin sedikit hari, semakin baik).
            $item->normalisasi_c1 = $minHari / $item->jarak_hari;

            // C2: Benefit (semakin banyak pesanan, semakin baik).
            $item->normalisasi_c2 = $maxPesanan > 0
                ? $item->jumlah_pesanan / $maxPesanan
                : 0;

            // C3: Benefit (semakin besar belanja, semakin baik).
            $item->normalisasi_c3 = $maxBelanja > 0
                ? $item->total_belanja / $maxBelanja
                : 0;

            // Menghitung nilai akhir SAW.
            $item->nilai_akhir =
                ($this->bobot['terakhir_belanja'] * $item->normalisasi_c1) +
                ($this->bobot['jumlah_pesanan'] * $item->normalisasi_c2) +
                ($this->bobot['total_belanja'] * $item->normalisasi_c3);
        }

        // Urutkan dari nilai tertinggi.
        $ranking = $pembeli->sortByDesc('nilai_akhir')
            ->values();

        // Berikan nomor peringkat.
        foreach ($ranking as $index => $item) {
            $item->peringkat = $index + 1;
        }

        return $ranking;
    }
}
