@extends('dashboard.admin')

@section('title', 'Laporan Penjualan')

@push('styles')
    <style>
        .tab-tabel .btn {
            border-radius: 10px;
        }

        .tab-tabel .btn.aktif {
            background: var(--moza-orange);
            border-color: var(--moza-orange);
            color: #fff;
            font-weight: 600;
        }

        .tab-tabel .btn:not(.aktif) {
            background: transparent;
            border: 1px solid rgba(106, 8, 1, 0.35);
            color: var(--moza-maroon);
        }

        .tab-tabel .btn:not(.aktif):hover {
            background: rgba(106, 8, 1, 0.08);
        }

        .daftar-produk {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .daftar-produk li + li {
            margin-top: 4px;
        }

        .table tfoot td {
            background: var(--moza-cream);
            font-weight: 700;
        }
    </style>
@endpush

@section('content')

    @php
        $adaFilter = $dari || $sampai;
        $paramFilter = array_filter(['dari' => $dari, 'sampai' => $sampai]);
    @endphp

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Laporan Penjualan</h2>
            <p class="text-secondary mb-0">
                Rekap pesanan yang sudah selesai
            </p>
        </div>

       
    </div>

    {{-- ERROR VALIDASI FILTER --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- FILTER --}}
    <div class="card p-3 mb-4">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 align-items-end">

            <input type="hidden" name="tabel" value="{{ $tabel }}">

            <div class="col-md-3 col-sm-6">
                <label for="dari" class="form-label fw-semibold mb-1">Dari tanggal</label>
                <input type="date" id="dari" name="dari" class="form-control" value="{{ $dari }}">
            </div>

            <div class="col-md-3 col-sm-6">
                <label for="sampai" class="form-label fw-semibold mb-1">Sampai tanggal</label>
                <input type="date" id="sampai" name="sampai" class="form-control" value="{{ $sampai }}">
            </div>

            <div class="col-md-6 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-moza">
                    Terapkan Filter
                </button>

                @if ($adaFilter)
                    <a href="{{ route('admin.laporan.index', ['tabel' => $tabel]) }}"
                        class="btn btn-outline-secondary">
                        Reset
                    </a>
                @endif

                <div class="d-flex flex-wrap gap-2 ms-md-auto">
                    <a href="{{ route('admin.laporan.export', array_merge($paramFilter, ['tabel' => $tabel, 'format' => 'xlsx'])) }}"
                        class="btn btn-outline-secondary">
                        Ekspor Excel
                    </a>

                    <a href="{{ route('admin.laporan.export', array_merge($paramFilter, ['tabel' => $tabel, 'format' => 'pdf'])) }}"
                        class="btn btn-outline-secondary">
                        Ekspor PDF
                    </a>
                </div>
            </div>

        </form>

        <div class="text-secondary small mt-3">
            Tanggal difilter berdasarkan tanggal pesanan dibuat.
            @if (!$adaFilter)
                Saat ini menampilkan data dari semua waktu.
            @endif
        </div>
    </div>

    {{-- PILIHAN TABEL --}}
    <div class="tab-tabel d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.laporan.index', array_merge($paramFilter, ['tabel' => 'pesanan'])) }}"
            class="btn {{ $tabel === 'pesanan' ? 'aktif' : '' }}">
            Tabel Pesanan
        </a>

        <a href="{{ route('admin.laporan.index', array_merge($paramFilter, ['tabel' => 'produk'])) }}"
            class="btn {{ $tabel === 'produk' ? 'aktif' : '' }}">
            Tabel Produk
        </a>
    </div>

    {{-- ========================= TABEL PESANAN ========================= --}}
    @if ($tabel === 'pesanan')

        <div class="card p-3">

            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                <div class="text-secondary">
                    Total pesanan selesai:
                    <strong class="text-dark">{{ $pesanans->count() }}</strong>
                </div>

                <div class="text-secondary">
                    Total pendapatan:
                    <strong class="text-dark">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>ID</th>
                            <th>Nama Pembeli</th>
                            <th>Produk yang Dibeli</th>
                            <th class="text-center">Jumlah per Produk</th>
                            <th class="text-end">Total Harga Pesanan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanans as $pesanan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-bold">#{{ $pesanan->id_pesanan }}</td>

                                <td>
                                    {{ $pesanan->nama_penerima ?: ($pesanan->pembeli->nama ?? null ?: ($pesanan->pembeli->email ?? '-')) }}
                                </td>

                                <td>
                                    <ul class="daftar-produk">
                                        @foreach ($pesanan->detailPesanans as $detail)
                                            <li>{{ $detail->product->nama ?? 'Produk dihapus' }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="text-center">
                                    <ul class="daftar-produk">
                                        @foreach ($pesanan->detailPesanans as $detail)
                                            <li>{{ $detail->jumlah }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="text-end fw-bold">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-5">
                                    Tidak ada pesanan selesai
                                    {{ $adaFilter ? 'pada rentang tanggal tersebut.' : 'saat ini.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($pesanans->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end">Total</td>
                                <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif

                </table>
            </div>
        </div>

    {{-- ========================= TABEL PRODUK ========================= --}}
    @else

        <div class="card p-3">

            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                <div class="text-secondary">
                    Total produk terjual:
                    <strong class="text-dark">{{ number_format($totalJumlah, 0, ',', '.') }}</strong>
                </div>

                <div class="text-secondary">
                    Total pendapatan:
                    <strong class="text-dark">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Produk</th>
                            <th class="text-center">Total Produk Dipesan</th>
                            <th class="text-end">Total Pendapatan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($produk as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $p['nama'] }}</td>
                                <td class="text-center">{{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($p['pendapatan'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-5">
                                    Belum ada produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($produk->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end">Total</td>
                                <td class="text-center">{{ number_format($totalJumlah, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    @endif

                </table>
            </div>
        </div>

    @endif

@endsection