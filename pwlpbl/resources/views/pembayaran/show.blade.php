@extends('dashboard.admin')

@section('title', 'Detail Pembayaran')

@push('styles')
<style>
    .info-box {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
    }

    .info-item {
        padding: 16px;
        border-bottom: 1px solid var(--bs-border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--bs-secondary-color);
        font-size: 14px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 500;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #f3e9e1;
    }

    .table th,
    .table td {
        border-color: var(--bs-border-color);
        padding: 12px 10px;
    }

    .table thead th {
        font-weight: 600;
    }

    .token-box {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 8px;
        padding: 10px 12px;
        word-break: break-all;
        font-size: 13px;
        color: var(--bs-secondary-color);
    }
</style>
@endpush

@section('content')

    {{-- JUDUL --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Pembayaran</h2>
            <p class="text-secondary mb-0">Informasi pembayaran pesanan Pizza Moza</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('pembayaran.edit', $pembayaran->id_pesanan) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    {{-- ================= INFORMASI PEMBAYARAN ================= --}}
    <div class="info-box mb-4">

        <div class="p-3 border-bottom">
            <div class="section-title">Informasi Pembayaran</div>
        </div>

        <div class="row g-0">

            {{-- ID PESANAN --}}
            <div class="col-md-6 info-item">
                <div class="info-label">ID Pesanan</div>
                <div class="info-value">#{{ $pembayaran->id_pesanan }}</div>
            </div>

            {{-- PEMBELI --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Pembeli</div>
                <div class="info-value">
                    {{ $pembayaran->pembeli->nama
                        ?? $pembayaran->pembeli->email
                        ?? '-' }}
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $pembayaran->pembeli->email ?? '-' }}</div>
            </div>

            {{-- TOTAL --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Total Pesanan</div>
                <div class="info-value">
                    Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                </div>
            </div>

            {{-- JENIS PESANAN --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Jenis Pesanan</div>
                <div class="info-value">{{ $pembayaran->jenis_pesanan ?? '-' }}</div>
            </div>

            {{-- METODE --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">{{ $pembayaran->metode_pembayaran ?? '-' }}</div>
            </div>

            {{-- STATUS --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Status Pembayaran</div>
                <div class="info-value">
                    @if ($pembayaran->status_pembayaran === 'Dibayar')
                        <span class="badge bg-success">Dibayar</span>
                    @elseif ($pembayaran->status_pembayaran === 'Gagal')
                        <span class="badge bg-danger">Gagal</span>
                    @elseif ($pembayaran->status_pembayaran === 'Menunggu Pembayaran')
                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                    @else
                        <span class="badge bg-secondary">Belum Dibayar</span>
                    @endif
                </div>
            </div>

            {{-- DIBAYAR PADA --}}
            <div class="col-md-6 info-item">
                <div class="info-label">Dibayar Pada</div>
                <div class="info-value">
                    @if ($pembayaran->dibayar_pada)
                        {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}
                    @else
                        -
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ================= DETAIL PRODUK ================= --}}
    <div class="info-box">

        <div class="p-3 border-bottom">
            <div class="section-title">Detail Pesanan</div>
        </div>

        <div class="p-3">

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pembayaran->detailPesanans as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $detail->product->name
                                        ?? $detail->product->nama_produk
                                        ?? '-' }}
                                </td>
                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td class="fw-semibold">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">
                                    Detail produk tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TOTAL --}}
            <div class="d-flex justify-content-end mt-3">
                <div class="text-end">
                    <div class="text-secondary">Total Pembayaran</div>
                    <div class="fs-4 fw-bold">
                        Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= SNAP TOKEN ================= --}}
    @if ($pembayaran->snap_token)

        <div class="info-box mt-4">
            <div class="p-3">
                <div class="info-label">Snap Token Midtrans</div>
                <div class="token-box mt-2">{{ $pembayaran->snap_token }}</div>
            </div>
        </div>

    @endif

@endsection