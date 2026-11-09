@extends('layouts.pembeli')

@section('title', 'Beranda')

@push('styles')
    <style>
        /* ===== HERO CAROUSEL ===== */
        .ph-hero .carousel-item {
            min-height: 280px;
        }

        .ph-slide {
            border-radius: 16px;
            overflow: hidden;
            min-height: 280px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 32px 48px;
            gap: 24px;
        }

        .ph-slide.s1 { background: linear-gradient(110deg, #6A0801 0%, #CA4238 60%, #DE7801 130%); }
        .ph-slide.s2 { background: linear-gradient(110deg, #3a0400 0%, #6A0801 70%, #CA4238 160%); }
        .ph-slide.s3 { background: linear-gradient(110deg, #DE7801 0%, #F7D991 150%); }

        .ph-slide .tag {
            display: inline-block;
            background: var(--moza-cream);
            color: var(--moza-maroon);
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .ph-slide h1 {
            font-weight: 900;
            font-size: clamp(26px, 4.5vw, 48px);
            line-height: 1.05;
            text-transform: uppercase;
            margin: 12px 0;
            color: #fff !important;
        }

        .ph-slide p {
            color: rgba(255, 255, 255, .9) !important;
            max-width: 420px;
        }

        .ph-slide img {
            width: min(300px, 38vw);
            height: min(300px, 38vw);
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, .85);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
            flex-shrink: 0;
        }

        .btn-ph-cta {
            background: var(--moza-cream);
            color: var(--moza-maroon);
            font-weight: 900;
            border: 0;
            border-radius: 50px;
            padding: 10px 28px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .btn-ph-cta:hover {
            background: #fff;
            color: var(--moza-orange);
        }

        .ph-hero .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 0;
        }

        @media (max-width: 575.98px) {
            .ph-slide { padding: 24px; }
            .ph-slide img { display: none; }
        }

        /* ===== INFO STRIP ===== */
        .ph-info {
            background: var(--moza-cream-card);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(106, 8, 1, .08);
        }

        .ph-info .item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            font-size: 14px;
        }

        .ph-info .item .ico {
            font-size: 26px;
        }

        /* ===== TAB KATEGORI (sticky, garis bawah merah) ===== */
        .ph-tabs {
            position: sticky;
            top: 70px;
            z-index: 1020;
            background: var(--moza-cream-light);
            border-bottom: 2px solid rgba(106, 8, 1, .15);
            display: flex;
            gap: 4px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .ph-tabs::-webkit-scrollbar { display: none; }

        .ph-tab {
            background: transparent;
            border: 0;
            border-bottom: 4px solid transparent;
            margin-bottom: -2px;
            padding: 14px 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-size: 14px;
            color: rgba(106, 8, 1, .6);
            white-space: nowrap;
        }

        .ph-tab:hover { color: var(--moza-orange); }

        .ph-tab.active {
            color: var(--moza-orange);
            border-bottom-color: var(--moza-orange);
        }

        /* ===== KARTU PRODUK ===== */
        .ph-card {
            background: var(--moza-cream-card) !important;
            border: 0 !important;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(106, 8, 1, .1);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .ph-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(106, 8, 1, .2);
            background: var(--moza-cream-card) !important;
        }

        .ph-card .img-wrap {
            position: relative;
            background: var(--moza-cream-hover);
        }

        .product-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
        }

        .ph-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--moza-orange);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 50px;
        }

        .product-description {
            font-size: 13px;
            min-height: 38px;
        }

        .price {
            font-size: 20px;
            font-weight: 900;
            color: var(--moza-orange);
        }

        .btn-ph-order {
            background: var(--moza-orange);
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: 0;
            border-radius: 50px;
            padding: 9px 18px;
        }

        .btn-ph-order:hover {
            background: var(--moza-maroon);
            color: #fff;
        }

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

    {{-- ===== HERO CAROUSEL ===== --}}
    <div id="phHero" class="carousel slide ph-hero mb-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#phHero" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#phHero" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#phHero" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="ph-slide s1">
                    <div>
                        <span class="tag">Menu Favorit</span>
                        <h1>Pesan Pizza<br>Favoritmu!</h1>
                        <p>Keju melimpah, topping pilihan, dipanggang hangat dan diantar sampai depan pintu.</p>
                        <a href="#menu" class="btn btn-ph-cta">Pesan Sekarang</a>
                    </div>
                    <img src="{{ asset('images/pizza/cheese-volcano.jpeg') }}" alt="Cheese Volcano"
                        onerror="this.src='{{ $fotoDefault }}'">
                </div>
            </div>
            <div class="carousel-item">
                <div class="ph-slide s2">
                    <div>
                        <span class="tag">Best Seller</span>
                        <h1>Extra Beef,<br>Extra Puas</h1>
                        <p>Daging sapi gurih dengan saus spesial. Cocok untuk makan bersama.</p>
                        <a href="#menu" class="btn btn-ph-cta">Lihat Menu</a>
                    </div>
                    <img src="{{ asset('images/pizza/ekstra-beef.jpeg') }}" alt="Ekstra Beef"
                        onerror="this.src='{{ $fotoDefault }}'">
                </div>
            </div>
            <div class="carousel-item">
                <div class="ph-slide s3">
                    <div>
                        <span class="tag">Cemilan</span>
                        <h1>Teman Santai<br>Paling Pas</h1>
                        <p>Tape bakar dan singkong keju, murah meriah mulai Rp12.000.</p>
                        <a href="#menu" class="btn btn-ph-cta">Coba Sekarang</a>
                    </div>
                    <img src="{{ asset('images/cemilan/singkong-keju.jpeg') }}" alt="Singkong Keju"
                        onerror="this.src='{{ $fotoDefault }}'">
                </div>
            </div>
        </div>
    </div>

    {{-- ===== INFO STRIP ===== --}}
    <div class="ph-info row g-0 mb-4">
        <div class="col-md-4 item"><span class="ico">🛵</span><div><strong>Delivery</strong><br><small class="text-secondary">Diantar ke alamatmu</small></div></div>
        <div class="col-md-4 item"><span class="ico">🔥</span><div><strong>Selalu Hangat</strong><br><small class="text-secondary">Dipanggang saat dipesan</small></div></div>
        <div class="col-md-4 item"><span class="ico">💳</span><div><strong>Bayar Mudah</strong><br><small class="text-secondary">Cash atau Midtrans</small></div></div>
    </div>

    {{-- ===== TAB KATEGORI + PENCARIAN ===== --}}
    <div id="menu"></div>
    <div class="ph-tabs mb-3">
        <button type="button" class="ph-tab active" onclick="filterCategory('all', this)">Semua</button>
        <button type="button" class="ph-tab" onclick="filterCategory('Pizza', this)">Pizza</button>
        <button type="button" class="ph-tab" onclick="filterCategory('Cemilan', this)">Cemilan</button>
        <button type="button" class="ph-tab" onclick="filterCategory('Minuman', this)">Minuman</button>
    </div>

    <input type="text" id="searchInput" class="form-control form-control-lg rounded-pill mb-4"
        style="max-width: 420px;" placeholder="🔍 Cari menu..." onkeyup="searchProducts()">

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

            <div class="col-xl-4 col-lg-6 col-md-6 product-item" data-name="{{ strtolower($product->nama) }}"
                data-category="{{ strtolower($product->kategori) }}">

                <div class="card ph-card h-100">

                    <div class="img-wrap">
                        <img src="{{ $srcFoto }}" alt="{{ $product->nama }}" class="product-image"
                            onerror="this.onerror=null; this.src='{{ $fotoDefault }}';">
                        <span class="ph-badge">{{ $product->kategori }}</span>
                    </div>

                    <div class="card-body d-flex flex-column">
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
                            class="btn btn-ph-order w-100 mt-auto">Pesan Sekarang</a>
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
            document.querySelectorAll('.ph-tab').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('searchInput').value = '';

            const kategori = category.toLowerCase();
            let visibleCount = 0;

            document.querySelectorAll('.product-item').forEach(function(product) {
                const show = kategori === 'all' || product.getAttribute('data-category') === kategori;
                product.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('emptyMessage').style.display = visibleCount === 0 ? 'block' : 'none';
        }

        function searchProducts() {
            const input = document.getElementById('searchInput').value.toLowerCase().trim();

            let visibleCount = 0;
            document.querySelectorAll('.product-item').forEach(function(product) {
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
