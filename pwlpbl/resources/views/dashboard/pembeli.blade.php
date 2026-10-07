<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beranda - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #1c1512;
            color: #f3e9e1;
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #261c17;
            border-right: 1px solid rgba(255,255,255,.08);
            padding: 24px 16px;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand h4 {
            margin: 0;
            color: #eadccf;
            font-weight: 700;
        }

        .brand small {
            color: #a89485;
        }

        .nav-link {
            color: #cdbeb3;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 10px;
            text-decoration: none;
            display: block;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #3d2e26;
            color: #fff;
        }

        .logout {
            position: absolute;
            bottom: 20px;
            left: 16px;
            right: 16px;
        }

        .logout-btn {
            width: 100%;
            padding: 11px 15px;
            border: 1px solid #dc3545;
            border-radius: 6px;
            background: transparent;
            color: #dc3545;
            font-size: 14px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* MAIN */
        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 75px;
            padding: 0 30px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #eadccf;
            color: #2a1e17;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* CONTENT */
        .content {
            padding: 30px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h2 {
            margin-bottom: 5px;
        }

        .welcome p {
            color: #a89485;
            margin: 0;
        }

        /* SEARCH */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .search-box input {
            flex: 1;
            background: #261c17;
            border: 1px solid rgba(255,255,255,.1);
            color: white;
            border-radius: 10px;
            padding: 12px 15px;
            outline: none;
        }

        .search-box input::placeholder {
            color: #8f7e72;
        }

        .filter-btn {
            background: #eadccf;
            color: #2a1e17;
            border: none;
            border-radius: 10px;
            padding: 0 20px;
            font-weight: 600;
        }

        /* LAYOUT MENU */
        .menu-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 25px;
        }

        .menu-title {
            margin-bottom: 18px;
        }

        .category {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .category span {
            padding: 8px 16px;
            background: #33261f;
            border-radius: 20px;
            color: #cdbeb3;
            font-size: 14px;
            cursor: pointer;
        }

        .category span.active {
            background: #eadccf;
            color: #2a1e17;
        }

        /* PRODUCTS */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .product-card {
            background: #261c17;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 12px;
        }

        .product-image {
            width: 100%;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            background: #33261f;
            margin-bottom: 12px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-name {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .product-description {
            color: #a89485;
            font-size: 12px;
            min-height: 35px;
            margin-bottom: 10px;
        }

        .product-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .price {
            font-weight: 700;
            color: #eadccf;
        }

        .btn-order {
            border: none;
            background: #eadccf;
            color: #2a1e17;
            border-radius: 8px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-order:hover {
            background: white;
        }

        /* CART */
        .cart {
            background: #261c17;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .cart h4 {
            margin-bottom: 20px;
        }

        .cart-empty {
            text-align: center;
            padding: 35px 10px;
            color: #a89485;
        }

        .cart-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .cart-info {
            background: #33261f;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .cart-info p {
            color: #a89485;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,.1);
            font-weight: bold;
        }

        .btn-checkout {
            width: 100%;
            margin-top: 15px;
            padding: 12px;
            border: none;
            border-radius: 9px;
            background: #eadccf;
            color: #2a1e17;
            font-weight: 700;
        }

        @media (max-width: 1100px) {
            .menu-layout {
                grid-template-columns: 1fr;
            }

            .cart {
                position: static;
            }
        }

        @media (max-width: 800px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="brand">
            <h4>🍕 PIZZA MOZA</h4>
            <small>PEMBELI PANEL</small>
        </div>

        <nav>

            <a href="{{ route('dashboard.pembeli') }}"
               class="nav-link active">
                🏠 Beranda
            </a>

            <a href="{{ route('pembeli.products') }}"
               class="nav-link">
                🍕 Menu Produk
            </a>

            <a href="{{ route('pembeli.kategoris') }}"
               class="nav-link">
                📂 Kategori
            </a>

            <a href="{{ route('pesanans.index') }}"
               class="nav-link">
                📋 Pesanan Saya
            </a>

            <a href="{{ route('checkout.index') }}"
               class="nav-link">
                🛒 Checkout
            </a>

            <a href="{{ route('profil.show') }}"
               class="nav-link">
                👤 Profil
            </a>

        </nav>

        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit" class="logout-btn">
                    ⏻ Logout
                </button>

            </form>

        </div>

    </div>


    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <strong>Beranda</strong>
            </div>

            <div class="user-info">

                <div class="text-end">

                    <div style="font-size:14px;">
                        {{ session('nama') ?? 'Pembeli' }}
                    </div>

                    <small style="color:#a89485;">
                        {{ session('email') ?? '' }}
                    </small>

                </div>

                <div class="avatar">
                    {{ strtoupper(substr(session('nama') ?? 'P', 0, 1)) }}
                </div>

            </div>

        </div>


        <!-- CONTENT -->
        <div class="content">

            <div class="welcome">

                <h2>
                    Halo, {{ session('nama') ?? 'Pembeli' }} 👋
                </h2>

                <p>
                    Mau makan pizza apa hari ini?
                </p>

            </div>


            <!-- SEARCH -->
            <div class="search-box">

                <input
                    type="text"
                    id="searchProduct"
                    placeholder="🔍 Cari pizza atau produk..."
                >

                <button class="filter-btn">
                    ☰ Filter
                </button>

            </div>


            <div class="menu-layout">

                <!-- MENU -->
                <div>

                    <h4 class="menu-title">
                        Pizza Menu
                    </h4>

                    <div class="category">

                        <span class="active">
                            Semua
                        </span>

                        <span>
                            Pizza
                        </span>

                        <span>
                            Minuman
                        </span>

                        <span>
                            Snack
                        </span>

                    </div>


                    <div class="product-grid">

                        @forelse ($products as $product)

                            <div class="product-card">

                                <div class="product-image">

                                    @if ($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                        >
                                    @else
                                        <img
                                            src="{{ asset('images/pizza.jpg') }}"
                                            alt="Pizza"
                                        >
                                    @endif

                                </div>

                                <div class="product-name">
                                    {{ $product->name }}
                                </div>

                                <div class="product-description">
                                    {{ Str::limit($product->description ?? 'Pizza lezat khas Pizza Moza.', 65) }}
                                </div>

                                <div class="product-bottom">

                                    <div class="price">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>

                                    <a
                                        href="{{ route('checkout.index') }}"
                                        class="btn-order"
                                    >
                                        Pesan
                                    </a>

                                </div>

                            </div>

                        @empty

                            <div class="col-12">

                                <div class="cart-empty">

                                    <div class="cart-icon">
                                        🍕
                                    </div>

                                    <h5>
                                        Belum ada produk
                                    </h5>

                                    <p>
                                        Produk pizza belum tersedia.
                                    </p>

                                </div>

                            </div>

                        @endforelse

                    </div>

                </div>


                <!-- CART -->
                <div class="cart">

                    <h4>
                        🛒 Ringkasan Pesanan
                    </h4>

                    <div class="cart-empty">

                        <div class="cart-icon">
                            🍕
                        </div>

                        <strong>
                            Belum ada pesanan
                        </strong>

                        <p>
                            Pilih pizza yang kamu mau.
                        </p>

                    </div>

                    <div class="cart-info">

                        <p>
                            Untuk melakukan pemesanan,
                            pilih produk terlebih dahulu.
                        </p>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn-checkout d-block text-center text-decoration-none"
                        >
                            Buat Pesanan
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>

        const searchInput =
            document.getElementById('searchProduct');

        searchInput.addEventListener('keyup', function () {

            const keyword =
                this.value.toLowerCase();

            const products =
                document.querySelectorAll('.product-card');

            products.forEach(function (product) {

                const name =
                    product.querySelector('.product-name')
                    .textContent
                    .toLowerCase();

                if (name.includes(keyword)) {

                    product.style.display = '';

                } else {

                    product.style.display = 'none';

                }

            });

        });

    </script>

</body>
</html>

