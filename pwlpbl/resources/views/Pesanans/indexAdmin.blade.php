@extends('dashboard.admin')

@section('title', 'Kelola Pesanan')

@push('styles')
    <style>
        /* Pagination Pizza Moza */
        .pagination {
            gap: 4px;
            margin-bottom: 0;
        }

        .pagination .page-link {
            color: #6A0801;
            background-color: #FFFAEE;
            border: 1px solid rgba(106, 8, 1, 0.15);
            border-radius: 5px;
            min-width: 34px;
            text-align: center;
            padding: 7px 11px;
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
            color: #fff;
            font-weight: 600;
        }

        .pagination .page-item.disabled .page-link {
            color: #b8a99a;
            background-color: #fffaf0;
            border-color: rgba(106, 8, 1, 0.10);
        }

        .pagination-info {
            color: rgba(106, 8, 1, 0.7);
            font-size: 13px;
        }

        #tabelPesanan tbody tr {
            transition: background-color 0.15s ease;
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
                Daftar semua pesanan yang masuk ke Pizza Moza
            </p>
        </div>

        <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    {{-- PENCARIAN & TOTAL PESANAN --}}
    <div class="row align-items-center mb-4 px-2">
        <div class="col-md-7">
            <input type="text" id="cariPesanan" class="form-control" placeholder="Cari pesanan (ID, pembeli, status)...">
        </div>

        <div class="col-md-5 text-md-end text-secondary mt-2 mt-md-0">
            Total pesanan:
            <strong class="text-dark">
                {{ $pesanans->total() }}
            </strong>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="card p-3">
        <div class="table-responsive">

            <table class="table align-middle" id="tabelPesanan">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
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

                            {{-- NOMOR URUT --}}
                            <td>
                                {{ $pesanans->firstItem() + $loop->index }}
                            </td>

                            {{-- ID PESANAN --}}
                            <td class="fw-bold">
                                #{{ $pesanan->id_pesanan }}
                            </td>

                            {{-- NAMA PEMBELI --}}
                            <td>
                                {{ $pesanan->nama_penerima ?? ($pesanan->pembeli->nama ?? ($pesanan->pembeli->email ?? '-')) }}
                            </td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ $pesanan->created_at ? $pesanan->created_at->format('d/m/Y H:i') : '-' }}
                            </td>

                            {{-- TOTAL HARGA --}}
                            <td class="fw-bold">
                                Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- STATUS PEMBAYARAN --}}
                            <td>
                                @if (($pesanan->status_pembayaran ?? '') === 'Dibayar')
                                    <span class="badge bg-success">Dibayar</span>
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
                                Belum ada pesanan. Pesanan yang masuk akan tampil di halaman ini.
                            </td>
                        </tr>
                    @endforelse

                    {{-- PESAN JIKA PENCARIAN TIDAK DITEMUKAN --}}
                    <tr id="tidakDitemukan" style="display: none;">
                        <td colspan="8" class="text-center text-secondary py-4">
                            Pesanan yang dicari tidak ditemukan.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if ($pesanans->total() > 0)

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3 pt-3 border-top">

                {{-- INFORMASI JUMLAH DATA --}}
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $pesanans->firstItem() }}</strong>
                    sampai
                    <strong>{{ $pesanans->lastItem() }}</strong>
                    dari
                    <strong>{{ $pesanans->total() }}</strong>
                    pesanan
                </div>

                {{-- TOMBOL HALAMAN --}}
                @if ($pesanans->hasPages())

                    <nav aria-label="Navigasi halaman pesanan">
                        <ul class="pagination">

                            {{-- SEBELUMNYA --}}
                            <li class="page-item {{ $pesanans->onFirstPage() ? 'disabled' : '' }}">

                                @if ($pesanans->onFirstPage())
                                    <span class="page-link">&lsaquo;</span>
                                @else
                                    <a class="page-link" href="{{ $pesanans->previousPageUrl() }}"
                                        aria-label="Halaman sebelumnya">
                                        &lsaquo;
                                    </a>
                                @endif

                            </li>

                            {{-- NOMOR HALAMAN --}}
                            @foreach ($pesanans->getUrlRange(1, $pesanans->lastPage()) as $page => $url)
                                <li class="page-item {{ $pesanans->currentPage() == $page ? 'active' : '' }}">

                                    <a class="page-link" href="{{ $url }}"
                                        @if ($pesanans->currentPage() == $page) aria-current="page" @endif>
                                        {{ $page }}
                                    </a>

                                </li>
                            @endforeach

                            {{-- SELANJUTNYA --}}
                            <li class="page-item {{ $pesanans->hasMorePages() ? '' : 'disabled' }}">

                                @if ($pesanans->hasMorePages())
                                    <a class="page-link" href="{{ $pesanans->nextPageUrl() }}"
                                        aria-label="Halaman selanjutnya">
                                        &rsaquo;
                                    </a>
                                @else
                                    <span class="page-link">&rsaquo;</span>
                                @endif

                            </li>

                        </ul>
                    </nav>

                @endif

            </div>

        @endif

    </div>

@endsection


{{-- SCRIPT PENCARIAN --}}
@push('scripts')
    <script>
        document.getElementById('cariPesanan').addEventListener('input', function() {

            const kata = this.value.toLowerCase().trim();

            const baris = document.querySelectorAll('#tabelPesanan tbody tr.baris-pesanan');

            let jumlahDitemukan = 0;

            baris.forEach(function(row) {

                const cocok = row.textContent.toLowerCase().includes(kata);

                row.style.display = cocok ? '' : 'none';

                if (cocok) {
                    jumlahDitemukan++;
                }

            });

            // Tampilkan pesan jika pencarian tidak menemukan hasil.
            const pesanKosong = document.getElementById('tidakDitemukan');

            if (pesanKosong) {
                pesanKosong.style.display =
                    (kata !== '' && jumlahDitemukan === 0) ? '' : 'none';
            }

        });
    </script>
@endpush
