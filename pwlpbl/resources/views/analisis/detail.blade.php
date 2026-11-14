@extends('dashboard.admin')

@section('title', 'Detail Perhitungan AHP dan SAW')

@section('content')

<div class="container-fluid">

    {{-- JUDUL --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Detail Perhitungan AHP dan SAW</h3>
        <p class="text-secondary mb-0">
            Rincian pembobotan kriteria dan normalisasi pelanggan
        </p>
    </div>

    {{-- PERIODE --}}
    <div class="card mb-4">
        <div class="card-body">
            <strong>Periode Analisis:</strong>
            {{ \Carbon\Carbon::createFromFormat('!Y-m', $bulan)->translatedFormat('F Y') }}
        </div>
    </div>

    {{-- BOBOT AHP --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">1. Hasil Pembobotan AHP</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Bobot AHP</th>
                            <th>Jenis Kriteria</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>C1</td>
                            <td>Terakhir Belanja</td>
                            <td>{{ number_format($bobot['terakhir_belanja'], 4) }}</td>
                            <td><span class="badge bg-danger">Cost</span></td>
                        </tr>

                        <tr>
                            <td>C2</td>
                            <td>Jumlah Pesanan</td>
                            <td>{{ number_format($bobot['jumlah_pesanan'], 4) }}</td>
                            <td><span class="badge bg-success">Benefit</span></td>
                        </tr>

                        <tr>
                            <td>C3</td>
                            <td>Total Belanja</td>
                            <td>{{ number_format($bobot['total_belanja'], 4) }}</td>
                            <td><span class="badge bg-success">Benefit</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-light border mb-0">
                <strong>Consistency Ratio (CR):</strong> 0,0334
                <br>
                <small>
                    CR kurang dari 0,1 sehingga penilaian perbandingan
                    berpasangan dinyatakan konsisten.
                </small>
            </div>
        </div>
    </div>

    {{-- NORMALISASI SAW --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">2. Hasil Normalisasi SAW</h5>

            <p class="text-secondary">
                Normalisasi dilakukan berdasarkan jenis kriteria:
            </p>

            <ul>
                <li>
                    C1 (Cost) = nilai minimum jarak hari / nilai jarak hari pelanggan.
                </li>
                <li>
                    C2 (Benefit) = jumlah pesanan pelanggan / jumlah pesanan maksimum.
                </li>
                <li>
                    C3 (Benefit) = total belanja pelanggan / total belanja maksimum.
                </li>
            </ul>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Pelanggan</th>
                            <th>Jarak Hari</th>
                            <th>Normalisasi C1</th>
                            <th>Normalisasi C2</th>
                            <th>Normalisasi C3</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ranking as $item)
                            <tr>
                                <td>{{ $item->peringkat }}</td>

                                <td>
                                    {{ $item->nama ?: $item->email }}
                                </td>

                                <td>{{ $item->jarak_hari }}</td>

                                <td>{{ number_format($item->normalisasi_c1, 4) }}</td>

                                <td>{{ number_format($item->normalisasi_c2, 4) }}</td>

                                <td>{{ number_format($item->normalisasi_c3, 4) }}</td>

                                <td class="fw-bold">
                                    {{ number_format($item->nilai_akhir, 4) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    Belum ada data transaksi yang dibayar
                                    pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RUMUS NILAI AKHIR --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">3. Perhitungan Nilai Akhir</h5>

            <p>
                Nilai akhir diperoleh dari penjumlahan hasil normalisasi
                setiap kriteria yang dikalikan dengan bobot AHP.
            </p>

            <div class="p-3 rounded" style="background: #F7D991;">
                <strong>
                    Nilai Akhir =
                    (0,2605 × C1) +
                    (0,6333 × C2) +
                    (0,1062 × C3)
                </strong>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.analisis.index', ['bulan' => $bulan]) }}"
       class="btn btn-outline-secondary">
        ← Kembali ke Perangkingan
    </a>

</div>

@endsection
