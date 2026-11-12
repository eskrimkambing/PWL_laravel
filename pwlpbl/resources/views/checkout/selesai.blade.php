@extends('layouts.pembeli')

@section('title', 'Pesanan Berhasil')

@section('content')

    <div class="mx-auto" style="max-width: 720px;">

        <div class="text-center mb-4">
            <div style="font-size: 56px;"></div>
            <h2 class="fw-bold mb-1">Pesanan Berhasil Dibuat!</h2>
            <p class="text-secondary mb-0">
                Terima kasih, {{ $pesanan->nama_penerima }}. Pesananmu sedang kami proses.
            </p>
        </div>

        <div class="card p-4 mb-4">

            <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <small class="text-secondary d-block">Nomor Pesanan</small>
                    <strong>#{{ $pesanan->id_pesanan }}</strong>
                </div>
                <div class="text-end">
                    <small class="text-secondary d-block">Jenis Pesanan</small>
                    <strong>{{ $pesanan->jenis_pesanan }}</strong>
                </div>
            </div>

            <hr>

            @foreach ($items as $item)
                <div class="d-flex justify-content-between gap-3 py-2">
                    <div style="min-width:0;">
                        <strong>{{ $item['jumlah'] }}x {{ $item['nama'] }}</strong>

                        @if ($item['ukuran'])
                            <small class="d-block">Ukuran: {{ $item['ukuran'] }}</small>
                        @endif

                        @if ($item['catatan'])
                            <small class="d-block">Catatan: {{ $item['catatan'] }}</small>
                        @endif
                    </div>

                    <strong class="text-nowrap">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            <hr>

            <div class="d-flex justify-content-between align-items-center">
                <span>Total Pembayaran</span>
                <strong class="fs-5">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
            </div>

        </div>

        <div class="card p-4 mb-4">

            <h5 class="mb-3">Informasi Pesanan</h5>

            <div class="mb-2"><small class="text-secondary d-block">Nama</small>{{ $pesanan->nama_penerima }}</div>
            <div class="mb-2"><small class="text-secondary d-block">Nomor HP</small>{{ $pesanan->no_telp }}</div>

            @if (!empty($pesanan->email))
                <div class="mb-2"><small class="text-secondary d-block">Email</small>{{ $pesanan->email }}</div>
            @endif

            <div class="mb-0">
                <small class="text-secondary d-block">Pembayaran</small>
                {{ $pesanan->metode_pembayaran }}
                @if ($pesanan->metode_pembayaran === 'Cash')
                    — bayar langsung kepada kasir.
                @endif
            </div>

        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('home') }}#menu" class="btn btn-moza px-4">Pesan Lagi</a>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4">Login / Daftar</a>
        </div>

    </div>

    <script>
        // Pesanan sudah masuk, kosongkan keranjang di browser
        try { localStorage.removeItem('moza_cart'); } catch (e) {}
    </script>

@endsection
