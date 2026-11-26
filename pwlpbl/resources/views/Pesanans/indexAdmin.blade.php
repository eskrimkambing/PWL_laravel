@extends('dashboard.admin')

@section('title', 'Kelola Pesanan')

@push('styles')
    <style>
        /* KARTU RINGKASAN */
        .summary-card {
            background: #F9ECE8;
            border: 1px solid rgba(139, 26, 16, 0.10);
            border-radius: 14px;
            padding: 18px 22px;
            color: #8B1A10;
        }

        .summary-label {
            color: #9B5140;
            font-size: var(--fs-sm);
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: var(--fs-lg);
            font-weight: 700;
            color: #8B1A10;
        }

        /* KARTU TABEL */
        .order-table-card {
            background: #FFFFFF;
            border: 1px solid rgba(139, 26, 16, 0.10);
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 3px 10px rgba(139, 26, 16, 0.05);
        }

        #tabelPesanan {
            margin-bottom: 0;
            color: #8B1A10;
        }

        #tabelPesanan thead th {
            background: #F9ECE8;
            color: #8B1A10;
            font-weight: 700;
            padding: 13px 10px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(139, 26, 16, 0.12);
        }

        #tabelPesanan tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(139, 26, 16, 0.10);
        }

        #tabelPesanan tbody tr:hover {
            background: #FDF3F0;
        }

        /* DROPDOWN STATUS */
        .status-dropdown {
            min-width: 145px;
            border-radius: 7px;
            font-size: var(--fs-sm);
            font-weight: 600;
            padding: 7px 25px 7px 10px;
            cursor: pointer;
            border: 1px solid rgba(139, 26, 16, 0.20);
            background-color: #FDF3F0;
            color: #8B1A10;
        }

        .status-dropdown:focus {
            border-color: #E8751A;
            box-shadow: 0 0 0 0.15rem rgba(232, 117, 26, 0.15);
            outline: none;
        }

        /* TOTAL PENDAPATAN */
        .revenue-card {
            background: #F9ECE8;
            border: 1px solid rgba(139, 26, 16, 0.10);
            border-radius: 14px;
            padding: 14px 18px;
            color: #8B1A10;
        }

        .revenue-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 2px solid #E8751A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--fs-xl);
            color: #E8751A;
        }

        .revenue-label {
            font-size: var(--fs-sm);
            font-weight: 700;
            margin-bottom: 2px;
        }

        .revenue-value {
            font-size: var(--fs-xl);
            font-weight: 800;
            color: #8B1A10;
        }

        /* TOMBOL CARI */
        .btn-cari {
            background: #E8751A;
            color: white;
            border: 1px solid #E8751A;
            border-radius: 7px;
            padding: 9px 22px;
            font-weight: 600;
        }

        .btn-cari:hover {
            background: #C95F0F;
            color: white;
        }

        /* PAGINATION */
        .pagination {
            gap: 4px;
            margin-bottom: 0;
        }

        .pagination .page-link {
            color: #8B1A10;
            background-color: #FFFFFF;
            border: 1px solid rgba(139, 26, 16, 0.15);
            border-radius: 6px;
            min-width: 36px;
            text-align: center;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            color: #8B1A10;
            background-color: #F9ECE8;
            border-color: #E8751A;
        }

        .pagination .page-item.active .page-link {
            background-color: #E8751A;
            border-color: #E8751A;
            color: white;
            font-weight: 600;
        }

        .pagination .page-item.disabled .page-link {
            color: #b8a99a;
            background-color: #FFFFFF;
        }

        .pagination-info {
            color: rgba(139, 26, 16, 0.7);
            font-size: var(--fs-sm);
        }

        .filter-bar {
            background: #FFFFFF;
            border: 1px solid rgba(139, 26, 16, 0.10);
            border-radius: 14px;
            padding: 16px 18px;
        }

        .filter-control {
            border-radius: 8px;
            border: 1px solid rgba(139, 26, 16, 0.20);
            color: #3b1d12;
            font-size: var(--fs-sm);
            padding: 9px 12px;
        }

        .filter-control:focus {
            border-color: #E8751A;
            box-shadow: 0 0 0 0.15rem rgba(232, 117, 26, 0.15);
        }

        .btn-reset {
            background: #FFFFFF;
            color: #8B1A10;
            border: 1px solid rgba(139, 26, 16, 0.25);
            border-radius: 7px;
            padding: 9px 22px;
            font-weight: 600;
        }

        .btn-reset:hover {
            background: #F9ECE8;
            color: #8B1A10;
        }

        @media (max-width: 768px) {
            .revenue-value {
                font-size: var(--fs-xl);
            }

            .summary-value {
                font-size: var(--fs-xl);
            }
        }
    </style>
@endpush

@section('content')

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Pesanan</h2>
            <p class="text-secondary mb-0">
                Daftar pesanan Pizza Moza per hari
            </p>
        </div>

        <div class="text-secondary">
            Total pesanan:
            <strong class="text-dark">
                {{ number_format($totalPesanan, 0, ',', '.') }}
            </strong>
        </div>
    </div>

    {{-- RINGKASAN HARI INI --}}
    <div class="summary-card mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="summary-label">Tanggal Hari Ini</div>
                <div class="summary-value">
                    {{ now()->format('d-m-Y') }}
                </div>
            </div>

            <div class="text-end">
                <div class="summary-label">Total Pesanan Hari Ini</div>
                <div class="summary-value">
                    {{ number_format($totalPesananHariIni, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER: TANGGAL, PENCARIAN, DAN PENGURUTAN --}}
    <form action="{{ url()->current() }}" method="GET" class="filter-bar mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-12 col-md-6 col-xl-3">
                <label class="form-label text-secondary small mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="form-control filter-control" value="{{ $tanggal }}"
                    required>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <label class="form-label text-secondary small mb-1">Cari Pesanan</label>
                <input type="search" name="q" class="form-control filter-control" value="{{ $cari }}"
                    placeholder="ID (mis. 38), nama, no. HP, atau email">
            </div>

            <div class="col-12 d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-cari">
                    <i class="bi bi-search"></i> Terapkan
                </button>

                @if ($cari !== '')
                    <a href="{{ url()->current() }}?tanggal={{ $tanggal }}" class="btn btn-reset">
                        Reset
                    </a>
                @endif
            </div>

        </div>
    </form>

    {{-- TABEL PESANAN --}}
    <div class="order-table-card">
        <div class="table-responsive">
            <table class="table align-middle" id="tabelPesanan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pesanan</th>
                        <th>Pembeli</th>
                        <th>Jam</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanans as $pesanan)
                        <tr class="baris-pesanan">

                            {{-- NOMOR --}}
                            <td>
                                {{ $pesanans->firstItem() + $loop->index }}
                            </td>

                            {{-- ID PESANAN --}}
                            <td class="fw-bold">
                                #{{ $pesanan->id_pesanan }}
                            </td>

                            {{-- PEMBELI --}}
                            <td>
                                {{ $pesanan->nama_penerima ?? ($pesanan->pembeli->nama ?? ($pesanan->pembeli->email ?? '-')) }}
                            </td>

                            {{-- JAM --}}
                            <td class="text-nowrap">
                                {{ $pesanan->created_at ? $pesanan->created_at->format('H:i') : '-' }}
                            </td>

                            {{-- TOTAL HARGA --}}
                            <td class="fw-bold text-nowrap">
                                Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- DROPDOWN PEMBAYARAN --}}
                            <td>
                                <form action="{{ route('admin.pesanans.updateStatusPembayaran', $pesanan->id_pesanan) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <select name="status_pembayaran" class="form-select status-dropdown"
                                        onchange="this.form.submit()">

                                        {{-- Opsi "Belum Dibayar" hanya tampil (tidak bisa dipilih) jika memang sedang Belum Dibayar --}}
                                        @if (($pesanan->status_pembayaran ?? 'Belum Dibayar') === 'Belum Dibayar')
                                            <option value="Belum Dibayar" selected hidden>
                                                Belum Dibayar
                                            </option>
                                        @endif

                                        <option value="Menunggu Pembayaran"
                                            {{ ($pesanan->status_pembayaran ?? '') === 'Menunggu Pembayaran' ? 'selected' : '' }}>
                                            Menunggu Pembayaran
                                        </option>

                                        <option value="Dibayar"
                                            {{ ($pesanan->status_pembayaran ?? '') === 'Dibayar' ? 'selected' : '' }}>
                                            Dibayar
                                        </option>

                                        <option value="Gagal"
                                            {{ ($pesanan->status_pembayaran ?? '') === 'Gagal' ? 'selected' : '' }}>
                                            Gagal
                                        </option>
                                    </select>
                                </form>
                            </td>


                            {{-- DROPDOWN STATUS PESANAN --}}
                            <td>
                                <form action="{{ route('admin.pesanans.update', $pesanan->id_pesanan) }}" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">

                                        {{-- Opsi "Menunggu" hanya tampil (tidak bisa dipilih) jika pesanan memang sedang Menunggu --}}
                                        @if ($pesanan->status == 'Menunggu')
                                            <option value="Menunggu" selected hidden>
                                                Menunggu
                                            </option>
                                        @endif

                                        <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>
                                            Diproses
                                        </option>

                                        @if ($pesanan->jenis_pesanan === 'Delivery')
                                            <option value="Pengantaran"
                                                {{ $pesanan->status == 'Pengantaran' ? 'selected' : '' }}>
                                                Pengantaran
                                            </option>
                                        @endif

                                        <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>

                                        <option value="Dibatalkan"
                                            {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>
                                            Dibatalkan
                                        </option>

                                    </select>
                                </form>
                            </td>

                            {{-- AKSI: HANYA DETAIL --}}
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.pesanans.show', $pesanan->id_pesanan) }}"
                                    class="btn btn-aksi btn-aksi-detail btn-aksi-icon" title="Detail"
                                    aria-label="Detail pesanan #{{ $pesanan->id_pesanan }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-secondary py-5">
                                @if ($cari !== '')
                                    Pesanan dengan kata kunci "{{ $cari }}" tidak ditemukan pada tanggal
                                    {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}.
                                @else
                                    Belum ada pesanan pada tanggal
                                    {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}.
                                @endif
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3 pt-3 border-top">
            <div class="pagination-info">
                Menampilkan
                <strong>{{ $pesanans->firstItem() ?? 0 }}</strong>
                sampai
                <strong>{{ $pesanans->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $pesanans->total() }}</strong>
                pesanan
            </div>

            @if ($pesanans->hasPages())
                <nav aria-label="Navigasi halaman pesanan">
                    {{ $pesanans->links('pagination::bootstrap-5') }}
                </nav>
            @endif
        </div>
    </div>

    {{-- TOTAL PENDAPATAN --}}
    <div class="revenue-card mt-4">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <div class="revenue-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div>
                <div class="revenue-label">
                    Total Pendapatan
                    {{ \Carbon\Carbon::parse($tanggal)->isToday()
                        ? 'Hari Ini'
                        : 'Tanggal ' . \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}
                </div>

                <div class="revenue-value">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

@endsection
