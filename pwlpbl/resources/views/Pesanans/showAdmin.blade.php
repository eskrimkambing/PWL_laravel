@extends('dashboard.admin')

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
        height: 100%;
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

    .order-thumb {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid var(--bs-border-color);
    }
</style>
@endpush

@section('content')

    @php
        // FOTO CADANGAN untuk produk yang belum punya gambar di database
        $fotoPizza = [
            'Extra Chicken' => 'extra-chicken.jpeg',
            'Cheese Volcano' => 'cheese-volcano.jpeg',
            'Ekstra Beef' => 'ekstra-beef.jpeg',
            'Original Mozza' => 'original-mozza.jpeg',
            'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
            'Long Pizza' => 'long-pizza.jpeg',
        ];

        $fotoCemilan = [
            'Tape Bakar Original' => 'tape-bakar-original.jpeg',
            'Singkong Keju' => 'singkong-keju.jpeg',
            'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
        ];

        $fotoDefault = asset('images/pizza.jpg');
    @endphp

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>
            <h2 class="fw-bold mb-1">Detail Pesanan</h2>
            <p class="text-secondary mb-0">Informasi lengkap pesanan #{{ $pesanan->id_pesanan }}</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.pesanans.indexAdmin') }}" class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('admin.pesanans.edit', $pesanan->id_pesanan) }}" class="btn btn-moza">
                Edit Status
            </a>
        </div>

    </div>


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
                    <div class="fw-semibold">{{ $pesanan->jenis_pesanan ?? '-' }}</div>
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
                            <span class="badge bg-secondary">{{ $pesanan->status_pembayaran ?? 'Belum Dibayar' }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- ================= DATA PEMBELI ================= --}}
    <div class="content-card p-4 mb-4">

        <h5 class="mb-3">Data Pembeli</h5>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Nama</div>
                    <div class="fw-semibold">
                        {{ $pesanan->nama_penerima ?? ($pesanan->pembeli->nama ?? '-') }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Email</div>
                    <div class="fw-semibold">{{ $pesanan->pembeli->email ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">No. Telepon</div>
                    <div class="fw-semibold">
                        {{ $pesanan->no_telp ?? ($pesanan->pembeli->no_telp ?? '-') }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-label">Alamat</div>
                    <div class="fw-semibold">
                        {{ $pesanan->alamat ?? ($pesanan->pembeli->alamat ?? '-') }}
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="info-box">
                    <div class="info-label">Catatan</div>
                    <div class="fw-semibold" style="white-space: pre-line;">{{ $pesanan->catatan ?: '-' }}</div>
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

                        @php
                            $produk = $detail->product;
                            $namaProduk = $produk->nama ?? null;

                            // 1. Pakai gambar dari database (lewat asset()) kalau ada
                            // 2. Kalau kosong, pakai foto cadangan di folder public/images
                            if ($produk && !empty($produk->image)) {
                                if (\Illuminate\Support\Str::startsWith($produk->image, ['http://', 'https://'])) {
                                    $srcFoto = $produk->image;
                                } else {
                                    $srcFoto = asset(ltrim($produk->image, '/'));
                                }
                            } else {
                                if ($namaProduk && isset($fotoPizza[$namaProduk])) {
                                    $pathFoto = 'images/pizza/' . $fotoPizza[$namaProduk];
                                } elseif ($namaProduk && isset($fotoCemilan[$namaProduk])) {
                                    $pathFoto = 'images/cemilan/' . $fotoCemilan[$namaProduk];
                                } else {
                                    $pathFoto = 'images/pizza.jpg';
                                }
                                $srcFoto = asset($pathFoto);
                            }
                        @endphp

                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">

                                    {{-- GAMBAR PRODUK --}}
                                    <img src="{{ $srcFoto }}"
                                         alt="{{ $namaProduk ?? 'Produk' }}"
                                         class="order-thumb"
                                         onerror="this.onerror=null; this.src='{{ $fotoDefault }}';">

                                    <span>{{ $namaProduk ?? 'Produk tidak ditemukan' }}</span>
                                </div>
                            </td>
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

@endsection