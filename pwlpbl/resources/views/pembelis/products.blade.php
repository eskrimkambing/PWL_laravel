<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produk - Pizza Moza</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #1c1512;
            color: #f3e9e1;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 245px;
            height: 100vh;
            background: #261c17;
            padding: 25px 18px;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .menu-title {
            color: #a89485;
            font-size: 13px;
            margin: 30px 0 12px;
        }

        .sidebar-menu a {
            display: block;
            text-decoration: none;
            color: #a89485;
            padding: 13px 15px;
            margin-bottom: 7px;
            border-radius: 10px;
            font-size: 15px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #3d2e26;
            color: white;
        }

        .logout {
            position: absolute;
            bottom: 25px;
            left: 18px;
            right: 18px;
        }

        .logout button {
            width: 100%;
            padding: 11px;
            background: transparent;
            border: 1px solid #842029;
            color: #dc3545;
            border-radius: 8px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #842029;
            color: white;
        }

        .content {
            margin-left: 245px;
            padding: 35px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            color: #a89485;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            max-width: 450px;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #49362c;
            background: #261c17;
            color: white;
            outline: none;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #261c17;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 170px;
            object-fit: cover;
            background: #33261f;
        }

        .product-info {
            padding: 18px;
        }

        .product-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-category {
            color: #a89485;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .product-description {
            color: #b9aaa0;
            font-size: 14px;
            line-height: 1.5;
            min-height: 42px;
        }

        .product-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .price {
            font-weight: bold;
            color: #f3e9e1;
        }

        .btn-pesan {
            text-decoration: none;
            background: #eadccf;
            color: #2a1e17;
            padding: 8px 13px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-pesan:hover {
            background: white;
        }

        .empty {
            color: #a89485;
            padding: 30px 0;
        }

        @media (max-width: 700px) {

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .logout {
                position: static;
                margin-top: 30px;
            }

            .content {
                margin-left: 0;
                padding: 25px 18px;
            }

            .products {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="d-flex align-items-center gap-2 mb-4">
            <span style="font-size: 32px;">🍕</span>
            <div class="brand">PIZZA MOZA</div>
        </div>

        <div class="menu-title">Menu</div>

        <div class="sidebar-menu">

            <a href="{{ route('dashboard.pembeli') }}">
                🏠 Beranda
            </a>

            <a href="{{ route('pembeli.products') }}" class="active">
                🍕 Produk
            </a>

            <a href="{{ route('checkout.index') }}">
                🛒 Checkout
            </a>

            <a href="{{ route('pesanans.index') }}">
                📋 Pesanan Saya
            </a>

            <a href="{{ route('profil.show') }}">
                👤 Profil
            </a>

        </div>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit">
                    ⏻ Logout
                </button>
            </form>
        </div>

    </div>


    <!-- CONTENT -->
    <div class="content">

        <div class="header">
            <h1>Produk Pizza Moza</h1>
            <p>Pilih produk yang ingin kamu pesan.</p>
        </div>


        <!-- SEARCH -->
        <div class="search-box">
            <input
                type="text"
                id="search"
                placeholder="Cari produk..."
                onkeyup="cariProduk()"
            >
        </div>


        <!-- PRODUCTS -->
        <div class="products" id="productList">

            @forelse ($products as $product)

                <div class="product-card">

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | FOTO PIZZA
                        |--------------------------------------------------------------------------
                        */

                        $fotoPizza = [

                            'Extra Chicken' => 'extra-chicken.jpeg',
                            'Cheese Volcano' => 'cheese-volcano.jpeg',
                            'Ekstra Beef' => 'ekstra-beef.jpeg',
                            'Original Mozza' => 'original-mozza.jpeg',
                            'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
                            'Long Pizza' => 'long-pizza.jpeg',

                        ];


                        /*
                        |--------------------------------------------------------------------------
                        | FOTO CEMILAN
                        |--------------------------------------------------------------------------
                        */

                        $fotoCemilan = [

                            'Tape Bakar Original' => 'tape-bakar-original.jpeg',
                            'Singkong Keju' => 'singkong-keju.jpeg',
                            'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',

                        ];


                        /*
                        |--------------------------------------------------------------------------
                        | MENENTUKAN FOTO PRODUK
                        |--------------------------------------------------------------------------
                        */

                        if (isset($fotoPizza[$product->name])) {

                            $pathFoto = 'images/pizza/' . $fotoPizza[$product->name];

                        } elseif (isset($fotoCemilan[$product->name])) {

                            $pathFoto = 'images/cemilan/' . $fotoCemilan[$product->name];

                        } else {

                            $pathFoto = 'images/pizza.jpg';

                        }

                    @endphp


                    <!-- FOTO PRODUK -->
                    <img
                        src="{{ asset($pathFoto) }}"
                        alt="{{ $product->name }}"
                        class="product-image"
                    >


                    <div class="product-info">

                        <!-- NAMA PRODUK -->
                        <div class="product-name">
                            {{ $product->name }}
                        </div>


                        <!-- KATEGORI -->
                        <div class="product-category">
                            {{ $product->category }}
                        </div>


                        <!-- DESKRIPSI -->
                        <div class="product-description">
                            {{ $product->description ?? 'Produk Pizza Moza' }}
                        </div>


                        <!-- HARGA + PESAN -->
                        <div class="product-bottom">

                            <div class="price">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <a
                                href="{{ route('checkout.index') }}"
                                class="btn-pesan"
                            >
                                Pesan
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty">
                    Belum ada produk yang tersedia.
                </div>

            @endforelse

        </div>

    </div>


    <!-- SEARCH SCRIPT -->
    <script>

        function cariProduk() {

            const input = document
                .getElementById('search')
                .value
                .toLowerCase();

            const products = document.querySelectorAll('.product-card');

            products.forEach(function(product) {

                const nama = product
                    .querySelector('.product-name')
                    .textContent
                    .toLowerCase();

                if (nama.includes(input)) {

                    product.style.display = '';

                } else {

                    product.style.display = 'none';

                }

            });

        }

    </script>

</body>
</html>
