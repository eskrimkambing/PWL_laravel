@extends('layouts.pembeli')

@section('title', 'Detail Pesanan')

@push('styles')
<style>
    .content-card {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
    }

    .info-box {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 10px;
        padding: 14px;
    }

    .info-label {
        color: var(--bs-secondary-color);
        font-size: 13px;
        margin-bottom: 4px;
    }

    .total-box {
        border-top: 1px solid var(--bs-border-color);
    }

    .price {
        color: var(--moza-accent);
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #f3e9e1;
        --bs-table-border-color: var(--bs-border-color);
    }
</style>
@endpush

@section('content')

    {{-- JUDUL --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Detail Pesanan</h2>
        <p class="text-secondary mb-0">Informasi lengkap mengenai pesanan kamu.</p>
    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ================= INFORMASI PESANAN ================= --}}
    <div class="content-card p-4 mb-4">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h5 class="mb-1">Pesanan #{{ $pesanan->id_pesanan }}</h5>
                <small class="text-secondary">
                    {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}
                </small>
            </div>

            @if ($pesanan->status === 'Menunggu')
                <span class="badge bg-warning text-dark">Menunggu</span>
            @elseif ($pesanan->status === 'Diproses')
                <span class="badge bg-info text-dark">Diproses</span>
            @elseif ($pesanan->status === 'Selesai')
                <span class="badge bg-success">Selesai</span>
            @elseif ($pesanan->status === 'Dibatalkan')
                <span class="badge bg-danger">Dibatalkan</span>
            @else
                <span class="badge bg-secondary">{{ $pesanan->status }}</span>
            @endif
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Jenis Pesanan</div>
                    <div class="fw-semibold">{{ $pesanan->jenis_pesanan }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Metode Pembayaran</div>
                    <div class="fw-semibold">{{ $pesanan->metode_pembayaran ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="info-label">Status Pembayaran</div>
                    <div>
                        @if ($pesanan->status_pembayaran === 'Dibayar')
                            <span class="badge bg-success">Dibayar</span>
                        @elseif ($pesanan->status_pembayaran === 'Gagal')
                            <span class="badge bg-danger">Gagal</span>
                        @elseif ($pesanan->status_pembayaran === 'Menunggu Pembayaran')
                            <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                        @else
                            <span class="badge bg-secondary">{{ $pesanan->status_pembayaran ?? '-' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= DETAIL PRODUK ================= --}}
    <div class="content-card p-4 mb-4">

        <h5 class="mb-3">Produk Pesanan</h5>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan->detailPesanans as $detail)
                        <tr>
                            <td>{{ $detail->product->name ?? 'Produk tidak ditemukan' }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-end price fw-semibold">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">
                                Tidak ada detail produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="total-box mt-3 pt-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-secondary">Total Pesanan</span>
                <span class="fs-4 fw-bold price">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

    </div>

    {{-- ================= PEMBAYARAN ================= --}}
    @if ($pesanan->metode_pembayaran === 'Midtrans' && $pesanan->status_pembayaran !== 'Dibayar')

        <div class="content-card p-4 mb-4">
            <h5 class="mb-1">Pembayaran</h5>
            <p class="text-secondary small mb-3">
                Lanjutkan pembayaran untuk menyelesaikan pesanan.
            </p>

            <form action="{{ route('pesanans.bayar', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-moza px-4">💳 Bayar Sekarang</button>
            </form>
        </div>

    @endif

    {{-- ================= INFORMASI CASH ================= --}}
    @if ($pesanan->metode_pembayaran === 'Cash')

        <div class="content-card p-4 mb-4">
            <h5 class="mb-1">Pembayaran Cash</h5>
            <p class="text-secondary mb-0">
                Silakan lakukan pembayaran langsung kepada kasir.
            </p>
        </div>

    @endif

    {{-- ================= TOMBOL ================= --}}
    <div class="d-flex gap-2">
        <a href="{{ route('pesanans.index') }}" class="btn btn-outline-secondary">
            ← Kembali ke Pesanan
        </a>

        <a href="{{ route('checkout.index') }}" class="btn btn-moza">
            + Buat Pesanan Lagi
        </a>
    </div>

@endsection

{{-- MIDTRANS SNAP --}}
@if (
    session('snap_token')
    && $pesanan->metode_pembayaran === 'Midtrans'
    && $pesanan->status_pembayaran !== 'Dibayar'
)
    @push('scripts')
        <script
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const snapToken = @json(session('snap_token'));

                if (snapToken) {
                    window.snap.pay(snapToken, {
                        onSuccess: function () {
                            window.location.reload();
                        },
                        onPending: function () {
                            window.location.reload();
                        },
                        onError: function () {
                            alert('Pembayaran gagal.');
                        },
                        onClose: function () {
                            console.log('Halaman pembayaran ditutup.');
                        }
                    });
                }

            });
        </script>
    @endpush
@endif