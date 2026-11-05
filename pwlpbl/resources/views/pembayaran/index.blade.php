
@extends('dashboard.admin')

@section('title', 'Kelola Transaksi')

@push('styles')
<style>
    .search-box,
    .date-box {
        background: transparent;
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
        border-radius: 8px;
    }

    .search-box:focus,
    .date-box:focus {
        background: transparent;
        color: var(--bs-body-color);
        border-color: #6b5648;
        box-shadow: none;
    }

    .search-box::placeholder {
        color: var(--bs-secondary-color);
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #f3e9e1;
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: 1px solid var(--bs-border-color);
        font-weight: 600;
        padding: 14px 10px;
        white-space: nowrap;
    }

    .table tbody td {
        border-bottom: 1px solid var(--bs-border-color);
        padding: 14px 10px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .badge-metode {
        background: #3d2e26;
        color: var(--moza-accent);
        font-weight: 500;
    }

    /* Kartu tanggal hari ini */
    .tanggal-card {
        background: #3d2e26;
        border: 1px solid var(--bs-border-color);
        border-radius: 10px;
        padding: 15px 20px;
    }

    /* Input tanggal */
    .date-box {
        min-width: 220px;
        padding: 9px 12px;
    }

    /* Pagination */
    .pagination {
    margin-top: 20px;
    margin-bottom: 0;
    justify-content: flex-end;
    flex-wrap: wrap;
}

    .pagination .page-link {
        background: transparent;
        color: #f3e9e1;
        border-color: var(--bs-border-color);
    }

    .pagination .page-link:hover {
        background: #3d2e26;
        color: var(--moza-accent);
    }

    .pagination .page-item.active .page-link {
        background: #6b5648;
        border-color: #6b5648;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        background: transparent;
        color: #777;
    }
</style>
@endpush

@section('content')

    {{-- JUDUL HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Transaksi</h2>
            <p class="text-secondary mb-0">
                Daftar transaksi pembayaran pesanan Pizza Moza
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.admin') }}"
               class="btn btn-outline-secondary">
                Kembali
            </a>

            <a href="{{ route('pembayaran.create') }}"
               class="btn btn-moza">
                + Tambah Pembayaran
            </a>
        </div>
    </div>

    {{-- PESAN BERHASIL --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- TANGGAL HARI INI --}}
    <div class="tanggal-card mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="text-secondary small mb-1">
                    Tanggal Hari Ini
                </div>

                <h5 class="fw-bold mb-0">
                    {{ now()->format('d-m-Y') }}
                </h5>
            </div>

            <div class="text-end">
                <div class="text-secondary small mb-1">
                    Total Transaksi Hari Ini
                </div>

                <h4 class="fw-bold mb-0">
                    {{ $totalTransaksiHariIni }}
                </h4>
            </div>
        </div>
    </div>

    {{-- FILTER TANGGAL --}}
    <div class="mb-3">
        <form action="{{ route('pembayaran.index') }}"
              method="GET"
              class="d-flex flex-wrap align-items-end gap-2">

            <div>
                <label for="tanggal" class="form-label text-secondary">
                    Cari Transaksi Berdasarkan Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       class="form-control date-box"
                       value="{{ request('tanggal') }}">
            </div>

            <button type="submit" class="btn btn-moza">
                <i class="bi bi-search"></i>
                Cari
            </button>

            @if (request('tanggal'))
                <a href="{{ route('pembayaran.index') }}"
                   class="btn btn-outline-secondary">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- PENCARIAN DAN TOTAL TRANSAKSI --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="width: 350px; max-width: 100%;">
            <input type="text"
                   id="searchPembayaran"
                   class="form-control search-box"
                   placeholder="Cari transaksi...">
        </div>

        <div class="text-secondary">
            Total transaksi:
            <span id="totalPembayaran">
                {{ $pembayarans->total() }}
            </span>
        </div>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No.</th>
                            <th>Pesanan</th>
                            <th>Email Pelanggan</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Dibayar Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tabelPembayaran">
                        @forelse ($pembayarans as $pembayaran)
                            <tr>
                                {{-- NOMOR URUT --}}
                                <td>
                                    {{ $pembayarans->firstItem() + $loop->index }}
                                </td>

                                {{-- ID PESANAN --}}
                                <td>
                                    #{{ $pembayaran->id_pesanan }}
                                </td>

                                {{-- EMAIL PELANGGAN --}}
                                <td>
                                    {{ $pembayaran->pembeli->email ?? '-' }}
                                </td>

                                {{-- TOTAL HARGA --}}
                                <td class="fw-semibold">
                                    Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                                </td>

                                {{-- METODE PEMBAYARAN --}}
                                <td>
                                    <span class="badge badge-metode">
                                        {{ $pembayaran->metode_pembayaran ?? '-' }}
                                    </span>
                                </td>

                                {{-- STATUS PEMBAYARAN --}}
                                <td>
                                    @if ($pembayaran->status_pembayaran === 'Dibayar')
                                        <span class="badge bg-success">
                                            Dibayar
                                        </span>

                                    @elseif ($pembayaran->status_pembayaran === 'Gagal')
                                        <span class="badge bg-danger">
                                            Gagal
                                        </span>

                                    @elseif ($pembayaran->status_pembayaran === 'Menunggu Pembayaran')
                                        <span class="badge bg-warning text-dark">
                                            Menunggu Pembayaran
                                        </span>

                                    @else
                                        <span class="badge bg-secondary">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>

                                {{-- TANGGAL PEMBAYARAN --}}
                                <td>
                                    @if ($pembayaran->dibayar_pada)
                                        {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- TOMBOL AKSI --}}
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('pembayaran.show', $pembayaran->id_pesanan) }}"
                                           class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>

                                        <a href="{{ route('pembayaran.edit', $pembayaran->id_pesanan) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('pembayaran.destroy', $pembayaran->id_pesanan) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data pembayaran ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center py-5 text-secondary">
                                    Belum ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION TANPA TULISAN TAMBAHAN --}}
            @if ($pembayarans->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    <nav aria-label="Navigasi halaman transaksi">
                        <ul class="pagination">

                            {{-- SEBELUMNYA --}}
                            @if ($pembayarans->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&lsaquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ $pembayarans->previousPageUrl() }}">
                                        &lsaquo;
                                    </a>
                                </li>
                            @endif

                            {{-- NOMOR HALAMAN --}}
                            @foreach (range(1, $pembayarans->lastPage()) as $page)
                                <li class="page-item {{ $pembayarans->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="{{ $pembayarans->url($page) }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- SELANJUTNYA --}}
                            @if ($pembayarans->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ $pembayarans->nextPageUrl() }}">
                                        &rsaquo;
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&rsaquo;</span>
                                </li>
                            @endif

                        </ul>
                    </nav>
                </div>
            @endif

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Pencarian transaksi pada halaman yang sedang dibuka
    document.getElementById('searchPembayaran').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#tabelPembayaran tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });
</script>
@endpush
