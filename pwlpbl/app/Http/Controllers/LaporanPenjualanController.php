<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Product;
use App\Support\SimplePdf;
use App\Support\SimpleXlsx;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPenjualanController extends Controller
{
    /**
     * Halaman laporan penjualan (pesanan berstatus "Selesai").
     */
    public function index(Request $request)
    {
        abort_unless(session('role') === 'admin', 403);

        $data = $this->validasi($request);

        $tabel = $data['tabel'];

        if ($tabel === 'produk') {
            $produk = $this->dataProduk($data['dari'], $data['sampai']);

            return view('laporan.index', [
                'tabel'            => $tabel,
                'dari'             => $data['dari'],
                'sampai'           => $data['sampai'],
                'produk'           => $produk,
                'totalJumlah'      => $produk->sum('jumlah'),
                'totalPendapatan'  => $produk->sum('pendapatan'),
            ]);
        }

        $pesanans = $this->queryPesanan($data['dari'], $data['sampai'])->get();

        return view('laporan.index', [
            'tabel'            => $tabel,
            'dari'             => $data['dari'],
            'sampai'           => $data['sampai'],
            'pesanans'         => $pesanans,
            'totalPendapatan'  => $pesanans->sum('total_harga'),
        ]);
    }

    /**
     * Ekspor hasil filter ke file Excel (.xlsx) atau PDF (?format=pdf).
     * Tabel yang diekspor mengikuti tabel yang sedang dipilih.
     */
    public function export(Request $request)
    {
        abort_unless(session('role') === 'admin', 403);

        $data = $this->validasi($request);

        $dari   = $data['dari'];
        $sampai = $data['sampai'];

        $periode = $this->labelPeriode($dari, $sampai);
        $suffix  = ($dari || $sampai)
            ? '_' . ($dari ?: 'awal') . '_sd_' . ($sampai ?: 'sekarang')
            : '_semua';

        if ($data['format'] === 'pdf') {
            return $this->exportPdf($data['tabel'], $dari, $sampai, $periode, $suffix);
        }

        if ($data['tabel'] === 'produk') {
            $produk = $this->dataProduk($dari, $sampai);

            $xlsx = (new SimpleXlsx('Laporan Produk'))
                ->lebarKolom([8, 40, 22, 24])
                ->judul('Laporan Penjualan Per Produk - Pizza Moza')
                ->catatan('Periode: ' . $periode)
                ->kosong()
                ->baris(['No', 'Produk', 'Total Produk Dipesan', 'Total Pendapatan (Rp)'], 'header');

            foreach ($produk as $i => $p) {
                $xlsx->baris(
                    [$i + 1, $p['nama'], (int) $p['jumlah'], (int) $p['pendapatan']],
                    null,
                    [2 => 'angka', 3 => 'angka']
                );
            }

            $xlsx->baris(['', 'TOTAL', (int) $produk->sum('jumlah'), (int) $produk->sum('pendapatan')], 'total');

            return $xlsx->unduh('laporan-penjualan-produk' . $suffix . '.xlsx');
        }

        $pesanans = $this->queryPesanan($dari, $sampai)->get();

        $xlsx = (new SimpleXlsx('Laporan Pesanan'))
            ->lebarKolom([8, 12, 28, 40, 18, 22])
            ->judul('Laporan Penjualan Per Pesanan - Pizza Moza')
            ->catatan('Periode: ' . $periode)
            ->kosong()
            ->baris(['No', 'ID Pesanan', 'Nama Pembeli', 'Produk yang Dibeli', 'Jumlah per Produk', 'Total Harga Pesanan (Rp)'], 'header');

        foreach ($pesanans as $i => $pesanan) {
            $namaProduk = $pesanan->detailPesanans
                ->map(fn($d) => $d->product->nama ?? 'Produk dihapus')
                ->implode("\n");

            $jumlah = $pesanan->detailPesanans
                ->map(fn($d) => (string) $d->jumlah)
                ->implode("\n");

            $xlsx->baris(
                [
                    $i + 1,
                    $pesanan->id_pesanan,
                    $this->namaPembeli($pesanan),
                    $namaProduk,
                    $jumlah,
                    (int) $pesanan->total_harga,
                ],
                null,
                [2 => 'wrap', 3 => 'wrap', 4 => 'wrap', 5 => 'angka']
            );
        }

        $xlsx->baris(['', '', '', '', 'TOTAL', (int) $pesanans->sum('total_harga')], 'total');

        return $xlsx->unduh('laporan-penjualan-pesanan' . $suffix . '.xlsx');
    }

    /**
     * Ekspor ke PDF sesuai tabel yang dipilih.
     */
    private function exportPdf(string $tabel, ?string $dari, ?string $sampai, string $periode, string $suffix)
    {
        if ($tabel === 'produk') {
            $isi  = $this->pdfProduk($this->dataProduk($dari, $sampai), $periode);
            $nama = 'laporan-penjualan-produk' . $suffix . '.pdf';
        } else {
            $isi  = $this->pdfPesanan($this->queryPesanan($dari, $sampai)->get(), $periode);
            $nama = 'laporan-penjualan-pesanan' . $suffix . '.pdf';
        }

        return response($isi, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $nama . '"',
        ]);
    }

    private function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }

    private function footerPdf(): string
    {
        return 'Pizza Moza - dicetak ' . Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB';
    }

    private function pdfPesanan($pesanans, string $periode): string
    {
        $totalPendapatan = $pesanans->sum('total_harga');

        $pdf = new SimplePdf(
            'Laporan Penjualan Per Pesanan',
            [
                'Periode: ' . $periode,
                'Total pesanan selesai: ' . $pesanans->count() . '   |   Total pendapatan: ' . $this->rupiah($totalPendapatan),
            ],
            [
                ['label' => 'No',                 'lebar' => 28,  'rata' => 'C'],
                ['label' => 'ID',                 'lebar' => 38,  'rata' => 'L'],
                ['label' => 'Nama Pembeli',       'lebar' => 90,  'rata' => 'L'],
                ['label' => 'Produk yang Dibeli', 'lebar' => 150, 'rata' => 'L'],
                ['label' => 'Jumlah per Produk',  'lebar' => 48,  'rata' => 'C'],
                ['label' => 'Total Harga Pesanan', 'lebar' => 80, 'rata' => 'R'],
            ],
            $this->footerPdf()
        );

        foreach ($pesanans as $i => $pesanan) {
            $pdf->baris([
                (string) ($i + 1),
                '#' . $pesanan->id_pesanan,
                $this->namaPembeli($pesanan),
                $pesanan->detailPesanans->map(fn($d) => $d->product->nama ?? 'Produk dihapus')->all(),
                $pesanan->detailPesanans->map(fn($d) => (string) $d->jumlah)->all(),
                $this->rupiah($pesanan->total_harga),
            ]);
        }

        if ($pesanans->isEmpty()) {
            $pdf->barisTotal([
                ['teks' => 'Tidak ada pesanan selesai pada periode ini.', 'span' => 6, 'rata' => 'C'],
            ]);
        } else {
            $pdf->barisTotal([
                ['teks' => 'Total', 'span' => 5, 'rata' => 'R'],
                ['teks' => $this->rupiah($totalPendapatan), 'rata' => 'R'],
            ]);
        }

        return $pdf->output();
    }

    private function pdfProduk($produk, string $periode): string
    {
        $totalJumlah     = $produk->sum('jumlah');
        $totalPendapatan = $produk->sum('pendapatan');

        $pdf = new SimplePdf(
            'Laporan Penjualan Per Produk',
            [
                'Periode: ' . $periode,
                'Total produk terjual: ' . number_format($totalJumlah, 0, ',', '.') . '   |   Total pendapatan: ' . $this->rupiah($totalPendapatan),
            ],
            [
                ['label' => 'No',                   'lebar' => 30,  'rata' => 'C'],
                ['label' => 'Produk',               'lebar' => 230, 'rata' => 'L'],
                ['label' => 'Total Produk Dipesan', 'lebar' => 90,  'rata' => 'C'],
                ['label' => 'Total Pendapatan',     'lebar' => 110, 'rata' => 'R'],
            ],
            $this->footerPdf()
        );

        foreach ($produk as $i => $p) {
            $pdf->baris([
                (string) ($i + 1),
                $p['nama'],
                number_format($p['jumlah'], 0, ',', '.'),
                $this->rupiah($p['pendapatan']),
            ]);
        }

        $pdf->barisTotal([
            ['teks' => 'Total', 'span' => 2, 'rata' => 'R'],
            ['teks' => number_format($totalJumlah, 0, ',', '.'), 'rata' => 'C'],
            ['teks' => $this->rupiah($totalPendapatan), 'rata' => 'R'],
        ]);

        return $pdf->output();
    }

    // ------------------------------------------------------------------
    // Helper
    // ------------------------------------------------------------------

    private function validasi(Request $request): array
    {
        $valid = $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
            'tabel'  => 'nullable|in:pesanan,produk',
            'format' => 'nullable|in:xlsx,pdf',
        ], [
            'dari.date'              => 'Tanggal awal tidak valid.',
            'sampai.date'            => 'Tanggal akhir tidak valid.',
            'sampai.after_or_equal'  => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
        ]);

        return [
            'dari'   => $valid['dari'] ?? null,
            'sampai' => $valid['sampai'] ?? null,
            'tabel'  => $valid['tabel'] ?? 'pesanan',
            'format' => $valid['format'] ?? 'xlsx',
        ];
    }

    /**
     * Pesanan yang sudah selesai, difilter berdasarkan tanggal pesanan dibuat.
     */
    private function filterSelesai($query, ?string $dari, ?string $sampai)
    {
        return $query
            ->where('status', 'Selesai')
            ->when($dari, fn($q) => $q->whereDate('created_at', '>=', $dari))
            ->when($sampai, fn($q) => $q->whereDate('created_at', '<=', $sampai));
    }

    private function queryPesanan(?string $dari, ?string $sampai)
    {
        return $this->filterSelesai(
            Pesanan::with(['pembeli', 'detailPesanans.product']),
            $dari,
            $sampai
        )->orderByDesc('created_at')->orderByDesc('id_pesanan');
    }

    /**
     * Semua produk, diurutkan dari yang paling banyak dipesan.
     * Produk yang belum pernah dipesan di rentang tersebut tetap tampil (jumlah 0).
     */
    private function dataProduk(?string $dari, ?string $sampai)
    {
        $rekap = DetailPesanan::query()
            ->selectRaw('product_id, SUM(jumlah) as total_jumlah, SUM(subtotal) as total_pendapatan')
            ->whereHas('pesanan', fn($q) => $this->filterSelesai($q, $dari, $sampai))
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        return Product::orderBy('nama')->get()
            ->map(fn($p) => [
                'nama'       => $p->nama,
                'jumlah'     => (int) ($rekap[$p->id]->total_jumlah ?? 0),
                'pendapatan' => (int) ($rekap[$p->id]->total_pendapatan ?? 0),
            ])
            ->sortBy([['jumlah', 'desc'], ['nama', 'asc']])
            ->values();
    }

    private function namaPembeli(Pesanan $pesanan): string
    {
        return $pesanan->nama_penerima
            ?: ($pesanan->pembeli->nama ?? null)
            ?: ($pesanan->pembeli->email ?? null)
            ?: '-';
    }

    private function labelPeriode(?string $dari, ?string $sampai): string
    {
        $fmt = fn($t) => Carbon::parse($t)->format('d/m/Y');

        if ($dari && $sampai) {
            return $fmt($dari) . ' s/d ' . $fmt($sampai);
        }
        if ($dari) {
            return 'Mulai ' . $fmt($dari);
        }
        if ($sampai) {
            return 'Sampai ' . $fmt($sampai);
        }

        return 'Semua waktu';
    }
}