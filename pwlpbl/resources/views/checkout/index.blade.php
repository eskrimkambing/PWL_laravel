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

    .product-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid var(--bs-border-color);
    }

    .product-thumb-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bs-body-bg);
        font-size: 30px;
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
        border-color: #f0b36b;
        box-shadow: 0 0 0 3px rgba(240, 179, 107, 0.2);
    }

    .form-control::placeholder {
        color: #8f7e73;
    }

    textarea.form-control {
        resize: vertical;
    }

    .form-select option {
        background: #261c17;
        color: #f3e9e1;
    }

    /* ================= METODE PEMBAYARAN ================= */
    .payment-option {
        position: relative;
        background: var(--bs-body-bg);
        border: 1.5px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .payment-option:hover {
        background: #2d211b;
        border-color: #c9a27e;
    }

    .payment-option .form-check-input {
        margin-top: 5px;
        width: 1.2em;
        height: 1.2em;
        cursor: pointer;
    }

    /* Opsi yang sedang DIPILIH */
    .payment-option:has(input[type="radio"]:checked) {
        background: rgba(240, 179, 107, 0.15);
        border-color: #f0b36b;
        box-shadow: 0 0 0 3px rgba(240, 179, 107, 0.25);
    }

    .payment-option:has(input[type="radio"]:checked) strong {
        color: #f0b36b;
    }

    .payment-option:has(input[type="radio"]:checked) .text-secondary {
        color: #d9c3ab !important;
    }

    /* Lingkaran radio saat dipilih */
    .payment-option .form-check-input:checked {
        background-color: #f0b36b;
        border-color: #f0b36b;
    }

    .payment-option .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(240, 179, 107, 0.3);
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

                            <div class="d-flex gap-3 mb-3">

                                {{-- GAMBAR KECIL (dari database) --}}
                                @if ($product->image)
                                    <img src="{{ $product->image }}"
                                         alt="{{ $product->name }}"
                                         class="product-thumb">
                                @else
                                    <div class="product-thumb product-thumb-empty">🍕</div>
                                @endif

                                {{-- INFO PRODUK --}}
                                <div class="flex-grow-1" style="min-width:0;">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <h5 class="mb-0">{{ $product->name }}</h5>
                                        <span class="badge bg-secondary">{{ $product->category }}</span>
                                    </div>

                                    <div class="price fw-semibold mb-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>

                                    <p class="text-secondary small mb-0">
                                        {{ $product->description ?? 'Tidak ada deskripsi.' }}
                                    </p>
                                </div>
                            </div>

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

            {{-- ================= DATA PENERIMA ================= --}}
            <div class="checkout-box p-4 mb-4">

                <h5 class="mb-1">Data Penerima</h5>
                <p class="text-secondary small mb-4">
                    Terisi otomatis dari profil kamu. Kamu bisa mengubahnya untuk pesanan ini saja,
                    data profil tidak ikut berubah.
                </p>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nama_penerima" class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="nama_penerima"
                               class="form-control"
                               value="{{ old('nama_penerima', $pembeli->nama) }}"
                               placeholder="Masukkan nama penerima" required>
                    </div>

                    <div class="col-md-6">
                        <label for="no_telp" class="form-label">Nomor HP</label>
                        <input type="text" name="no_telp" id="no_telp"
                               class="form-control"
                               value="{{ old('no_telp', $pembeli->no_telp) }}"
                               placeholder="Contoh: 081234567890" required>
                    </div>

                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="form-control"
                                  placeholder="Masukkan alamat lengkap"
                                  required>{{ old('alamat', $pembeli->alamat) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="catatan" class="form-label">
                            Catatan <span class="text-secondary small">(opsional)</span>
                        </label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="form-control"
                                  maxlength="500"
                                  placeholder="Contoh: tanpa bawang, pedas level 2, jangan dipotong...">{{ old('catatan') }}</textarea>
                    </div>

                </div>

            </div>

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
                            <label class="form-check-label w-100 stretched-link" for="cash">
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
                            <label class="form-check-label w-100 stretched-link" for="midtrans">
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