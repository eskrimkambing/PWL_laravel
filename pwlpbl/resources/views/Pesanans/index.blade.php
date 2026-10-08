@extends('layouts.pembeli')

@section('title', 'Pesanan Saya')

@push('styles')
<style>
    .order-card {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
    }

    .order-card:hover {
        background: #2d211b;
    }

    .price {
        color: var(--moza-accent);
    }
</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pesanan Saya</h2>
            <p class="text-secondary mb-0">Lihat dan pantau pesanan yang sudah kamu buat.</p>
        </div>

        <a href="{{ route('checkout.index') }}" class="btn btn-moza">+ Buat Pesanan</a>
    </div>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse ($pesanans as $pesanan)

        <div class="order-card p-4 mb-3">

            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="fw-semibold fs-5">Pesanan #{{ $pesanan->id_pesanan }}</div>
                    <small class="text-secondary">
                        {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}
                    </small>
                </div>

                {{-- STATUS PESANAN --}}
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

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <small class="text-secondary d-block">Jenis Pesanan</small>
                    <span>{{ $pesanan->jenis_pesanan }}</span>
                </div>

                <div class="col-md-4">
                    <small class="text-secondary d-block">Pembayaran</small>
                    <span>{{ $pesanan->metode_pembayaran ?? '-' }}</span>
                </div>

                <div class="col-md-4">
                    <small class="text-secondary d-block">Status Pembayaran</small>

                    @if ($pesanan->status_pembayaran === 'Dibayar')
                        <span class="badge bg-success">Dibayar</span>
                    @elseif ($pesanan->status_pembayaran === 'Menunggu Pembayaran')
                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                    @elseif ($pesanan->status_pembayaran === 'Gagal')
                        <span class="badge bg-danger">Gagal</span>
                    @else
                        <span class="badge bg-secondary">{{ $pesanan->status_pembayaran ?? '-' }}</span>
                    @endif
                </div>
            </div>

            <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-secondary d-block">Total Pesanan</small>
                    <span class="price fw-bold fs-5">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('pesanans.show', $pesanan->id_pesanan) }}" class="btn btn-outline-light">
                    Lihat Detail
                </a>
            </div>

        </div>

    @empty

        <div class="order-card p-5 text-center">
            <div class="fs-1 mb-3">📋</div>
            <h5>Belum Ada Pesanan</h5>
            <p class="text-secondary mb-4">Kamu belum membuat pesanan.</p>
            <a href="{{ route('checkout.index') }}" class="btn btn-moza">Buat Pesanan</a>
        </div>

    @endforelse

@endsection