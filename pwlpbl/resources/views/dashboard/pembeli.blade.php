<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beranda - Pizza Moza</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

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
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #261c17;
            border-right: 1px solid rgba(255,255,255,.08);
            padding: 25px 18px;
        }

        .brand {
            text-align: center;
            margin-bottom: 35px;
        }

        .brand h4 {
            margin: 0;
            color: #eadccf;
            font-weight: 700;
        }

        .brand small {
            color: #a89485;
        }

        .menu-title {
            color: #806f63;
            font-size: 12px;
            text-transform: uppercase;
            margin: 20px 12px 10px;
        }

        .nav-link {
            color: #cdbdb1;
            padding: 12px 14px;
            border-radius: 9px;
            margin-bottom: 5px;
            text-decoration: none;
            display: block;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #3d2e26;
            color: #fff;
        }

        .logout {
            color: #e58d8d !important;
        }

        /* MAIN */
        .main {
            margin-left: 240px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 75px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            background: #1c1512;
        }

        .search-box {
            width: 350px;
        }

        .search-box input {
            width: 100%;
            background: #261c17;
            border: 1px solid rgba(255,255,255,.08);
            color: #fff;
            border-radius: 8px;
            padding: 10px 14px;
            outline: none;
        }

        .search-box input::placeholder {
            color: #8f7f73;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
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
            padding: 30px 35px 50px;
        }

        .welcome h2 {
            margin-bottom: 5px;
            font-weight: 700;
        }

        .welcome p {
            color: #a89485;
            margin-bottom: 28px;
        }

        /* CATEGORY */
        .category-list {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .category-btn {
            border: 1px solid #514138;
            background: #261c17;
            color: #cdbdb1;
            padding: 9px 18px;
            border-radius: 20px;
            cursor: pointer;
        }

        .category-btn.active,
        .category-btn:hover {
            background: #eadccf;
            color: #2a1e17;
        }

        /* PRODUCT CARD */
        .product-card {
            background: #261c17;
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 14px;
            overflow: hidden;
            height: 100%;
        }

        .product-image {
            width: 100%;
            height: 220px;
            background: #33261f;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-body {
            padding: 18px;
        }

        .product-name {
            font-size: 19px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 7px;
        }

        .product-description {
            font-size: 13px;
            color: #a89485;
            min-height: 40px;
            margin-bottom: 15px;
        }

        .size-title {
            font-size: 12px;
            color: #a89485;
            margin-bottom: 7px;
        }

        .size-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .size-btn {
            border: 1px solid #5a493e;
            background: transparent;
            color: #d7c8bc;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
            cursor: pointer;
        }

        .size-btn.active,
        .size-btn:hover {
            background: #eadccf;
            color: #2a1e17;
            border-color: #eadccf;
        }

        .product-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .price {
            color: #eadccf;
            font-weight: 700;
            font-size: 17px;
        }

        .btn-order {
            background: #eadccf;
            color: #2a1e17;
            border: none;
            border-radius: 7px;
            padding: 8px 15px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-order:hover {
            background: #fff;
            color: #2a1e17;
        }

        .no-product {
            background: #261c17;
            border-radius: 12px;
            padding: 35px;
            text-align: center;
            color: #a89485;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
            }

            .search-box {
                width: 250px;
            }
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="brand">
        <h4>🍕 PIZZA MOZA</h4>
        <small>PEMBELI PANEL</small>
    </div>

    <div class="menu-title">Menu</div>

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
        🧾 Pesanan Saya
    </a>

    <a href="{{ route('checkout.index') }}"
       class="nav-link">
        🛒 Checkout
    </a>

    <a href="{{ route('profil.show') }}"
       class="nav-link">
        👤 Profil
    </a>

    <div class="menu-title">Akun</div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit"
                class="nav-link logout border-0 bg-transparent w-100 text-start">
            🚪 Logout
        </button>
    </form>

</aside>


<!-- MAIN -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="search-box">
            <input
                type="text"
                id="searchProduct"
                placeholder="Cari menu pizza..."
            >
        </div>

        <div class="user-info">

            <div>
                <div style="font-size: 14px;">
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

            <h2>Mau makan apa hari ini? 🍕</h2>

            <p>
                Pilih pizza favorit kamu dan langsung pesan.
            </p>

        </div>


        <!-- CATEGORY -->
        <div class="category-list">

            <button class="category-btn active">
                Semua
            </button>

            <button class="category-btn">
                Pizza
            </button>

            <button class="category-btn">
                Cheese
            </button>

            <button class="category-btn">
                Beef
            </button>

            <button class="category-btn">
                Chicken
            </button>

        </div>


        <!-- PRODUCTS -->
        <div class="row g-4">

            @php

                $menuImages = [
                    'Extra Chicken' => 'extra-chicken.jpeg',
                    'Cheese Volcano' => 'cheese-volcano.jpeg',
                    'Ekstra Beef' => 'ekstra-beef.jpeg',
                    'Original Mozza' => 'original-mozza.jpeg',
                    'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
                    'Long Pizza' => 'long-pizza.jpeg',
                ];

                $menuPrices = [
                    'Extra Chicken' => [
                        'Medium' => 55000,
                        'Large' => 80000,
                        'Extra Large' => 95000,
                    ],

                    'Cheese Volcano' => [
                        'Medium' => 68000,
                        'Large' => 93000,
                        'Extra Large' => 105000,
                    ],

                    'Ekstra Beef' => [
                        'Medium' => 75000,
                        'Large' => 105000,
                        'Extra Large' => 125000,
                    ],

                    'Original Mozza' => [
                        'Mini' => 25000,
                        'Medium' => 40000,
                        'Large' => 65000,
                        'Extra Large' => 85000,
                    ],

                    'Original Cheese Volcano' => [
                        'Medium' => 55000,
                        'Large' => 78000,
                        'Extra Large' => 90000,
                    ],

                    'Long Pizza' => [
                        'Original' => 88000,
                        'Extra Mozza' => 100000,
                        'Extra Ayam' => 100000,
                        'Extra Beef' => 120000,
                    ],
                ];

            @endphp


            @forelse ($products as $product)

                @php

                    $namaProduk = $product->name;

                    $image = $menuImages[$namaProduk] ?? null;

                    $prices = $menuPrices[$namaProduk]
                        ?? [
                            'Normal' => $product->price
                        ];

                    $firstSize = array_key_first($prices);

                    $firstPrice = $prices[$firstSize];

                @endphp


                <div class="col-xl-4 col-lg-6 col-md-6 product-item"
                     data-name="{{ strtolower($namaProduk) }}">

                    <div class="product-card">

                        <!-- FOTO -->
                        <div class="product-image">

                            @if ($image)

                                <img
                                    src="{{ asset('images/pizza/' . $image) }}"
                                    alt="{{ $namaProduk }}"
                                >

                            @else

                                <img
                                    src="{{ asset('images/pizza.jpg') }}"
                                    alt="{{ $namaProduk }}"
                                >

                            @endif

                        </div>


                        <!-- BODY -->
                        <div class="product-body">

                            <div class="product-name">
                                {{ $namaProduk }}
                            </div>

                            <div class="product-description">
                                {{ $product->description ?? 'Pizza lezat khas Pizza Moza.' }}
                            </div>


                            <div class="size-title">
                                Pilih ukuran
                            </div>

                            <div class="size-buttons">

                                @foreach ($prices as $size => $price)

                                    <button
                                        type="button"
                                        class="size-btn {{ $loop->first ? 'active' : '' }}"
                                        data-price="{{ $price }}"
                                        onclick="changePrice(this)"
                                    >
                                        {{ $size }}
                                    </button>

                                @endforeach

                            </div>


                            <div class="product-bottom">

                                <div class="price">
                                    Rp {{ number_format($firstPrice, 0, ',', '.') }}
                                </div>

                                <a
                                    href="{{ route('checkout.index') }}"
                                    class="btn-order"
                                >
                                    Pesan
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="no-product">
                        Belum ada produk.
                    </div>

                </div>

            @endforelse

        </div>

    </div>

</main>


<script>

    function changePrice(button) {

        const card = button.closest('.product-card');

        const price = button.getAttribute('data-price');

        const priceElement = card.querySelector('.price');

        priceElement.innerText =
            'Rp ' + Number(price).toLocaleString('id-ID');


        const buttons =
            card.querySelectorAll('.size-btn');

        buttons.forEach(function(btn) {
            btn.classList.remove('active');
        });

        button.classList.add('active');
    }


    // SEARCH
    const searchInput =
        document.getElementById('searchProduct');

    searchInput.addEventListener('keyup', function() {

        const keyword =
            this.value.toLowerCase();

        const products =
            document.querySelectorAll('.product-item');

        products.forEach(function(product) {

            const name =
                product.getAttribute('data-name');

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
