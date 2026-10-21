@extends('layouts.pembeli')

@section('title', 'Beranda')

@push('styles')
<style>
    .category-btn {
        border: 1px solid var(--bs-border-color);
        background: #261c17;
        color: var(--bs-secondary-color);
        padding: 9px 20px;
        border-radius: 12px;
        font-size: 14px;
    }
    .category-btn:hover { background: #33261f; color: #fff; }
    .category-btn.active { background: #3d2e26; color: #fff; }

    .product-image {
        width: 100%;
        height: 210px;
        object-fit: cover;
        background: #33261f;
    }
    .product-description { font-size: 13px; min-height: 38px; }
    .price { font-size: 18px; font-weight: bold; color: var(--moza-accent); }

    #emptyMessage { display: none; }
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

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Mau makan apa hari ini? 🍕</h2>
        <p class="text-secondary mb-0">Pilih menu favorit kamu dan pesan sekarang.</p>
    </div>

    <input type="text" id="searchInput" class="form-control mb-3"
           style="max-width: 360px;" placeholder="Cari menu..." onkeyup="searchProducts()">

    <div class="d-flex flex-wrap gap-2 mb-4">
        <button type="button" class="category-btn active" onclick="filterCategory('all', this)">Semua</button>
        <button type="button" class="category-btn" onclick="filterCategory('Pizza', this)">Pizza</button>
        <button type="button" class="category-btn" onclick="filterCategory('Cemilan', this)">Cemilan</button>
        <button type="button" class="category-btn" onclick="filterCategory('Minuman', this)">Minuman</button>
    </div>

    <div class="row g-4" id="productContainer">
        @foreach ($products as $product)
            @php
                // 1. Pakai gambar dari database (lewat asset()) kalau ada
                // 2. Kalau kosong, pakai foto cadangan di folder public/images
                if (!empty($product->image)) {
                    if (\Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])) {
                        $srcFoto = $product->image;
                    } else {
                        $srcFoto = asset(ltrim($product->image, '/'));
                    }
                } else {
                    if (isset($fotoPizza[$product->nama])) {
                        $pathFoto = 'images/pizza/' . $fotoPizza[$product->nama];
                    } elseif (isset($fotoCemilan[$product->nama])) {
                        $pathFoto = 'images/cemilan/' . $fotoCemilan[$product->nama];
                    } else {
                        $pathFoto = 'images/pizza.jpg';
                    }
                    $srcFoto = asset($pathFoto);
                }
            @endphp

            <div class="col-xl-4 col-lg-6 col-md-6 product-item"
                 data-name="{{ strtolower($product->nama) }}"
                 data-category="{{ strtolower($product->kategori) }}">

                <div class="card h-100 overflow-hidden">

                    <img src="{{ $srcFoto }}"
                         alt="{{ $product->nama }}"
                         class="product-image"
                         onerror="this.onerror=null; this.src='{{ $fotoDefault }}';">

                    <div class="card-body d-flex flex-column">
                        <small class="text-secondary">{{ $product->kategori }}</small>
                        <div class="fs-5 fw-bold mb-1">{{ $product->nama }}</div>
                        <div class="product-description text-secondary mb-3">
                            {{ $product->deskripsi ?? 'Produk Pizza Moza' }}
                        </div>

                        @if (!empty($product->portion))
                            <small class="text-secondary mb-2">Porsi: {{ $product->portion }}</small>
                        @endif

                        <div class="price mb-3">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        <a href="{{ route('checkout.index', ['product' => $product->id]) }}"
                           class="btn btn-moza w-100 mt-auto">Pesan</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="emptyMessage" class="text-center text-secondary py-5">
        <h5 class="text-body">Menu tidak ditemukan</h5>
        <p>Coba pilih kategori atau kata pencarian lainnya.</p>
    </div>

@endsection

@push('scripts')
<script>
    function filterCategory(category, button) {
        document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        document.getElementById('searchInput').value = '';

        const kategori = category.toLowerCase();
        let visibleCount = 0;

        document.querySelectorAll('.product-item').forEach(function (product) {
            const show = kategori === 'all' || product.getAttribute('data-category') === kategori;
            product.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        document.getElementById('emptyMessage').style.display = visibleCount === 0 ? 'block' : 'none';
    }

    function searchProducts() {
        const input = document.getElementById('searchInput').value.toLowerCase().trim();

        let visibleCount = 0;
        document.querySelectorAll('.product-item').forEach(function (product) {
            const name = product.getAttribute('data-name');
            const category = product.getAttribute('data-category');
            const show = name.includes(input) || category.includes(input);
            product.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        document.getElementById('emptyMessage').style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>
@endpush