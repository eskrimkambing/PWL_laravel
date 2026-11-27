@extends('layouts.pembeli')

@section('title', 'Detail Pesanan')

@push('styles')
    <style>
        .dp-wrap {
            max-width: 1000px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
        }

        .dp-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0 20px;
        }

        @media (min-width: 900px) {
            .dp-layout {
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }
        }

        .dp-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .dp-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            background: #FFFFFF;
            border: 1px solid rgba(139, 26, 16, 0.25);
            border-radius: 12px;
            font-size: 24px;
            font-weight: 600;
            color: #8B1A10;
            text-decoration: none;
            line-height: 1;
        }

        .dp-back:hover {
            background: #FCE3B8;
            color: #8B1A10;
        }

        .dp-order-label {
            font-size: 13px;
            font-weight: 700;
            color: #E8751A;
        }

        .dp-order-id {
            font-size: 17px;
            font-weight: 700;
            color: #222222;
        }

        .dp-brand {
            font-size: 14px;
            font-weight: 700;
            color: #222222;
            margin-top: 4px;
        }

        .dp-date {
            font-size: 13px;
            color: #555555;
            margin-bottom: 14px;
        }

        .dp-card {
            background: #FFFFFF;
            border: 1.5px solid #FFD600;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 14px;
            color: #222222;
        }

        .dp-step {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            padding: 6px 0;
            font-size: 14px;
            color: #222222;
        }

        .dp-step:not(:last-child)::after {
            content: "";
            position: absolute;
            left: 10px;
            top: 30px;
            width: 2px;
            height: calc(100% - 12px);
            background: #E0E0D8;
        }

        .dp-step.on:not(:last-child)::after {
            background: #E8751A;
        }

        .dp-dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: 2px solid #D9D9D0;
            background: #FFFFFF;
            color: #FFFFFF;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dp-step.on .dp-dot {
            background: #E8751A;
            border-color: #E8751A;
        }

        .dp-step.off {
            color: #A8A8A0;
        }

        .dp-total-label {
            font-size: 14px;
            color: #555555;
        }

        .dp-total {
            font-size: 22px;
            font-weight: 600;
            color: #222222;
        }

        .dp-paid {
            font-size: 15px;
            font-weight: 700;
            color: #2E9E2E;
        }

        .dp-paid-dot {
            display: inline-flex;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #FFD600;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #222222;
            margin-left: 6px;
            vertical-align: middle;
        }

        .dp-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #EFEFE8;
            font-size: 14px;
        }

        .dp-row:last-child {
            border-bottom: none;
        }

        .dp-sub {
            font-size: 12px;
            color: #777777;
        }

        .dp-muted {
            font-size: 14px;
            color: #555555;
        }

        .dp-grand {
            font-size: 18px;
            font-weight: 700;
            color: #E8751A;
        }

        .dp-btn {
            width: 100%;
            background: #E8751A;
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
        }

        .dp-btn:hover {
            background: #8B1A10;
            color: #FFFFFF;
        }

        .dp-batal {
            background: #FFF5F3;
            border: 1px solid rgba(210, 57, 43, 0.3);
            color: #A32D1F;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 14px;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    @php
        $sudahBayar = $pesanan->status_pembayaran === 'Dibayar';
        $dibatalkan = $pesanan->status === 'Dibatalkan';
        $dikonfirmasi = $sudahBayar || in_array($pesanan->status, ['Diproses', 'Pengantaran', 'Selesai']);
        $diterima = $pesanan->status === 'Selesai';
        $labelJenis = $pesanan->jenis_pesanan;
    @endphp

    <div class="dp-wrap">

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- HEADER --}}
        <div class="dp-head">
            <a href="{{ route('pesanans.index') }}" class="dp-back" title="Kembali ke riwayat pesanan">←</a>
            <div>
                <div class="dp-order-label">Order ID</div>
                <div class="dp-order-id">#{{ $pesanan->id_pesanan }}</div>
            </div>
        </div>

        <div class="dp-brand">Pizza Moza · {{ $labelJenis }}</div>
        <div class="dp-date">
            {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}
        </div>

        @if ($dibatalkan)
            <div class="dp-batal">Pesanan ini dibatalkan.</div>
        @endif

        <div class="dp-layout">
            <div>
                {{-- PROGRES PESANAN --}}
                <div class="dp-card">
                    <div class="dp-step on">
                        <span class="dp-dot">✓</span>
                        <span>Menunggu Pembayaran</span>
                    </div>

                    <div class="dp-step {{ $dikonfirmasi ? 'on' : 'off' }}">
                        <span class="dp-dot">{{ $dikonfirmasi ? '✓' : '' }}</span>
                        <span>Pesanan dikonfirmasi</span>
                    </div>

                    <div class="dp-step {{ $diterima ? 'on' : 'off' }}">
                        <span class="dp-dot">{{ $diterima ? '✓' : '' }}</span>
                        <span>Pesanan diterima</span>
                    </div>
                </div>

                {{-- TOTAL DAN PEMBAYARAN --}}
                <div class="dp-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="dp-total-label">Grand Total</div>
                            <div class="dp-total">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                        </div>

                        @if ($sudahBayar)
                            <div class="dp-paid">
                                paid <span class="dp-paid-dot">✓</span>
                            </div>
                        @endif
                    </div>

                    <div class="dp-total-label mb-1">Metode Pembayaran</div>
                    <div class="fw-semibold">{{ $pesanan->metode_pembayaran ?? '-' }}</div>
                </div>

            </div>
            <div>
                {{-- PRODUK --}}
                <div class="dp-card">
                    @forelse ($pesanan->detailPesanans as $detail)
                        <div class="dp-row">
                            <div class="flex-grow-1">
                                <div>{{ $detail->product->nama ?? 'Produk tidak ditemukan' }}</div>
                                @if ($detail->ukuran || !empty($detail->toppings))
                                    <div class="dp-sub">
                                        @if ($detail->ukuran)
                                            Ukuran: {{ $detail->ukuran }}
                                        @endif
                                        @if (!empty($detail->toppings))
                                            @if ($detail->ukuran)
                                                ·
                                            @endif
                                            Topping: {{ collect($detail->toppings)->pluck('nama')->implode(', ') }}
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div style="min-width: 36px; text-align: center;">{{ $detail->jumlah }}</div>

                            <div style="min-width: 110px; text-align: right;">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="dp-muted text-center py-3">Tidak ada detail produk.</div>
                    @endforelse

                    <div class="dp-row">
                        <div class="dp-muted">Subtotal</div>
                        <div>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="dp-row">
                        <div class="dp-grand">Grand Total</div>
                        <div class="dp-grand">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                    </div>
                </div>

                {{-- BAYAR MIDTRANS --}}
                @if ($pesanan->metode_pembayaran === 'Midtrans' && !$sudahBayar && !$dibatalkan)
                    <div class="dp-card">
                        <div class="fw-semibold mb-1">Pembayaran</div>
                        <div class="dp-muted mb-3">Lanjutkan pembayaran untuk menyelesaikan pesanan.</div>

                        <form action="{{ route('pesanans.bayar', $pesanan->id_pesanan) }}" method="POST">
                            @csrf
                            <button type="submit" class="dp-btn">Bayar Sekarang</button>
                        </form>
                    </div>
                @endif

                {{-- CASH --}}
                @if ($pesanan->metode_pembayaran === 'Cash' && !$sudahBayar && !$dibatalkan)
                    <div class="dp-card">
                        <div class="fw-semibold mb-1">Pembayaran Cash</div>
                        <div class="dp-muted">Silakan lakukan pembayaran langsung kepada kasir.</div>
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection

{{-- MIDTRANS SNAP --}}
@if (session('snap_token') && $pesanan->metode_pembayaran === 'Midtrans' && $pesanan->status_pembayaran !== 'Dibayar')
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const snapToken = @json(session('snap_token'));

                if (snapToken) {
                    window.snap.pay(snapToken, {
                        onSuccess: function() {
                            window.location.reload();
                        },

                        onPending: function() {
                            window.location.reload();
                        },

                        onError: function() {
                            alert('Pembayaran gagal.');
                        },

                        onClose: function() {
                            console.log('Halaman pembayaran ditutup.');
                        }
                    });
                }

            });
        </script>
    @endpush
@endif
