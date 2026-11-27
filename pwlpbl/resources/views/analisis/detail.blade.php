@extends('dashboard.admin')

@section('title', 'Cara Perhitungan Pelanggan Setia')

@section('content')

@php
    // ================= AHP: dihitung langkah demi langkah =================
    $kode = ['C1', 'C2', 'C3'];
    $namaKriteria = ['Terakhir Belanja', 'Jumlah Pesanan', 'Total Belanja'];
    $n = 3;

    // Matriks perbandingan berpasangan (skala Saaty) - sesuai file Excel
    $A = [
        [1,     1 / 3, 3],
        [3,     1,     5],
        [1 / 3, 1 / 5, 1],
    ];
    $teksA = [
        ['1', '1/3', '3'],
        ['3', '1', '5'],
        ['1/3', '1/5', '1'],
    ];

    // Langkah 1: jumlah tiap kolom
    $jumlahKolom = [];
    for ($j = 0; $j < $n; $j++) {
        $jumlahKolom[$j] = 0;
        for ($i = 0; $i < $n; $i++) {
            $jumlahKolom[$j] += $A[$i][$j];
        }
    }

    // Langkah 2: normalisasi (sel / jumlah kolom) dan bobot (rata-rata baris)
    $R = [];
    $w = [];
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $R[$i][$j] = $A[$i][$j] / $jumlahKolom[$j];
        }
        $w[$i] = array_sum($R[$i]) / $n;
    }

    // Langkah 3: A x w, lalu dibagi w untuk mendapat lambda tiap baris
    $Aw = [];
    $lambda = [];
    for ($i = 0; $i < $n; $i++) {
        $Aw[$i] = 0;
        for ($j = 0; $j < $n; $j++) {
            $Aw[$i] += $A[$i][$j] * $w[$j];
        }
        $lambda[$i] = $Aw[$i] / $w[$i];
    }

    // Langkah 4: lambda maks, CI, CR
    $lamMaks = array_sum($lambda) / $n;
    $CI = ($lamMaks - $n) / ($n - 1);
    $RI = 0.58; // Random Index untuk n = 3
    $CR = $CI / $RI;

    // ================= SAW: nilai pembanding =================
    $minHari    = $ranking->min('jarak_hari');
    $maxPesanan = $ranking->max('jumlah_pesanan');
    $maxBelanja = $ranking->max('total_belanja');

    // Pembantu format angka (koma desimal, 4 digit)
    $f  = fn ($x, $d = 4) => number_format($x, $d, ',', '.');
    $rp = fn ($x) => number_format($x, 0, ',', '.');
@endphp

<style>
    .rumus-singkat {
        background: #F9ECE8;
        border-left: 4px solid #8B1A0F;
        border-radius: .35rem;
        padding: .45rem .9rem;
        margin: .4rem 0 .9rem;
        font-size: .95rem;
    }
    .langkah-judul { font-weight: 700; color: #8B1A0F; margin-top: 1.4rem; }
    .tabel-hitung td, .tabel-hitung th { white-space: nowrap; font-size: .9rem; }
    details.langkah-detail { margin-top: .5rem; }
    details.langkah-detail > summary {
        cursor: pointer; font-weight: 600; color: #8B1A0F; margin-bottom: .6rem;
    }
</style>

<div class="container-fluid">

    {{-- JUDUL --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Cara Perhitungan Pelanggan Setia</h3>
        <p class="text-secondary mb-0">
            Langkah-langkah perhitungan dari data awal sampai nilai akhir
        </p>
    </div>

    {{-- PERIODE --}}
    <div class="card mb-4">
        <div class="card-body">
            <strong>Periode:</strong>
            {{ \Carbon\Carbon::createFromFormat('!Y-m', $bulan)->translatedFormat('F Y') }}
        </div>
    </div>

    {{-- ===================== 1. AHP ===================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">1. Pembobotan Kriteria dengan AHP</h5>

            {{-- Langkah 1 --}}
            <div class="langkah-judul">Langkah 1 — Matriks perbandingan berpasangan</div>
            <div class="rumus-singkat">Jumlah kolom = a₁ⱼ + a₂ⱼ + a₃ⱼ</div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center align-middle tabel-hitung w-auto">
                    <thead>
                        <tr><th>Kriteria</th>@foreach ($kode as $k)<th>{{ $k }}</th>@endforeach</tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $n; $i++)
                            <tr>
                                <th>{{ $kode[$i] }} <small class="fw-normal text-secondary">({{ $namaKriteria[$i] }})</small></th>
                                @for ($j = 0; $j < $n; $j++)
                                    <td>{{ $teksA[$i][$j] }}@if (!in_array($teksA[$i][$j], ['1','3','5'])) = {{ $f($A[$i][$j]) }}@endif</td>
                                @endfor
                            </tr>
                        @endfor
                        <tr class="table-light fw-bold">
                            <td>Jumlah</td>
                            @for ($j = 0; $j < $n; $j++)
                                <td>
                                    @for ($i = 0; $i < $n; $i++){{ $f($A[$i][$j]) }}@if ($i < $n - 1) + @endif @endfor
                                    = {{ $f($jumlahKolom[$j]) }}
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Langkah 2 --}}
            <div class="langkah-judul">Langkah 2 — Normalisasi matriks dan bobot kriteria</div>
            <div class="rumus-singkat">
                Normalisasi = sel ÷ jumlah kolom &nbsp;|&nbsp; Bobot = rata-rata nilai pada baris
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center align-middle tabel-hitung">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($kode as $k)<th>{{ $k }}</th>@endforeach
                            <th>Bobot (rata-rata baris)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $n; $i++)
                            <tr>
                                <th>{{ $kode[$i] }}</th>
                                @for ($j = 0; $j < $n; $j++)
                                    <td>{{ $f($A[$i][$j]) }} ÷ {{ $f($jumlahKolom[$j]) }} = {{ $f($R[$i][$j]) }}</td>
                                @endfor
                                <td class="fw-bold">
                                    ({{ $f($R[$i][0]) }} + {{ $f($R[$i][1]) }} + {{ $f($R[$i][2]) }}) ÷ 3
                                    = {{ $f($w[$i]) }}
                                </td>
                            </tr>
                        @endfor
                        <tr class="table-light fw-bold">
                            <td colspan="4" class="text-end">Total bobot</td>
                            <td>{{ $f(array_sum($w)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Langkah 3 --}}
            <div class="langkah-judul">Langkah 3 — Uji konsistensi (λ maks, CI, CR)</div>
            <div class="rumus-singkat">
                A × w = Σ (aᵢⱼ × wⱼ) &nbsp;|&nbsp; λ = (A × w) ÷ w
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-center align-middle tabel-hitung">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>A × w</th>
                            <th>Bobot (w)</th>
                            <th>λ = (A × w) ÷ w</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $n; $i++)
                            <tr>
                                <th>{{ $kode[$i] }}</th>
                                <td>
                                    ({{ $f($A[$i][0]) }} × {{ $f($w[0]) }}) +
                                    ({{ $f($A[$i][1]) }} × {{ $f($w[1]) }}) +
                                    ({{ $f($A[$i][2]) }} × {{ $f($w[2]) }})
                                    = {{ $f($Aw[$i]) }}
                                </td>
                                <td>{{ $f($w[$i]) }}</td>
                                <td>{{ $f($Aw[$i]) }} ÷ {{ $f($w[$i]) }} = <strong>{{ $f($lambda[$i]) }}</strong></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="rumus-singkat">
                λ maks = Σλ ÷ n &nbsp;|&nbsp; CI = (λ maks − n) ÷ (n − 1) &nbsp;|&nbsp; CR = CI ÷ RI
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle tabel-hitung w-auto">
                    <tbody>
                        <tr>
                            <th>λ maks</th>
                            <td>({{ $f($lambda[0]) }} + {{ $f($lambda[1]) }} + {{ $f($lambda[2]) }}) ÷ {{ $n }} = <strong>{{ $f($lamMaks) }}</strong></td>
                        </tr>
                        <tr>
                            <th>CI</th>
                            <td>({{ $f($lamMaks) }} − {{ $n }}) ÷ ({{ $n }} − 1) = <strong>{{ $f($CI) }}</strong></td>
                        </tr>
                        <tr>
                            <th>RI (n = {{ $n }})</th>
                            <td>{{ $f($RI, 2) }}</td>
                        </tr>
                        <tr>
                            <th>CR</th>
                            <td>{{ $f($CI) }} ÷ {{ $f($RI, 2) }} = <strong>{{ $f($CR) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert {{ $CR < 0.1 ? 'alert-success' : 'alert-danger' }} mb-3">
                <strong>CR = {{ $f($CR) }}</strong> —
                @if ($CR < 0.1)
                    kurang dari 0,1 sehingga penilaian perbandingan berpasangan dinyatakan konsisten.
                @else
                    lebih dari atau sama dengan 0,1 sehingga penilaian perbandingan perlu ditinjau ulang.
                @endif
            </div>

            {{-- Ringkasan bobot --}}
            <div class="langkah-judul">Hasil bobot AHP</div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr><th>Kode</th><th>Kriteria</th><th>Bobot AHP</th><th>Jenis Kriteria</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>C1</td><td>Terakhir Belanja</td>
                            <td>{{ number_format($bobot['terakhir_belanja'], 4, ',', '.') }}</td>
                            <td><span class="badge bg-danger">Cost</span></td>
                        </tr>
                        <tr>
                            <td>C2</td><td>Jumlah Pesanan</td>
                            <td>{{ number_format($bobot['jumlah_pesanan'], 4, ',', '.') }}</td>
                            <td><span class="badge bg-success">Benefit</span></td>
                        </tr>
                        <tr>
                            <td>C3</td><td>Total Belanja</td>
                            <td>{{ number_format($bobot['total_belanja'], 4, ',', '.') }}</td>
                            <td><span class="badge bg-success">Benefit</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================== 2. DATA AWAL ===================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">2. Data Awal Pelanggan</h5>

            @if ($ranking->isEmpty())
                <p class="text-center py-3 mb-0">Belum ada data transaksi yang dibayar pada periode ini.</p>
            @else
                <p class="text-secondary">
                    Jarak hari = selisih hari dari belanja terakhir ke akhir periode, ditambah 1 agar tidak nol.
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle tabel-hitung">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>C1 — Jarak Hari</th>
                                <th>C2 — Jumlah Pesanan</th>
                                <th>C3 — Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ranking as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->nama ?: $item->email }}</td>
                                    <td>{{ $item->jarak_hari }}</td>
                                    <td>{{ $item->jumlah_pesanan }}</td>
                                    <td>Rp {{ $rp($item->total_belanja) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-light fw-bold">
                                <td colspan="2">Nilai pembanding</td>
                                <td>min = {{ $minHari }}</td>
                                <td>max = {{ $maxPesanan }}</td>
                                <td>max = Rp {{ $rp($maxBelanja) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @if ($ranking->isNotEmpty())

    {{-- ===================== 3. NORMALISASI SAW ===================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">3. Normalisasi SAW</h5>

            <div class="rumus-singkat">
                <span class="badge bg-danger">C1 Cost</span> r = min ÷ nilai pelanggan
            </div>
            <div class="rumus-singkat">
                <span class="badge bg-success">C2 &amp; C3 Benefit</span> r = nilai pelanggan ÷ max
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle tabel-hitung">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>C1 = {{ $minHari }} ÷ jarak hari</th>
                            <th>C2 = pesanan ÷ {{ $maxPesanan }}</th>
                            <th>C3 = belanja ÷ {{ $rp($maxBelanja) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ranking as $item)
                            <tr>
                                <td>{{ $item->nama ?: $item->email }}</td>
                                <td>{{ $minHari }} ÷ {{ $item->jarak_hari }} = <strong>{{ $f($item->normalisasi_c1) }}</strong></td>
                                <td>{{ $item->jumlah_pesanan }} ÷ {{ $maxPesanan }} = <strong>{{ $f($item->normalisasi_c2) }}</strong></td>
                                <td>{{ $rp($item->total_belanja) }} ÷ {{ $rp($maxBelanja) }} = <strong>{{ $f($item->normalisasi_c3) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================== 4. NILAI AKHIR ===================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">4. Perhitungan Nilai Akhir</h5>

            <div class="rumus-singkat">
                Nilai akhir = ({{ $f($bobot['terakhir_belanja']) }} × C1) +
                ({{ $f($bobot['jumlah_pesanan']) }} × C2) +
                ({{ $f($bobot['total_belanja']) }} × C3)
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle tabel-hitung">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Pelanggan</th>
                            <th>{{ $f($bobot['terakhir_belanja']) }} × C1</th>
                            <th>{{ $f($bobot['jumlah_pesanan']) }} × C2</th>
                            <th>{{ $f($bobot['total_belanja']) }} × C3</th>
                            <th>Nilai Akhir (jumlah)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ranking as $item)
                            @php
                                $s1 = $bobot['terakhir_belanja'] * $item->normalisasi_c1;
                                $s2 = $bobot['jumlah_pesanan']   * $item->normalisasi_c2;
                                $s3 = $bobot['total_belanja']    * $item->normalisasi_c3;
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $item->peringkat }}</td>
                                <td>{{ $item->nama ?: $item->email }}</td>
                                <td>{{ $f($bobot['terakhir_belanja']) }} × {{ $f($item->normalisasi_c1) }} = {{ $f($s1) }}</td>
                                <td>{{ $f($bobot['jumlah_pesanan']) }} × {{ $f($item->normalisasi_c2) }} = {{ $f($s2) }}</td>
                                <td>{{ $f($bobot['total_belanja']) }} × {{ $f($item->normalisasi_c3) }} = {{ $f($s3) }}</td>
                                <td class="fw-bold">
                                    {{ $f($s1) }} + {{ $f($s2) }} + {{ $f($s3) }}
                                    = {{ $f($item->nilai_akhir) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="text-secondary mb-0">
                Pelanggan dengan nilai akhir tertinggi menempati peringkat 1.
            </p>
        </div>
    </div>

    @endif

    <a href="{{ route('admin.analisis.index', ['bulan' => $bulan]) }}"
       class="btn btn-outline-secondary">
        ← Kembali ke Perangkingan
    </a>

</div>

@endsection