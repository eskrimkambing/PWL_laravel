@extends('dashboard.admin')

@section('title', 'Kelola Pesanan')

@push('styles')
    <style>
        /* KARTU RINGKASAN */
        .summary-card {
            background: #F7D991;
            border: 1px solid rgba(106, 8, 1, 0.10);
            border-radius: 14px;
            padding: 18px 22px;
            color: #6A0801;
        }

        .summary-label {
            color: #9B5140;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 23px;
            font-weight: 700;
            color: #6A0801;
        }

        /* KARTU TABEL */
        .order-table-card {
            background: #FFFAEE;
            border: 1px solid rgba(106, 8, 1, 0.10);
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 3px 10px rgba(106, 8, 1, 0.05);
        }

        #tabelPesanan {
            margin-bottom: 0;
            color: #6A0801;
        }

        #tabelPesanan thead th {
            background: #F7D991;
            color: #6A0801;
            font-weight: 700;
            padding: 13px 10px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(106, 8, 1, 0.12);
        }

        #tabelPesanan tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(106, 8, 1, 0.10);
        }

        #tabelPesanan tbody tr:hover {
            background: #FFF3D5;
        }

        /* TOTAL PENDAPATAN */
        .revenue-card {
            background: #F7D991;
            border: 1px solid rgba(106, 8, 1, 0.10);
            border-radius: 14px;
            padding: 20px 24px;
            color: #6A0801;
        }

        .revenue-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 2px solid #DE7801;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            color: #DE7801;
        }

        .revenue-label {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .revenue-value {
            font-size: 27px;
            font-weight: 800;
            color: #6A0801;
        }

        /* TOMBOL CARI */
        .btn-cari {
            background: #DE7801;
            color: white;
            border: 1px solid #DE7801;
            border-radius: 7px;
            padding: 9px 22px;
            font-weight: 600;
        }

        .btn-cari:hover {
            background: #BD6200;
            color: white;
        }

        /* PAGINATION */
        .pagination {
            gap: 4px;
            margin-bottom: 0;
        }

        .pagination .page-link {
            color: #6A0801;
            background-color: #FFFAEE;
            border: 1px solid rgba(106, 8, 1, 0.15);
            border-radius: 6px;
            min-width: 36px;
            text-align: center;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            color: #6A0801;
            background-color: #F7D991;
            border-color: #DE7801;
        }

        .pagination .page-item.active .page-link {
            background-color: #DE7801;
            border-color: #DE7801;
            color: white;
            font-weight: 600;
        }

        .pagination .page-item.disabled .page-link {
            color: #b8a99a;
            background-color: #fffaf0;
        }

        .pagination-info {
            color: rgba(106, 8, 1, 0.7);
            font-size: 13px;
        }

        .filter-date {
            max-width: 260px;
            border-radius: 8px;
            padding: 10px;
        }

        @media (max-width: 768px) {
            .revenue-value {
                font-size: 22px;
            }

            .summary-value {
                font-size: 20px;
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

    {{-- PENCARIAN BERDASARKAN TANGGAL --}}
    <div class="mb-4">
        <label class="form-label text-secondary">
            Cari Pesanan Berdasarkan Tanggal
        </label>

        <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap">

            <input type="date" name="tanggal" class="form-control filter-date" value="{{ $tanggal }}" required>

            <button type="submit" class="btn btn-cari">
                Cari
            </button>
        </form>
    </div>

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
                        @php
                            $status = strtolower($pesanan->status ?? 'menunggu');
                        @endphp

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

                            {{-- JAM SAJA, TANPA TANGGAL --}}
                            <td class="text-nowrap">
                                {{ $pesanan->created_at ? $pesanan->created_at->format('H:i') : '-' }}
                            </td>

                            {{-- TOTAL HARGA --}}
                            <td class="fw-bold text-nowrap">
                                Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- PEMBAYARAN --}}
                            <td>
                                @if (($pesanan->status_pembayaran ?? '') === 'Dibayar')
                                    <span class="badge bg-success">Dibayar</span>
                                @elseif (($pesanan->status_pembayaran ?? '') === 'Gagal')
                                    <span class="badge bg-danger">Gagal</span>
                                @else
                                    <span class="badge bg-secondary">Belum Dibayar</span>
                                @endif
                            </td>

                            {{-- STATUS PESANAN --}}
                            <td>
                                @if ($status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($status === 'diproses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif ($status === 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($status) }}
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.pesanans.show', $pesanan->id_pesanan) }}"
                                    class="btn btn-sm btn-outline-info">
                                    Detail
                                </a>

                                <a href="{{ route('admin.pesanans.edit', $pesanan->id_pesanan) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center text-secondary py-5">
                                Belum ada pesanan pada tanggal
                                {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}.
                            </td>
                        </tr>
                    @endforelse

                    {{-- PESAN JIKA PENCARIAN TEKS TIDAK DITEMUKAN --}}
                    <tr id="tidakDitemukan" style="display: none;">
                        <td colspan="8" class="text-center text-secondary py-4">
                            Pesanan yang dicari tidak ditemukan.
                        </td>
                    </tr>

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

{{-- SCRIPT PENCARIAN TEKS --}}
@push('scripts')
    <script>
        const inputCari = document.getElementById('cariPesanan');

        if (inputCari) {
            inputCari.addEventListener('input', function() {

                const kata = this.value.toLowerCase().trim();

                const baris = document.querySelectorAll(
                    '#tabelPesanan tbody tr.baris-pesanan'
                );

                let jumlahDitemukan = 0;

                baris.forEach(function(row) {

                    const cocok = row.textContent.toLowerCase().includes(kata);

                    row.style.display = cocok ? '' : 'none';

                    if (cocok) {
                        jumlahDitemukan++;
                    }
                });

                const pesanKosong = document.getElementById('tidakDitemukan');

                if (pesanKosong) {
                    pesanKosong.style.display =
                        (kata !== '' && jumlahDitemukan === 0) ? '' : 'none';
                }
            });
        }
    </script>
@endpush
