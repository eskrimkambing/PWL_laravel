
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pizza Moza - Pesan Pizza Favoritmu</title>

    <style>
        :root {
            --cream: #FFF4DC;
            --beige: #F8EED7;
            --orange: #E87900;
            --yellow: #F7D98C;
            --brown: #7B160D;
            --border: #E8D6B5;
            --white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--cream);
            color: var(--brown);
        }

        /* NAVBAR */

        .navbar {
            height: 85px;
            padding: 0 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--brown);
            font-size: 23px;
            font-weight: bold;
        }

        .logo span {
            font-size: 35px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--brown);
            font-size: 14px;
            font-weight: bold;
        }

        .nav-menu a:hover {
            color: var(--orange);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .login-link {
            color: var(--brown);
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .order-btn {
            background: var(--orange);
            color: white;
            text-decoration: none;
            padding: 13px 23px;
            border-radius: 9px;
            font-weight: bold;
        }

        .order-btn:hover,
        .primary-btn:hover {
            background: #CC6800;
        }

        /* HERO BANNER */

        .hero {
            min-height: 475px;
            padding: 65px 7%;
            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    90deg,
                    rgba(123, 22, 13, 0.88),
                    rgba(123, 22, 13, 0.50),
                    rgba(123, 22, 13, 0.05)
                ),
                url('{{ asset('images/pizza.jpg') }}');

            background-size: cover;
            background-position: center;
        }

        .hero-content {
            max-width: 560px;
            color: white;
        }

        .hero-label {
            display: inline-block;
            background: var(--yellow);
            color: var(--brown);
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: clamp(42px, 6vw, 70px);
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 15px;
        }

        .hero h2 {
            font-size: 25px;
            margin-bottom: 15px;
        }

        .hero p {
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 27px;
            color: #fff4dc;
        }

        .primary-btn {
            display: inline-block;
            background: var(--orange);
            color: white;
            text-decoration: none;
            padding: 15px 28px;
            border-radius: 9px;
            font-weight: bold;
            transition: .2s;
        }

        /* LAYANAN */

        .services {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            padding: 0 5%;
            margin-top: -35px;
            position: relative;
            z-index: 2;
        }

        .service-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 23px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 5px 15px rgba(80, 40, 10, .08);
        }

        .service-icon {
            font-size: 38px;
        }

        .service-card h3 {
            color: var(--brown);
            font-size: 19px;
        }

        .service-card p {
            color: #986b4f;
            font-size: 12px;
            margin-top: 6px;
        }

        /* MENU SECTION */

        .menu-section {
            padding: 65px 5%;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-heading h2 {
            font-size: 32px;
            color: var(--brown);
            margin-bottom: 9px;
        }

        .section-heading p {
            color: #966b53;
            font-size: 15px;
        }

        /* SEARCH */

        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        .search-box input {
            width: 100%;
            max-width: 420px;
            padding: 14px 17px;
            border: 1px solid var(--border);
            border-radius: 9px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .search-box input:focus {
            border-color: var(--orange);
        }

        /* FILTER */

        .filter-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 32px;
        }

        .category-btn {
            border: 1px solid #D9A45A;
            background: var(--yellow);
            color: var(--brown);
            padding: 11px 23px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--orange);
            color: white;
            border-color: var(--orange);
        }

        /* PRODUCT CARD */

        .product-container {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .product-item {
            min-width: 0;
        }

        .product-card {
            height: 100%;
            background: #FFFAF0;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: .25s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 9px 22px rgba(80, 40, 10, .12);
        }

        .product-image {
            width: 100%;
            height: 225px;
            object-fit: cover;
            background: var(--beige);
        }

        .product-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-category {
            color: var(--orange);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 21px;
            margin-bottom: 9px;
            color: var(--brown);
        }

        .product-description {
            color: #966b53;
            font-size: 13px;
            line-height: 1.6;
            min-height: 40px;
            margin-bottom: 12px;
        }

        .portion {
            font-size: 13px;
            color: #966b53;
            margin-bottom: 12px;
        }

        .price {
            font-size: 19px;
            font-weight: bold;
            color: var(--orange);
            margin-bottom: 17px;
        }

        .product-btn {
            display: block;
            margin-top: auto;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            color: white;
            background: var(--orange);
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .product-btn:hover {
            background: #CC6800;
        }

        #emptyMessage {
            display: none;
            text-align: center;
            padding: 50px 15px;
            color: #966b53;
        }

        /* FOOTER */

        footer {
            background: var(--brown);
            color: white;
            text-align: center;
            padding: 30px 15px;
            line-height: 1.8;
        }

        footer strong {
            color: var(--yellow);
            font-size: 20px;
        }

        /* RESPONSIVE */

        @media(max-width: 900px) {
            .nav-menu {
                gap: 15px;
            }

            .product-container {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width: 650px) {
            .navbar {
                height: auto;
                padding: 17px 20px;
                flex-wrap: wrap;
                gap: 17px;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: center;
                gap: 17px;
            }

            .nav-menu a {
                font-size: 11px;
            }

            .nav-actions {
                gap: 10px;
            }

            .login-link {
                font-size: 12px;
            }

            .order-btn {
                padding: 10px 13px;
                font-size: 12px;
            }

            .hero {
                min-height: 400px;
                padding: 40px 25px;
                background-position: center;
            }

            .hero h2 {
                font-size: 20px;
            }

            .hero p {
                font-size: 14px;
            }

            .services {
                grid-template-columns: 1fr;
                padding: 0 20px;
                margin-top: 20px;
                gap: 12px;
            }

            .menu-section {
                padding: 45px 20px;
            }

            .section-heading h2 {
                font-size: 25px;
            }

            .product-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .product-image {
                height: 230px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <header class="navbar">

        <a href="{{ route('home') }}" class="logo">
            <span>🍕</span>
            PIZZA MOZA
        </a>

        <nav class="nav-menu">
            <a href="{{ route('home') }}">HOME</a>
            <a href="#menu">MENU</a>
            <a href="#layanan">LAYANAN</a>
            <a href="#tentang">TENTANG KAMI</a>
        </nav>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="login-link">
                Login / Register
            </a>

            <a href="#menu" class="order-btn">
                Order Now
            </a>
        </div>

    </header>


    <!-- HERO BANNER -->

    <section class="hero">

        <div class="hero-content">

            <span class="hero-label">
                🍕 SPECIAL MENU PIZZA MOZA
            </span>

            <h1>
                PIZZA MOZA
            </h1>

            <h2>
                RASA JUARA, HARGA BERSAHABAT!
            </h2>

            <p>
                Nikmati kelezatan pizza dengan topping pilihan,
                keju melimpah, dan cita rasa yang bikin ketagihan.
                Pilih menu favoritmu dan pesan sekarang!
            </p>

            <a href="#menu" class="primary-btn">
                LIHAT MENU →
            </a>

        </div>

    </section>


    <!-- LAYANAN -->

    <section class="services" id="layanan">

        <div class="service-card">
            <span class="service-icon">🛵</span>
            <div>
                <h3>Delivery</h3>
                <p>Pesanan diantar ke tempatmu.</p>
            </div>
        </div>

        <div class="service-card">
            <span class="service-icon">🍕</span>
            <div>
                <h3>Takeaway</h3>
                <p>Pesan dan ambil langsung.</p>
            </div>
        </div>

        <div class="service-card">
            <span class="service-icon">🎉</span>
            <div>
                <h3>Party</h3>
                <p>Temani momen spesialmu.</p>
            </div>
        </div>

    </section>


    <!-- DAFTAR MENU -->

    <section class="menu-section" id="menu">

        <div class="section-heading">
            <h2>Menu Favorit Pizza Moza 🍕</h2>
            <p>Pilih menu kesukaanmu dan nikmati kelezatannya.</p>
        </div>

        @php
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

        <!-- SEARCH -->

        <div class="search-box">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari menu favorit kamu..."
                onkeyup="searchProducts()"
            >
        </div>

        <!-- FILTER -->

        <div class="filter-buttons">

            <button type="button" class="category-btn active"
                onclick="filterCategory('all', this)">
                Semua
            </button>

            <button type="button" class="category-btn"
                onclick="filterCategory('Pizza', this)">
                Pizza
            </button>

            <button type="button" class="category-btn"
                onclick="filterCategory('Cemilan', this)">
                Cemilan
            </button>

            <button type="button" class="category-btn"
                onclick="filterCategory('Minuman', this)">
                Minuman
            </button>

        </div>


        <!-- PRODUCT -->

        <div class="product-container" id="productContainer">

            @foreach ($products as $product)

                @php
                    if (!empty($product->image)) {

                        if (\Illuminate\Support\Str::startsWith(
                            $product->image,
                            ['http://', 'https://']
                        )) {
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

                <div class="product-item"
                    data-name="{{ strtolower($product->nama) }}"
                    data-category="{{ strtolower($product->kategori) }}">

                    <div class="product-card">

                        <img
                            src="{{ $srcFoto }}"
                            alt="{{ $product->nama }}"
                            class="product-image"
                            onerror="this.onerror=null; this.src='{{ $fotoDefault }}';"
                        >

                        <div class="product-info">

                            <small class="product-category">
                                {{ $product->kategori }}
                            </small>

                            <h3 class="product-name">
                                {{ $product->nama }}
                            </h3>

                            <p class="product-description">
                                {{ $product->deskripsi ?? 'Produk Pizza Moza' }}
                            </p>

                            @if (!empty($product->portion))
                                <p class="portion">
                                    Porsi: {{ $product->portion }}
                                </p>
                            @endif

                            <div class="price">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <a
                                href="{{ route('checkout.index', ['product' => $product->id]) }}"
                                class="product-btn"
                            >
                                Pesan Sekarang →
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <!-- MENU TIDAK DITEMUKAN -->

        <div id="emptyMessage">
            <h3>Menu tidak ditemukan</h3>
            <p>Coba kata pencarian atau kategori lainnya.</p>
        </div>

    </section>


    <!-- FOOTER -->

    <footer id="tentang">

        <strong>🍕 PIZZA MOZA</strong>

        <p>
            Rasa Juara, Harga Bersahabat!
        </p>

        <p>
            © {{ date('Y') }} Pizza Moza. All Rights Reserved.
        </p>

    </footer>


    <!-- JAVASCRIPT SEARCH DAN FILTER -->

    <script>

        function filterCategory(category, button) {

            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            document.getElementById('searchInput').value = '';

            const kategori = category.toLowerCase();

            let visibleCount = 0;

            document.querySelectorAll('.product-item').forEach(product => {

                const productCategory =
                    product.getAttribute('data-category');

                const show =
                    kategori === 'all' || productCategory === kategori;

                product.style.display = show ? '' : 'none';

                if (show) visibleCount++;

            });

            document.getElementById('emptyMessage').style.display =
                visibleCount === 0 ? 'block' : 'none';
        }


        function searchProducts() {

            const input = document
                .getElementById('searchInput')
                .value.toLowerCase().trim();

            let visibleCount = 0;

            document.querySelectorAll('.product-item').forEach(product => {

                const name = product.getAttribute('data-name');

                const category = product.getAttribute('data-category');

                const show =
                    name.includes(input) || category.includes(input);

                product.style.display = show ? '' : 'none';

                if (show) visibleCount++;

            });

            document.getElementById('emptyMessage').style.display =
                visibleCount === 0 ? 'block' : 'none';
        }

    </script>

</body>
</html>
