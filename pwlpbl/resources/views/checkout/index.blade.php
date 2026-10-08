@extends('layouts.pembeli')

@section('title', 'Checkout')

@push('styles')
<style>
    .product-card {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
        height: 100%;
    }

    .product-card:hover {
        background: #2d211b;
    }

    .checkout-box {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
    }

    .form-control,
    .form-select {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
    }

    .form-control:focus,
    .form-select:focus {
        background: var(--bs-body-bg);
        color: var(--bs-body-color);
        border-color: #6b5648;
        box-shadow: none;
    }

    .form-select option {
        background: #261c17;
        color: #f3e9e1;
    }

    .payment-option {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 10px;
    }

    .payment-option:hover {
        background: #2d211b;
    }

    .payment-option .form-check-input {
        margin-top: 5px;
    }

    .price {
        color: var(--moza-accent);
    }
</style>
@endpush

@section('content')

    {{-- JUDUL --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Checkout</h2>
        <p class="text-secondary mb-0">Pilih produk dan tentukan pembayaran pesanan kamu.</p>
    </div>

    {{-- ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        {{-- ================= PRODUK ================= --}}
        <div class="mb-4">
            <div class="mb-3">
                <h5 class="mb-1">Pilih Produk</h5>
                <small class="text-secondary">Masukkan jumlah produk yang ingin dipesan.</small>
            </div>

            <div class="row g-3">
                @forelse ($products as $product)
                    <div class="col-md-6 col-xl-4">
                        <div class="product-card p-3">

                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="mb-0">{{ $product->name }}</h5>
                                <span class="badge bg-secondary">{{ $product->category }}</span>
                            </div>

                            <div class="price fw-semibold mb-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <p class="text-secondary small mb-3">
                                {{ $product->description ?? 'Tidak ada deskripsi.' }}
                            </p>

                            <label class="form-label small">Jumlah</label>
                            <input type="number"
                                   name="products[{{ $product->id }}]"
                                   class="form-control"
                                   min="0"
                                   value="{{ old('products.' . $product->id, 0) }}">

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada produk yang tersedia.</div>
                    </div>
                @endforelse
            </div>
        </div>

        @if ($products->count() > 0)

            {{-- ================= DETAIL CHECKOUT ================= --}}
            <div class="checkout-box p-4">

                <h5 class="mb-1">Detail Pesanan</h5>
                <p class="text-secondary small mb-4">Tentukan jenis pesanan dan metode pembayaran.</p>

                {{-- JENIS PESANAN --}}
                <div class="mb-4">
                    <label for="jenis_pesanan" class="form-label">Jenis Pesanan</label>

                    <select name="jenis_pesanan" id="jenis_pesanan" class="form-select" required>
                        <option value="">-- Pilih Jenis Pesanan --</option>
                        <option value="Makan di tempat"
                            {{ old('jenis_pesanan') == 'Makan di tempat' ? 'selected' : '' }}>
                            Makan di tempat
                        </option>
                        <option value="Dibungkus"
                            {{ old('jenis_pesanan') == 'Dibungkus' ? 'selected' : '' }}>
                            Dibungkus
                        </option>
                    </select>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="mb-4">
                    <label class="form-label">Metode Pembayaran</label>

                    {{-- CASH --}}
                    <div class="payment-option">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                   name="metode_pembayaran" id="cash" value="Cash"
                                   {{ old('metode_pembayaran') == 'Cash' ? 'checked' : '' }} required>
                            <label class="form-check-label w-100" for="cash">
                                <strong>Cash</strong>
                                <div class="text-secondary small">Bayar langsung kepada kasir.</div>
                            </label>
                        </div>
                    </div>

                    {{-- MIDTRANS --}}
                    <div class="payment-option">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                   name="metode_pembayaran" id="midtrans" value="Midtrans"
                                   {{ old('metode_pembayaran') == 'Midtrans' ? 'checked' : '' }} required>
                            <label class="form-check-label w-100" for="midtrans">
                                <strong>Midtrans</strong>
                                <div class="text-secondary small">
                                    Bayar secara online melalui halaman pembayaran Midtrans.
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pembeli.products') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button type="submit" class="btn btn-moza px-4">Buat Pesanan</button>
                </div>

            </div>

        @endif
    </form>

@endsection