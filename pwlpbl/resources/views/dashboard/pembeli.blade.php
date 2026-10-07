<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pembeli - Pizza Moza</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
            --bs-tertiary-bg: #33261f;
            --bs-secondary-bg: #261c17;
            --bs-card-bg: #261c17;

            --moza-accent: #eadccf;
            --moza-accent-text: #2a1e17;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #1c1512;
            color: #f3e9e1;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 245px;
            height: 100vh;
            background: #261c17;
            color: #f3e9e1;
            padding: 25px 18px;
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #f3e9e1;
            letter-spacing: 1px;
        }

        .menu-title {
            color: #a89485;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-menu a {
            text-decoration: none;
            color: #a89485;
            padding: 12px 14px;
            border-radius: 12px;
            transition: 0.2s;
            font-size: 14px;
        }

        .sidebar-menu a:hover {
            background: #33261f;
            color: #fff;
        }

        .sidebar-menu a.active {
            background: #3d2e26;
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }


        /* =========================
           LOGOUT
        ========================= */

        .logout {
            position: absolute;
            bottom: 25px;
            left: 18px;
            right: 18px;
        }

        .logout button {
            width: 100%;
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #dc3545;
            color: white;
        }


        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 245px;
            padding: 28px 35px;
            background: #1c1512;
            min-height: 100vh;
        }


        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .search-box {
            width: 360px;
        }

        .search-box input {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: #261c17;
            color: #f3e9e1;
            padding: 12px 16px;
            border-radius: 8px;
            outline: none;
        }

        .search-box input::placeholder {
            color: #a89485;
        }

        .search-box input:focus {
            border-color: #eadccf;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: bold;
            font-size: 14px;
            color: #f3e9e1;
        }

        .date-time {
            color: #a89485;
            font-size: 12px;
            margin-top: 3px;
        }


        /* =========================
           WELCOME
        ========================= */

        .welcome {
            margin-bottom: 28px;
        }

        .welcome h1 {
            font-size: 30px;
            margin-bottom: 7px;
            color: #f3e9e1;
        }

        .welcome p {
            color: #a89485;
            margin: 0;
        }


        /* =========================
           CATEGORY
        ========================= */

        .category-list {
            display: flex;
            gap: 10px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .category-btn {
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: #261c17;
            color: #a89485;
            padding: 9px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
        }

        .category-btn:hover {
            background: #33261f;
            color: #fff;
        }

        .category-btn.active {
            background: #3d2e26;
            color: #fff;
            border-color: rgba(255, 255, 255, 0.08);
        }


        /* =========================
           PRODUCT CARD
        ========================= */

        .product-card {
            background: #261c17;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
            height: 100%;
        }

        .product-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
            background: #33261f;
        }

        .product-content {
            padding: 18px;
        }

        .product-category {
            font-size: 12px;
            color: #a89485;
            margin-bottom: 6px;
        }

        .product-name {
            font-size: 19px;
            font-weight: bold;
            margin-bottom: 7px;
            color: #f3e9e1;
        }

        .product-description {
            font-size: 13px;
            color: #a89485;
            min-height: 38px;
            margin-bottom: 15px;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #eadccf;
            margin-bottom: 13px;
        }


        /* =========================
           SIZE
        ========================= */

        .size-title {
            font-size: 12px;
            color: #a89485;
            margin-bottom: 7px;
        }

        .size-list {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .size-btn {
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: #33261f;
            color: #a89485;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
        }

        .size-btn:hover {
            background: #3d2e26;
            color: #fff;
        }

        .size-btn.active {
            background: #eadccf;
            border-color: #eadccf;
            color: #2a1e17;
        }


        /* =========================
           PESAN BUTTON
        ========================= */

        .pesan-btn {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            background: #eadccf;
            color: #2a1e17;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            border: none;
            cursor: pointer;
        }

        .pesan-btn:hover {
            background: #fff;
            color: #2a1e17;
        }


        /* =========================
           EMPTY
        ========================= */

        .empty-message {
            text-align: center;
            padding: 60px 20px;
            color: #a89485;
            display: none;
        }

        .empty-message h5 {
            color: #f3e9e1;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 25px;
            }

            .search-box {
                width: 280px;
            }

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

            .main {
                margin-left: 0;
            }

            .topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .search-box {
                width: 100%;
            }

            .user-info {
                text-align: left;
            }

        }

    </style>
</head>


<body>


    <!-- =========================
         SIDEBAR
    ========================= -->

    <div class="sidebar">

        <!-- LOGO -->

        <div class="d-flex align-items-center gap-2 mb-4">

            <span style="font-size: 32px;">
                🍕
            </span>

            <div class="brand">
                PIZZA MOZA
            </div>

        </div>


        <!-- MENU -->

        <div class="menu-title">
            Menu
        </div>


        <div class="sidebar-menu">

            <a
                href="{{ route('dashboard.pembeli') }}"
                class="active"
            >
                🏠 Beranda
            </a>


            <a
                href="{{ route('pembeli.products') }}"
            >
                🍕 Produk
            </a>


            <a
                href="{{ route('checkout.index') }}"
            >
                🛒 Checkout
            </a>


            <a
                href="{{ route('pesanans.index') }}"
            >
                📋 Pesanan Saya
            </a>


            <a
                href="{{ route('profil.show') }}"
            >
                👤 Profil
            </a>

        </div>


        <!-- LOGOUT -->

        <div class="logout">

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button type="submit">
                    ⏻ Logout
                </button>

            </form>

        </div>

    </div>



    <!-- =========================
         MAIN
    ========================= -->

    <div class="main">


        <!-- TOPBAR -->

        <div class="topbar">


            <div class="search-box">

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari menu..."
                    onkeyup="searchProducts()"
                >

            </div>


            <div class="user-info">

                <div class="user-name">

                    {{ session('nama') ?? 'Pembeli' }}

                </div>


                <div class="date-time">

                    <span id="currentDate"></span>

                    <span> • </span>

                    <span id="currentTime"></span>

                </div>

            </div>

        </div>



        <!-- =========================
             WELCOME
        ========================= -->

        <div class="welcome">

            <h1>
                Mau makan apa hari ini? 🍕
            </h1>

            <p>
                Pilih menu favorit kamu dan pesan sekarang.
            </p>

        </div>



        <!-- =========================
             CATEGORY
        ========================= -->

        <div class="category-list">

            <button
                type="button"
                class="category-btn active"
                onclick="filterCategory('all', this)"
            >
                Semua
            </button>


            <button
                type="button"
                class="category-btn"
                onclick="filterCategory('Pizza', this)"
            >
                Pizza
            </button>


            <button
                type="button"
                class="category-btn"
                onclick="filterCategory('Cemilan', this)"
            >
                Cemilan
            </button>


            <button
                type="button"
                class="category-btn"
                onclick="filterCategory('Minuman', this)"
            >
                Minuman
            </button>

        </div>



        <!-- =========================
             PRODUCTS
        ========================= -->

        <div
            class="row g-4"
            id="productContainer"
        >


            @php

                $menuImages = [

                    // Pizza
                    'Extra Chicken' => 'extra-chicken.jpeg',
                    'Cheese Volcano' => 'cheese-volcano.jpeg',
                    'Ekstra Beef' => 'ekstra-beef.jpeg',
                    'Original Mozza' => 'original-mozza.jpeg',
                    'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
                    'Long Pizza' => 'long-pizza.jpeg',

                    // Cemilan
                    'Tape Bakar Original' => 'tape-bakar-original.jpeg',
                    'Singkong Keju' => 'singkong-keju.jpeg',
                    'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',

                ];


                $menuPrices = [

                    // =========================
                    // PIZZA
                    // =========================

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


                    // =========================
                    // CEMILAN
                    // =========================

                    'Tape Bakar Original' => [
                        'Box Kecil' => 12000,
                        'Box Sedang' => 17000,
                        'Box Besar' => 25000,
                    ],

                    'Singkong Keju' => [
                        'Box Kecil' => 12000,
                        'Box Sedang' => 17000,
                        'Box Besar' => 25000,
                    ],

                    'Tape Bakar Topping Keju' => [
                        'Box Kecil' => 12000,
                        'Box Sedang' => 17000,
                        'Box Besar' => 25000,
                    ],

                ];

            @endphp



            @foreach ($products as $product)

                @php

                    $namaProduk = $product->name;

                    $prices = $menuPrices[$namaProduk] ?? [
                        $product->portion => $product->price
                    ];

                    $image = $menuImages[$namaProduk] ?? null;

                    $firstPrice = reset($prices);

                @endphp


                <div
                    class="col-xl-4 col-lg-6 col-md-6 product-item"
                    data-name="{{ strtolower($namaProduk) }}"
                    data-category="{{ $product->category }}"
                >


                    <div class="product-card">


                        <!-- GAMBAR -->

                        @if ($image)

                            <img
                                src="{{ asset('images/pizza/' . $image) }}"
                                alt="{{ $namaProduk }}"
                                class="product-image"
                            >

                        @else

                            <div class="product-image"></div>

                        @endif



                        <div class="product-content">


                            <!-- KATEGORI -->

                            <div class="product-category">

                                {{ $product->category }}

                            </div>



                            <!-- NAMA -->

                            <div class="product-name">

                                {{ $namaProduk }}

                            </div>



                            <!-- DESKRIPSI -->

                            <div class="product-description">

                                {{ $product->description }}

                            </div>



                            <!-- HARGA -->

                            <div
                                class="price"
                                id="price-{{ $product->id }}"
                            >

                                Rp{{ number_format(
                                    $firstPrice,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>



                            <!-- UKURAN -->

                            <div class="size-title">

                                Pilih ukuran:

                            </div>



                            <div class="size-list">


                                @foreach ($prices as $size => $price)

                                    <button
                                        type="button"
                                        class="size-btn {{ $loop->first ? 'active' : '' }}"
                                        data-product="{{ $product->id }}"
                                        data-price="{{ $price }}"
                                        onclick="changePrice(this)"
                                    >

                                        {{ $size }}

                                    </button>

                                @endforeach


                            </div>



                            <!-- PESAN -->

                            <a
                                href="{{ route('checkout.index') }}"
                                class="pesan-btn"
                            >
                                Pesan
                            </a>


                        </div>

                    </div>

                </div>

            @endforeach


        </div>



        <!-- =========================
             EMPTY MESSAGE
        ========================= -->

        <div
            id="emptyMessage"
            class="empty-message"
        >

            <h5>
                Menu tidak ditemukan
            </h5>

            <p>
                Coba pilih kategori atau kata pencarian lainnya.
            </p>

        </div>


    </div>



    <!-- =========================
         JAVASCRIPT
    ========================= -->

    <script>


        // =========================
        // UBAH HARGA
        // =========================

        function changePrice(button) {

            const productId =
                button.getAttribute('data-product');


            const price =
                parseInt(
                    button.getAttribute('data-price')
                );


            const priceElement =
                document.getElementById(
                    'price-' + productId
                );


            if (priceElement) {

                priceElement.innerText =
                    'Rp' +
                    price.toLocaleString('id-ID');

            }


            const buttons =
                document.querySelectorAll(
                    '.size-btn[data-product="' +
                    productId +
                    '"]'
                );


            buttons.forEach(function(btn) {

                btn.classList.remove('active');

            });


            button.classList.add('active');

        }



        // =========================
        // FILTER KATEGORI
        // =========================

        function filterCategory(
            category,
            button
        ) {

            const products =
                document.querySelectorAll(
                    '.product-item'
                );


            const buttons =
                document.querySelectorAll(
                    '.category-btn'
                );


            const searchInput =
                document.getElementById(
                    'searchInput'
                );


            const emptyMessage =
                document.getElementById(
                    'emptyMessage'
                );


            buttons.forEach(function(btn) {

                btn.classList.remove('active');

            });


            button.classList.add('active');


            searchInput.value = '';


            let visibleCount = 0;


            products.forEach(function(product) {

                const productCategory =
                    product.getAttribute(
                        'data-category'
                    );


                if (
                    category === 'all' ||
                    productCategory === category
                ) {

                    product.style.display = '';

                    visibleCount++;

                } else {

                    product.style.display = 'none';

                }

            });


            if (visibleCount === 0) {

                emptyMessage.style.display = 'block';

            } else {

                emptyMessage.style.display = 'none';

            }

        }



        // =========================
        // SEARCH
        // =========================

        function searchProducts() {

            const input =
                document.getElementById(
                    'searchInput'
                )
                .value
                .toLowerCase()
                .trim();


            const products =
                document.querySelectorAll(
                    '.product-item'
                );


            const emptyMessage =
                document.getElementById(
                    'emptyMessage'
                );


            let visibleCount = 0;


            products.forEach(function(product) {

                const name =
                    product.getAttribute(
                        'data-name'
                    );


                const category =
                    product.getAttribute(
                        'data-category'
                    )
                    .toLowerCase();


                if (
                    name.includes(input) ||
                    category.includes(input)
                ) {

                    product.style.display = '';

                    visibleCount++;

                } else {

                    product.style.display = 'none';

                }

            });


            if (visibleCount === 0) {

                emptyMessage.style.display = 'block';

            } else {

                emptyMessage.style.display = 'none';

            }

        }



        // =========================
        // TANGGAL & JAM
        // =========================

        function updateDateTime() {

            const now = new Date();


            const date =
                now.toLocaleDateString(
                    'id-ID',
                    {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }
                );


            const time =
                now.toLocaleTimeString(
                    'id-ID',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }
                );


            document.getElementById(
                'currentDate'
            ).innerText = date;


            document.getElementById(
                'currentTime'
            ).innerText = time;

        }


        updateDateTime();


        setInterval(
            updateDateTime,
            1000
        );

    </script>


</body>

</html>
