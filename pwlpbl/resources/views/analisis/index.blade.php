@extends('dashboard.admin')

@section('title', 'Analisis Keputusan')

@section('content')

<div class="container-fluid">

    {{-- JUDUL HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Analisis Keputusan</h3>
            <p class="text-secondary mb-0">
                Perangkingan pelanggan menggunakan metode AHP dan SAW
            </p>
        </div>
    </div>

    {{-- FILTER BULAN --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.analisis.index') }}"
                  method="GET"
                  class="row align-items-end g-3">

                <div class="col-md-4">
                    <label for="bulan" class="form-label fw-semibold">
                        Periode Analisis
                    </label>

                    <input type="month"
                           name="bulan"
                           id="bulan"
                           class="form-control"
                           value="{{ $bulan }}"
                           required>
                </div>

                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- RINGKASAN DATA --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">
                        Total Pelanggan
                    </div>
                    <h3 class="fw-bold mb-0">
                        {{ $totalPelanggan }}
                    </h3>
                    <small class="text-secondary">
                        Pelanggan dengan transaksi dibayar
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">
                        Total Pesanan
                    </div>
                    <h3 class="fw-bold mb-0">
                        {{ $totalTransaksi }}
                    </h3>
                    <small class="text-secondary">
                        Transaksi berstatus Dibayar
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-secondary mb-2">
                        Total Belanja
                    </div>
                    <h3 class="fw-bold mb-0">
                        Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                    </h3>
                    <small class="text-secondary">
                        Akumulasi pembelian pelanggan
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- PELANGGAN PERINGKAT PERTAMA --}}
    @if ($pemenang)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-1">🏆</div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            Pelanggan Peringkat Pertama
                        </h5>

                        <h4 class="mb-1">
                            {{ $pemenang->nama ?: $pemenang->email }}
                        </h4>

                        <span class="text-secondary">
                            Nilai akhir:
                            <strong>
                                {{ number_format($pemenang->nilai_akhir, 4) }}
                            </strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- TABEL PERANGKINGAN --}}
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        Hasil Perangkingan Pelanggan
                    </h5>
                    <small class="text-secondary">
                        Berdasarkan perhitungan AHP dan SAW
                    </small>
                </div>

                <a href="{{ route('admin.analisis.detail', ['bulan' => $bulan]) }}"
                   class="btn btn-outline-secondary">
                    Detail Perhitungan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Jumlah Pesanan</th>
                            <th>Total Belanja</th>
                            <th>Terakhir Belanja</th>
                            <th>Nilai Akhir</th>
                            <th>Peringkat</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ranking as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $item->nama ?: '-' }}
                                </td>

                                <td>{{ $item->email }}</td>

                                <td>{{ $item->jumlah_pesanan }}</td>

                                <td>
                                    Rp {{ number_format($item->total_belanja, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->terakhir_belanja)->format('d-m-Y') }}
                                </td>

                                <td class="fw-bold">
                                    {{ number_format($item->nilai_akhir, 4) }}
                                </td>

                                <td>
                                    @if ($item->peringkat == 1)
                                        <span class="badge bg-success">
                                            🥇 1
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $item->peringkat }}
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Belum ada transaksi berstatus Dibayar
                                    pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
