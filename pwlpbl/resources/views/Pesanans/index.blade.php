@extends('layouts.pembeli')

@section('title', 'Riwayat Pesanan Saya')

@push('styles')
    <style>
        .rh-wrap {
            max-width: 1000px;
            margin: 0 auto;
        }

        .rh-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 768px) {
            .rh-grid {
                grid-template-columns: 1fr 1fr;
                gap: 14px 18px;
            }
        }

        @media (min-width: 1200px) {
            .rh-grid {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        .rh-box {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 18px;
            color: #222222;
        }

        .rh-title {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 18px;
            font-weight: 600;
            color: #222222;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 1px solid #E6E6E0;
        }

        .rh-back {
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

        .rh-back:hover {
            background: #FCE3B8;
            color: #8B1A10;
        }

        .rh-input {
            width: 100%;
            background: #FDF8EE;
            border: 1px solid rgba(139, 26, 16, 0.2);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            color: #222222;
        }

        .rh-input:focus {
            outline: none;
            border-color: #E8751A;
        }

        .rh-label {
            font-size: 13px;
            color: #555555;
            margin-bottom: 4px;
            display: block;
        }

        .rh-btn {
            background: #E8751A;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 14px;
        }

        .rh-btn:hover {
            background: #8B1A10;
            color: #FFFFFF;
        }

        .rh-btn-reset {
            display: inline-block;
            color: #8B1A10;
            border: 1px solid rgba(139, 26, 16, 0.3);
            border-radius: 10px;
            padding: 9px 16px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
        }

        .rh-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: #FFFFFF;
            border: 1.5px solid #FFD600;
            border-radius: 12px;
            padding: 14px 16px;
            color: #222222;
            text-decoration: none;
        }

        .rh-item:hover {
            background: #FFFBEA;
            color: #222222;
        }

        .rh-jenis {
            font-size: 13px;
            color: #555555;
        }

        .rh-id {
            font-size: 15px;
            font-weight: 700;
            color: #222222;
        }

        .rh-tgl {
            font-size: 12px;
            color: #777777;
            margin-top: 2px;
        }

        .rh-status {
            font-size: 13px;
            font-weight: 700;
            text-align: right;
            line-height: 1.3;
        }

        .rh-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px 10px;
            color: #555555;
        }
    </style>
@endpush

@section('content')
    <div class="rh-wrap">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="rh-box">
            <div class="rh-title">
                <a href="{{ route('home') }}" class="rh-back" title="Kembali ke halaman utama">←</a>
                <span>{{ $aktif ? 'Pesanan Berjalan' : 'Riwayat Pesanan Saya' }}</span>
            </div>

            {{-- PENCARIAN DAN FILTER TANGGAL --}}
            @php
                $adaFilter = $cari !== '' || $dari || $sampai || $aktif;
            @endphp

            <form action="{{ route('pesanans.index') }}" method="GET" class="mb-3">
                @if ($aktif)
                    <input type="hidden" name="aktif" value="1">
                @endif

                <div class="mb-3">
                    <label for="q" class="rh-label">Cari riwayat pesanan</label>
                    <input type="search" id="q" name="q" class="rh-input" value="{{ $cari }}"
                        placeholder="ID pesanan (mis. 38), nama produk, atau status">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="dari" class="rh-label">Dari tanggal</label>
                        <input type="date" id="dari" name="dari" class="rh-input" value="{{ $dari }}">
                    </div>
                    <div class="col-6">
                        <label for="sampai" class="rh-label">Sampai tanggal</label>
                        <input type="date" id="sampai" name="sampai" class="rh-input" value="{{ $sampai }}">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="rh-btn">Terapkan</button>
                    @if ($adaFilter)
                        <a href="{{ route('pesanans.index') }}" class="rh-btn-reset">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="rh-box">
            <div class="rh-grid">
                @forelse ($pesanans as $pesanan)
                    @php
                        // Label status yang tampil di kartu, mengikuti alur pesanan.
                        if ($pesanan->status === 'Dibatalkan') {
                            $labelStatus = 'DIBATALKAN';
                            $warnaStatus = '#C62828';
                        } elseif ($pesanan->status === 'Selesai') {
                            $labelStatus = 'PESANAN SELESAI';
                            $warnaStatus = '#2E9E2E';
                        } elseif ($pesanan->status === 'Pengantaran') {
                            $labelStatus = 'SEDANG DIANTAR';
                            $warnaStatus = '#2E9E2E';
                        } elseif ($pesanan->status === 'Diproses' || $pesanan->status_pembayaran === 'Dibayar') {
                            $labelStatus = 'PESANAN DIKONFIRMASI';
                            $warnaStatus = '#2E9E2E';
                        } else {
                            $labelStatus = 'MENUNGGU PEMBAYARAN';
                            $warnaStatus = '#D4A000';
                        }
                    @endphp

                    <a href="{{ route('pesanans.show', $pesanan->id_pesanan) }}" class="rh-item">
                        <div>
                            <div class="rh-jenis">{{ $pesanan->jenis_pesanan }}</div>
                            <div class="rh-id">#{{ $pesanan->id_pesanan }}</div>
                            <div class="rh-tgl">
                                {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}
                            </div>
                        </div>

                        <div class="rh-status" style="color: {{ $warnaStatus }};">
                            {{ $labelStatus }}
                        </div>
                    </a>

                @empty

                    <div class="rh-empty">
                        @if ($adaFilter)
                            <div class="fw-semibold mb-1">Pesanan tidak ditemukan</div>
                            <div>Tidak ada pesanan yang cocok dengan pencarian atau rentang tanggal tersebut.</div>
                        @else
                            <div class="fw-semibold mb-1">Belum ada pesanan</div>
                            <div>Kamu belum membuat pesanan.</div>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
