@extends('dashboard.admin')

@section('title', 'Kelola Pembayaran')

@push('styles')
<style>
    .search-box {
        background: transparent;
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
        border-radius: 8px;
    }

    .search-box:focus {
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
</style>
@endpush

@section('content')

    {{-- Judul --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Pembayaran</h2>
            <p class="text-secondary mb-0">Daftar pembayaran pesanan Pizza Moza</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.admin') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-moza">+ Tambah Pembayaran</a>
        </div>
    </div>

    {{-- Pesan berhasil --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ================= SEARCH ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="width: 500px; max-width: 100%;">
            <input type="text" id="searchPembayaran" class="form-control search-box"
                   placeholder="Cari pembayaran...">
        </div>

        <div class="text-secondary">
            Total pembayaran:
            <span id="totalPembayaran">{{ $pembayarans->count() }}</span>
        </div>
    </div>

    {{-- ================= TABEL ================= --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>ID Pesanan</th>
                            <th>Pembeli</th>
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
                                <td>{{ $loop->iteration }}</td>

                                <td>#{{ $pembayaran->id_pesanan }}</td>

                                <td>
                                    {{ $pembayaran->pembeli->nama
                                        ?? $pembayaran->pembeli->email
                                        ?? '-' }}
                                </td>

                                <td class="fw-semibold">
                                    Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="badge badge-metode">
                                        {{ $pembayaran->metode_pembayaran ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($pembayaran->status_pembayaran === 'Dibayar')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif ($pembayaran->status_pembayaran === 'Gagal')
                                        <span class="badge bg-danger">Gagal</span>
                                    @elseif ($pembayaran->status_pembayaran === 'Menunggu Pembayaran')
                                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Dibayar</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($pembayaran->dibayar_pada)
                                        {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('pembayaran.show', $pembayaran->id_pesanan) }}"
                                           class="btn btn-sm btn-info text-white">Detail</a>

                                        <a href="{{ route('pembayaran.edit', $pembayaran->id_pesanan) }}"
                                           class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('pembayaran.destroy', $pembayaran->id_pesanan) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data pembayaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-secondary">
                                    Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Search pembayaran
    document.getElementById('searchPembayaran').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#tabelPembayaran tr').forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
</script>
@endpush