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
        $menuImages = [
            'Extra Chicken' => 'extra-chicken.jpeg',
            'Cheese Volcano' => 'cheese-volcano.jpeg',
            'Ekstra Beef' => 'ekstra-beef.jpeg',
            'Original Mozza' => 'original-mozza.jpeg',
            'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
            'Long Pizza' => 'long-pizza.jpeg',
            'Tape Bakar Original' => 'tape-bakar-original.jpeg',
            'Singkong Keju' => 'singkong-keju.jpeg',
            'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
        ];

        $menuPrices = [
            'Extra Chicken'            => 55000,
            'Cheese Volcano'           => 68000,
            'Ekstra Beef'              => 75000,
            'Original Mozza'           => 25000,
            'Original Cheese Volcano'  => 55000,
            'Long Pizza'               => 88000,
            'Tape Bakar Original'      => 12000,
            'Singkong Keju'            => 12000,
            'Tape Bakar Topping Keju'  => 12000,
        ];
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
                $namaProduk = $product->name;
                $harga = $menuPrices[$namaProduk] ?? $product->price;
                $image = $menuImages[$namaProduk] ?? null;
            @endphp

            <div class="col-xl-4 col-lg-6 col-md-6 product-item"
                 data-name="{{ strtolower($namaProduk) }}"
                 data-category="{{ $product->category }}">

                <div class="card h-100 overflow-hidden">

                    @if ($image)
                        <img src="{{ asset('images/pizza/' . $image) }}"
                             alt="{{ $namaProduk }}" class="product-image">
                    @else
                        <div class="product-image"></div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <small class="text-secondary">{{ $product->category }}</small>
                        <div class="fs-5 fw-bold mb-1">{{ $namaProduk }}</div>
                        <div class="product-description text-secondary mb-3">{{ $product->description }}</div>

                        <div class="price mb-3">
                            Rp{{ number_format($harga, 0, ',', '.') }}
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-moza w-100 mt-auto">Pesan</a>
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

        let visibleCount = 0;
        document.querySelectorAll('.product-item').forEach(function (product) {
            const show = category === 'all' || product.getAttribute('data-category') === category;
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
            const category = product.getAttribute('data-category').toLowerCase();
            const show = name.includes(input) || category.includes(input);
            product.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        document.getElementById('emptyMessage').style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>
@endpush
