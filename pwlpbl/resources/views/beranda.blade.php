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

        /* BANNER SLIDER */

        .slider {
            position: relative;
            overflow: hidden;
            background: var(--brown);
        }

        .slides {
            display: flex;
            transition: transform .6s ease;
        }

        .slide {
            min-width: 100%;
            min-height: 380px;
            padding: 50px 8%;
            display: flex;
            align-items: center;
            color: white;
            background-size: cover;
            background-position: center;
        }

        .slide-1 {
            background-image:
                linear-gradient(90deg, rgba(123, 22, 13, 0.88), rgba(123, 22, 13, 0.50), rgba(123, 22, 13, 0.05)),
                url('{{ asset('images/pizza.jpg') }}');
        }

        .slide-2 {
            background-image:
                linear-gradient(90deg, rgba(232, 121, 0, 0.92), rgba(232, 121, 0, 0.55), rgba(232, 121, 0, 0.08)),
                url('{{ asset('images/pizza.jpg') }}');
            background-position: left center;
        }

        .slide-3 {
            background-image:
                linear-gradient(90deg, rgba(40, 10, 6, 0.92), rgba(40, 10, 6, 0.60), rgba(40, 10, 6, 0.10)),
                url('{{ asset('images/pizza.jpg') }}');
            background-position: right center;
        }

        .slide-content {
            max-width: 560px;
        }

        .hero-label {
            display: inline-block;
            background: var(--yellow);
            color: var(--brown);
            padding: 9px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .slide h1 {
            font-size: clamp(34px, 5vw, 58px);
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 12px;
        }

        .slide p {
            line-height: 1.7;
            font-size: 16px;
            margin-bottom: 24px;
            color: #fff4dc;
        }

        .primary-btn {
            display: inline-block;
            background: white;
            color: var(--brown);
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 9px;
            font-weight: bold;
            transition: .2s;
        }

        .slide-1 .primary-btn {
            background: var(--orange);
            color: white;
        }

        .primary-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, .25);
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, .9);
            color: var(--brown);
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            z-index: 5;
        }

        .slider-arrow:hover {
            background: white;
        }

        .slider-arrow.prev {
            left: 16px;
        }

        .slider-arrow.next {
            right: 16px;
        }

        .slider-dots {
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 5;
        }

        .slider-dots button {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, .5);
            cursor: pointer;
            padding: 0;
        }

        .slider-dots button.active {
            width: 26px;
            border-radius: 6px;
            background: white;
        }

        .slide .primary-btn:hover {
            background: var(--yellow);
            color: var(--brown);
        }

        .slide-1 .primary-btn:hover {
            background: #CC6800;
            color: white;
        }

        /* MENU: TAB KATEGORI + DAFTAR PRODUK */

        #menu {
            scroll-margin-top: 85px;
        }

        .cat-bar {
            position: sticky;
            top: 85px;
            z-index: 90;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 5%;
            background: var(--cream);
            border-bottom: 1px solid var(--border);
        }

        .cat-tabs {
            display: flex;
            gap: 8px;
            flex: 1;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .cat-tabs::-webkit-scrollbar {
            display: none;
        }

        .cat-tab {
            white-space: nowrap;
            text-decoration: none;
            border: 1px solid var(--border);
            background: white;
            color: var(--brown);
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: .2s;
        }

        .cat-tab:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        .cat-tab.active {
            background: var(--orange);
            border-color: var(--orange);
            color: white;
        }

        .search-box {
            flex-shrink: 0;
            width: 270px;
        }

        .search-box input {
            width: 100%;
            padding: 11px 16px;
            border: 1px solid var(--border);
            border-radius: 30px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .search-box input:focus {
            border-color: var(--orange);
        }

        .menu-wrap {
            padding: 0 5% 60px;
        }

        .menu-category {
            padding-top: 36px;
            scroll-margin-top: 150px;
        }

        .menu-category h2 {
            font-size: 26px;
            color: var(--brown);
            margin-bottom: 18px;
        }

        .product-container {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 22px;
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
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 9px 22px rgba(80, 40, 10, .14);
        }

        .product-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: var(--beige);
        }

        .product-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-name {
            font-size: 18px;
            margin-bottom: 6px;
            color: var(--brown);
        }

        .product-description {
            color: #966b53;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 39px;
        }

        .portion {
            font-size: 12px;
            color: #966b53;
            margin-bottom: 8px;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: var(--brown);
            margin-top: auto;
            margin-bottom: 12px;
        }

        .add-btn {
            display: block;
            text-align: center;
            padding: 10px;
            border: 2px solid var(--orange);
            border-radius: 9px;
            color: var(--orange);
            font-weight: bold;
            font-size: 14px;
            background: white;
            transition: .2s;
        }

        .product-card:hover .add-btn {
            background: var(--orange);
            color: white;
        }

        #emptyMessage {
            display: none;
            text-align: center;
            padding: 60px 15px;
            color: #966b53;
        }

        button.product-btn {
            width: 100%;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        /* MODAL PILIH UKURAN */

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            position: relative;
            background: white;
            width: 100%;
            max-width: 900px;
            max-height: 92vh;
            overflow-y: auto;
            border-radius: 18px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 30px;
            padding: 30px;
        }

        .modal-close {
            position: absolute;
            top: 14px;
            right: 18px;
            border: none;
            background: none;
            font-size: 30px;
            line-height: 1;
            cursor: pointer;
            color: var(--brown);
        }

        .modal-left img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 12px;
            background: var(--beige);
            margin-bottom: 18px;
        }

        .modal-left h3 {
            font-size: 24px;
            color: var(--brown);
            margin-bottom: 8px;
        }

        .modal-left .modal-price {
            font-size: 20px;
            font-weight: bold;
            color: var(--orange);
            margin-bottom: 12px;
        }

        .modal-left p {
            font-size: 13px;
            line-height: 1.7;
            color: #966b53;
        }

        .modal-right {
            display: flex;
            flex-direction: column;
        }

        .modal-right h4 {
            font-size: 22px;
            color: var(--brown);
            margin-bottom: 20px;
            padding-right: 30px;
        }

        .modal-label {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .size-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 22px;
        }

        .size-option {
            border: 2px solid var(--border);
            background: #FFFAF0;
            border-radius: 12px;
            padding: 14px 8px;
            text-align: center;
            cursor: pointer;
            font-family: inherit;
            color: var(--brown);
        }

        .size-option strong {
            display: block;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .size-option small {
            display: block;
            font-size: 12px;
            color: #966b53;
        }

        .size-option:hover {
            border-color: var(--orange);
        }

        .size-option.selected {
            border-color: var(--orange);
            background: #FFF0D6;
        }

        .modal-right textarea {
            width: 100%;
            height: 90px;
            resize: none;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 12px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            margin-bottom: 20px;
        }

        .modal-right textarea:focus {
            border-color: var(--orange);
        }

        .modal-footer {
            margin-top: auto;
        }

        .modal-total-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .modal-total {
            font-size: 22px;
            font-weight: bold;
            color: var(--brown);
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .qty-control button {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid var(--orange);
            background: white;
            color: var(--orange);
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .qty-control span {
            min-width: 20px;
            text-align: center;
            font-weight: bold;
        }

        .modal-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: var(--orange);
            color: white;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }

        .modal-submit:hover:not(:disabled) {
            background: #CC6800;
        }

        .modal-submit:disabled {
            background: #D6D6D6;
            cursor: not-allowed;
        }

        /* KERANJANG */

        .cart-fab {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 150;
            border: none;
            background: var(--orange);
            color: white;
            padding: 15px 22px;
            border-radius: 40px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(80, 40, 10, .35);
        }

        .cart-fab:hover {
            background: #CC6800;
        }

        .cart-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            z-index: 210;
            justify-content: flex-end;
        }

        .cart-overlay.open {
            display: flex;
        }

        .cart-drawer {
            background: white;
            width: 100%;
            max-width: 430px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .cart-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
        }

        .cart-head h3 {
            color: var(--brown);
            font-size: 21px;
        }

        .cart-head button {
            border: none;
            background: none;
            font-size: 30px;
            line-height: 1;
            cursor: pointer;
            color: var(--brown);
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 18px 24px;
        }

        .cart-empty {
            text-align: center;
            color: #966b53;
            padding: 60px 10px;
            font-size: 14px;
        }

        .cart-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .cart-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
            background: var(--beige);
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-info strong {
            display: block;
            color: var(--brown);
            font-size: 15px;
            margin-bottom: 3px;
        }

        .cart-item-info small {
            display: block;
            color: #966b53;
            font-size: 12px;
            margin-bottom: 2px;
            word-break: break-word;
        }

        .cart-item-price {
            color: var(--orange);
            font-weight: bold;
            font-size: 14px;
            margin: 4px 0 8px;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-remove {
            border: none;
            background: none;
            color: #B3261E;
            font-size: 12px;
            cursor: pointer;
        }

        .cart-foot {
            padding: 18px 24px 24px;
            border-top: 1px solid var(--border);
        }

        .cart-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            font-size: 16px;
        }

        .cart-total-row strong {
            font-size: 22px;
        }

        .cart-add-more {
            width: 100%;
            padding: 13px;
            margin-bottom: 10px;
            border: 2px solid var(--orange);
            background: white;
            color: var(--orange);
            border-radius: 10px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        .toast {
            position: fixed;
            left: 50%;
            bottom: 90px;
            transform: translateX(-50%) translateY(20px);
            background: var(--brown);
            color: white;
            padding: 12px 22px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: bold;
            opacity: 0;
            pointer-events: none;
            transition: .25s;
            z-index: 300;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        @media(max-width: 700px) {
            .modal-box {
                grid-template-columns: 1fr;
                padding: 22px;
                gap: 20px;
            }

            .modal-left img {
                height: 180px;
            }
        }

        /* FOOTER */

        footer {
            background: var(--brown);
            color: white;
            padding: 25px 7% 15px;
            line-height: 1.6;
        }

        .footer-container {
            max-width: 1100px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
        }

        .footer-brand h3 {
            color: var(--yellow);
            font-size: 22px;
            margin-bottom: 7px;
        }

        .footer-brand p {
            font-size: 14px;
        }

        .footer-contact h3 {
            color: var(--yellow);
            font-size: 17px;
            margin-bottom: 12px;
        }

        .contact-links {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: .2s;
        }

        .contact-item svg {
            width: 21px;
            height: 21px;
            flex-shrink: 0;
        }

        .contact-item:hover {
            color: var(--yellow);
            transform: translateY(-2px);
        }

        .footer-bottom {
            max-width: 1100px;
            margin: 20px auto 0;
            padding-top: 13px;
            border-top: 1px solid rgba(255, 255, 255, .2);
            text-align: center;
            font-size: 13px;
        }

        /* RESPONSIVE */

        @media(max-width: 1100px) {
            .product-container {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

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
                position: static;
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

            .slide {
                min-height: 330px;
                padding: 40px 25px 55px;
            }

            .slide p {
                font-size: 14px;
            }

            .slider-arrow {
                display: none;
            }

            .cat-bar {
                top: 0;
                flex-wrap: wrap;
                padding: 10px 20px;
                gap: 10px;
            }

            .cat-tabs {
                width: 100%;
            }

            .search-box {
                width: 100%;
            }

            .menu-wrap {
                padding: 0 20px 45px;
            }

            .menu-category {
                scroll-margin-top: 130px;
            }

            .menu-category h2 {
                font-size: 22px;
            }

            .product-container {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .product-image {
                height: 130px;
            }

            .product-info {
                padding: 12px;
            }

            .product-name {
                font-size: 15px;
            }

            .footer-container {
                flex-direction: column;
                text-align: center;
                gap: 22px;
            }

            .contact-links {
                justify-content: center;
                gap: 15px;
            }

            footer {
                padding: 25px 15px 15px;
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


    <!-- BANNER SLIDER -->

    <section class="slider">

        <div class="slides" id="slides">

            <div class="slide slide-1">
                <div class="slide-content">
                    <span class="hero-label">🍕 SPECIAL MENU PIZZA MOZA</span>
                    <h1>PIZZA MOZA</h1>
                    <p>
                        Rasa juara, harga bersahabat! Nikmati pizza dengan topping pilihan
                        dan keju melimpah yang bikin ketagihan.
                    </p>
                    <a href="#menu" class="primary-btn">LIHAT MENU →</a>
                </div>
            </div>

            <div class="slide slide-2">
                <div class="slide-content">
                    <span class="hero-label">🧀 CEMILAN FAVORIT</span>
                    <h1>TAPE BAKAR &amp; SINGKONG KEJU</h1>
                    <p>
                        Teman santai yang pas untuk dinikmati bareng keluarga dan sahabat.
                    </p>
                    <a href="#kat-cemilan" class="primary-btn" onclick="goToCategory(event, 'kat-cemilan')">PESAN
                        CEMILAN →</a>
                </div>
            </div>

            <div class="slide slide-3">
                <div class="slide-content">
                    <span class="hero-label">🛵 DELIVERY &amp; TAKEAWAY</span>
                    <h1>PESAN MUDAH, LANGSUNG SAMPAI</h1>
                    <p>
                        Pilih menu, atur ukuran dan catatan, lalu checkout.
                        Diantar ke tempatmu atau ambil langsung di outlet.
                    </p>
                    <a href="#menu" class="primary-btn">PESAN SEKARANG →</a>
                </div>
            </div>

        </div>

        <button type="button" class="slider-arrow prev" onclick="slideMove(-1)" aria-label="Sebelumnya">‹</button>
        <button type="button" class="slider-arrow next" onclick="slideMove(1)" aria-label="Berikutnya">›</button>

        <div class="slider-dots" id="sliderDots"></div>

    </section>


    <!-- DAFTAR MENU -->

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

        // Kelompokkan produk per kategori (urutan: Pizza, Cemilan, Minuman, lainnya)
        $urutanKategori = ['pizza' => 1, 'cemilan' => 2, 'minuman' => 3];

        $grupProduk = $products->groupBy('kategori')->sortBy(function ($items, $kategori) use ($urutanKategori) {
            return $urutanKategori[strtolower($kategori)] ?? 99;
        });
    @endphp

    <section id="menu">

        <!-- TAB KATEGORI + PENCARIAN (menempel di atas saat di-scroll) -->

        <div class="cat-bar">

            <div class="cat-tabs" id="catTabs">
                @foreach ($grupProduk as $kategori => $items)
                    <a href="#kat-{{ \Illuminate\Support\Str::slug($kategori) }}" class="cat-tab"
                        data-target="kat-{{ \Illuminate\Support\Str::slug($kategori) }}">
                        {{ $kategori }}
                    </a>
                @endforeach
            </div>

            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari menu favorit kamu..."
                    onkeyup="searchProducts()">
            </div>

        </div>


        <div class="menu-wrap">

            @foreach ($grupProduk as $kategori => $items)
                <div class="menu-category" id="kat-{{ \Illuminate\Support\Str::slug($kategori) }}">

                    <h2>{{ $kategori }}</h2>

                    <div class="product-container">

                        @foreach ($items as $product)
                            @php
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

                            <div class="product-item" data-name="{{ strtolower($product->nama) }}">

                                <div class="product-card" role="button" tabindex="0" data-id="{{ $product->id }}"
                                    data-nama="{{ $product->nama }}" data-kategori="{{ $product->kategori }}"
                                    data-deskripsi="{{ $product->deskripsi ?? 'Produk Pizza Moza' }}"
                                    data-price="{{ (int) $product->price }}" data-image="{{ $srcFoto }}"
                                    onclick="openOrderModal(this)"
                                    onkeydown="if (event.key === 'Enter') openOrderModal(this)">

                                    <img src="{{ $srcFoto }}" alt="{{ $product->nama }}" class="product-image"
                                        onerror="this.onerror=null; this.src='{{ $fotoDefault }}';">

                                    <div class="product-info">

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

                                        <span class="add-btn">+ Tambah</span>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>
            @endforeach


            <!-- MENU TIDAK DITEMUKAN -->

            <div id="emptyMessage">
                <h3>Menu tidak ditemukan</h3>
                <p>Coba kata pencarian lainnya.</p>
            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer id="tentang">

        <div class="footer-container">

            <!-- BRAND PIZZA MOZA -->

            <div class="footer-brand">

                <h3>🍕 PIZZA MOZA</h3>

                <p>
                    Rasa Juara, Harga Bersahabat!
                </p>

            </div>

            <!-- KONTAK -->

            <div class="footer-contact">

                <h3>Hubungi Kami</h3>

                <div class="contact-links">

                    <!-- INSTAGRAM -->

                    <a href="https://www.instagram.com/pizzamozza2025/" target="_blank" rel="noopener noreferrer"
                        class="contact-item">

                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm0 2h10c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3zm10.5 1.5a1 1 0 100 2 1 1 0 000-2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z" />

                        </svg>

                        <span>@pizzamozza2025</span>

                    </a>

                    <!-- WHATSAPP -->

                    <a href="https://wa.me/6281520980818" target="_blank" rel="noopener noreferrer"
                        class="contact-item">

                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M20.52 3.48A11.8 11.8 0 0012.04 0C5.52 0 .22 5.3.22 11.82c0 2.08.54 4.11 1.57 5.9L.12 24l6.43-1.68a11.8 11.8 0 005.48 1.39h.01c6.52 0 11.82-5.3 11.82-11.82 0-3.16-1.23-6.13-3.34-8.41zM12.04 21.7a9.84 9.84 0 01-5.02-1.38l-.36-.21-3.82 1 1.02-3.72-.23-.38a9.84 9.84 0 01-1.51-5.19c0-5.46 4.45-9.91 9.92-9.91 2.65 0 5.14 1.03 7.01 2.9a9.85 9.85 0 012.9 7.01c0 5.47-4.45 9.92-9.91 9.92zm5.44-7.42c-.3-.15-1.77-.87-2.05-.97-.28-.1-.48-.15-.68.15-.2.3-.78.97-.96 1.17-.18.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.68-1.63-.93-2.23-.24-.58-.49-.5-.68-.51h-.58c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.09 4.49.71.31 1.26.5 1.69.64.71.22 1.36.19 1.87.11.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.18-1.42-.08-.13-.28-.2-.58-.35z" />

                        </svg>

                        <span>081520980818</span>

                    </a>

                </div>

            </div>

        </div>

        <!-- COPYRIGHT -->

        <div class="footer-bottom">
            © {{ date('Y') }} Pizza Moza. All Rights Reserved.
        </div>

    </footer>


    <!-- MODAL PILIH UKURAN -->

    <div class="modal-overlay" id="orderModal" onclick="if (event.target === this) closeOrderModal()">

        <div class="modal-box">

            <button type="button" class="modal-close" onclick="closeOrderModal()" aria-label="Tutup">×</button>

            <div class="modal-left">
                <img id="modalImage" src="" alt="">
                <h3 id="modalName"></h3>
                <div class="modal-price" id="modalPrice"></div>
                <p id="modalDesc"></p>
            </div>

            <div class="modal-right">

                <h4>Atur pesananmu</h4>

                <div id="sizeSection">
                    <p class="modal-label">Pilih ukuran</p>
                    <div class="size-options" id="sizeOptions"></div>
                </div>

                <p class="modal-label">Catatan</p>
                <textarea id="modalNotes" placeholder="Contoh: tanpa bawang, extra saus..."></textarea>

                <div class="modal-footer">

                    <div class="modal-total-row">
                        <div class="modal-total" id="modalTotal"></div>

                        <div class="qty-control">
                            <button type="button" onclick="changeQty(-1)">−</button>
                            <span id="modalQty">1</span>
                            <button type="button" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <button type="button" class="modal-submit" id="modalSubmit" onclick="addToCart()" disabled>
                        Tambah ke Keranjang
                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- KERANJANG -->

    <button type="button" class="cart-fab" id="cartFab" onclick="openCart()" style="display:none;">
        🛒 <span id="cartCount">0</span> item · <span id="cartFabTotal"></span>
    </button>

    <div class="cart-overlay" id="cartOverlay" onclick="if (event.target === this) closeCart()">

        <aside class="cart-drawer">

            <div class="cart-head">
                <h3>Keranjang Kamu 🛒</h3>
                <button type="button" onclick="closeCart()" aria-label="Tutup">×</button>
            </div>

            <div class="cart-items" id="cartItems"></div>

            <div class="cart-foot">

                <div class="cart-total-row">
                    <span>Total</span>
                    <strong id="cartTotal">Rp0</strong>
                </div>

                <button type="button" class="cart-add-more" onclick="addMoreMenu()">
                    + Tambah menu lain
                </button>

                <button type="button" class="modal-submit" id="cartCheckoutBtn" onclick="goCheckout()">
                    Checkout
                </button>

            </div>

        </aside>

    </div>

    <div class="toast" id="toast"></div>


    <!-- JAVASCRIPT SEARCH DAN FILTER -->

    <script>
        /* ===== MODAL PILIH UKURAN ===== */

        const checkoutUrl = "{{ route('checkout.index') }}";

        // Tambahan harga per ukuran (harga di database dianggap harga Medium).
        // Ubah angkanya sesuai kebutuhan.
        const sizes = [{
                key: 'Small',
                label: 'Small',
                add: -10000
            },
            {
                key: 'Medium',
                label: 'Medium',
                add: 0
            },
            {
                key: 'Large',
                label: 'Large',
                add: 15000
            },
        ];

        let order = null;

        function rupiah(n) {
            return 'Rp' + n.toLocaleString('id-ID');
        }

        function openOrderModal(btn) {
            const isPizza = btn.dataset.kategori.toLowerCase() === 'pizza';

            order = {
                id: btn.dataset.id,
                nama: btn.dataset.nama,
                image: btn.dataset.image,
                base: parseInt(btn.dataset.price),
                isPizza: isPizza,
                size: null,
                qty: 1,
            };

            document.getElementById('modalImage').src = btn.dataset.image;
            document.getElementById('modalName').textContent = btn.dataset.nama;
            document.getElementById('modalDesc').textContent = btn.dataset.deskripsi;
            document.getElementById('modalNotes').value = '';
            document.getElementById('modalQty').textContent = '1';

            const sizeSection = document.getElementById('sizeSection');
            const sizeBox = document.getElementById('sizeOptions');
            sizeBox.innerHTML = '';

            if (isPizza) {
                sizeSection.style.display = '';

                sizes.forEach(s => {
                    const el = document.createElement('button');
                    el.type = 'button';
                    el.className = 'size-option';
                    el.dataset.key = s.key;
                    el.innerHTML = '<strong>' + s.label + '</strong><small>' +
                        rupiah(order.base + s.add) + '</small>';
                    el.onclick = () => selectSize(s.key);
                    sizeBox.appendChild(el);
                });
            } else {
                sizeSection.style.display = 'none';
            }

            updateModal();

            document.getElementById('orderModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function selectSize(key) {
            order.size = key;

            document.querySelectorAll('.size-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.key === key);
            });

            updateModal();
        }

        function unitPrice() {
            if (!order.isPizza) return order.base;
            const s = sizes.find(x => x.key === order.size) || sizes.find(x => x.add === 0);
            return order.base + s.add;
        }

        function changeQty(delta) {
            order.qty = Math.max(1, order.qty + delta);
            document.getElementById('modalQty').textContent = order.qty;
            updateModal();
        }

        function updateModal() {
            document.getElementById('modalPrice').textContent = rupiah(unitPrice());
            document.getElementById('modalTotal').textContent = rupiah(unitPrice() * order.qty);

            // Pizza wajib pilih ukuran dulu
            document.getElementById('modalSubmit').disabled = order.isPizza && !order.size;
        }

        /* ===== KERANJANG ===== */

        const CART_KEY = 'moza_cart';

        function loadCart() {
            try {
                const data = JSON.parse(localStorage.getItem(CART_KEY));
                return Array.isArray(data) ? data : [];
            } catch (e) {
                return [];
            }
        }

        function saveCart() {
            try {
                localStorage.setItem(CART_KEY, JSON.stringify(cart));
            } catch (e) {}
        }

        let cart = loadCart();

        function sizeAdd(size) {
            const s = sizes.find(x => x.key === size);
            return s ? s.add : 0;
        }

        function lineUnit(item) {
            return item.base + sizeAdd(item.size);
        }

        function cartTotal() {
            return cart.reduce((sum, i) => sum + lineUnit(i) * i.qty, 0);
        }

        function showToast(text) {
            const t = document.getElementById('toast');
            t.textContent = text;
            t.classList.add('show');
            clearTimeout(showToast.timer);
            showToast.timer = setTimeout(() => t.classList.remove('show'), 2200);
        }

        function addToCart() {
            const notes = document.getElementById('modalNotes').value.trim();
            const size = order.isPizza ? order.size : null;

            const existing = cart.find(i =>
                i.id === order.id && i.size === size && i.notes === notes
            );

            if (existing) {
                existing.qty += order.qty;
            } else {
                cart.push({
                    id: order.id,
                    nama: order.nama,
                    image: order.image,
                    base: order.base,
                    size: size,
                    notes: notes,
                    qty: order.qty,
                });
            }

            saveCart();
            renderCart();
            closeOrderModal();
            showToast('✓ ' + order.nama + ' masuk keranjang');
        }

        function changeCartQty(index, delta) {
            cart[index].qty = Math.max(1, cart[index].qty + delta);
            saveCart();
            renderCart();
        }

        function removeCartItem(index) {
            cart.splice(index, 1);
            saveCart();
            renderCart();
        }

        function renderCart() {
            const count = cart.reduce((sum, i) => sum + i.qty, 0);
            const total = rupiah(cartTotal());

            const fab = document.getElementById('cartFab');
            fab.style.display = count > 0 ? '' : 'none';
            document.getElementById('cartCount').textContent = count;
            document.getElementById('cartFabTotal').textContent = total;
            document.getElementById('cartTotal').textContent = total;
            document.getElementById('cartCheckoutBtn').disabled = count === 0;

            const box = document.getElementById('cartItems');
            box.innerHTML = '';

            if (cart.length === 0) {
                const empty = document.createElement('div');
                empty.className = 'cart-empty';
                empty.textContent = 'Keranjang masih kosong. Yuk pilih menu favoritmu!';
                box.appendChild(empty);
                return;
            }

            cart.forEach((item, index) => {
                const row = document.createElement('div');
                row.className = 'cart-item';

                const img = document.createElement('img');
                img.src = item.image;
                img.alt = item.nama;

                const info = document.createElement('div');
                info.className = 'cart-item-info';

                const name = document.createElement('strong');
                name.textContent = item.nama;
                info.appendChild(name);

                if (item.size) {
                    const sz = document.createElement('small');
                    sz.textContent = 'Ukuran: ' + item.size;
                    info.appendChild(sz);
                }

                if (item.notes) {
                    const nt = document.createElement('small');
                    nt.textContent = 'Catatan: ' + item.notes;
                    info.appendChild(nt);
                }

                const price = document.createElement('div');
                price.className = 'cart-item-price';
                price.textContent = rupiah(lineUnit(item) * item.qty);
                info.appendChild(price);

                const actions = document.createElement('div');
                actions.className = 'cart-item-actions';

                const qty = document.createElement('div');
                qty.className = 'qty-control';

                const minus = document.createElement('button');
                minus.type = 'button';
                minus.textContent = '−';
                minus.onclick = () => changeCartQty(index, -1);

                const num = document.createElement('span');
                num.textContent = item.qty;

                const plus = document.createElement('button');
                plus.type = 'button';
                plus.textContent = '+';
                plus.onclick = () => changeCartQty(index, 1);

                qty.appendChild(minus);
                qty.appendChild(num);
                qty.appendChild(plus);

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'cart-remove';
                remove.textContent = 'Hapus';
                remove.onclick = () => removeCartItem(index);

                actions.appendChild(qty);
                actions.appendChild(remove);
                info.appendChild(actions);

                row.appendChild(img);
                row.appendChild(info);
                box.appendChild(row);
            });
        }

        function openCart() {
            document.getElementById('cartOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            document.getElementById('cartOverlay').classList.remove('open');
            document.body.style.overflow = '';
        }

        function addMoreMenu() {
            closeCart();
            document.getElementById('menu').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function goCheckout() {
            if (cart.length === 0) return;

            const payload = cart.map(i => ({
                id: i.id,
                size: i.size,
                qty: i.qty,
                notes: i.notes,
            }));

            window.location.href = checkoutUrl + '?cart=' +
                encodeURIComponent(JSON.stringify(payload));
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOrderModal();
                closeCart();
            }
        });

        renderCart();


        /* ===== SLIDER BANNER ===== */

        const slidesEl = document.getElementById('slides');
        const dotsEl = document.getElementById('sliderDots');
        const slideCount = slidesEl.children.length;
        let slideIndex = 0;
        let slideTimer = null;

        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', 'Slide ' + (i + 1));
            dot.onclick = () => {
                slideTo(i);
                startSlider();
            };
            dotsEl.appendChild(dot);
        }

        function slideTo(n) {
            slideIndex = (n + slideCount) % slideCount;
            slidesEl.style.transform = 'translateX(-' + (slideIndex * 100) + '%)';

            [...dotsEl.children].forEach((d, i) => {
                d.classList.toggle('active', i === slideIndex);
            });
        }

        function slideMove(delta) {
            slideTo(slideIndex + delta);
            startSlider();
        }

        function startSlider() {
            clearInterval(slideTimer);
            slideTimer = setInterval(() => slideTo(slideIndex + 1), 5000);
        }

        slideTo(0);
        startSlider();


        /* ===== TAB KATEGORI ===== */

        const catTabs = [...document.querySelectorAll('.cat-tab')];
        const catSections = [...document.querySelectorAll('.menu-category')];
        const catTabsBox = document.getElementById('catTabs');

        function goToCategory(event, id) {
            event.preventDefault();
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({
                behavior: 'smooth'
            });
        }

        catTabs.forEach(tab => {
            tab.addEventListener('click', e => goToCategory(e, tab.dataset.target));
        });

        // Tab ikut menyala sesuai bagian yang sedang dilihat
        function updateActiveTab() {
            let current = null;

            catSections.forEach(sec => {
                if (sec.style.display !== 'none' && sec.getBoundingClientRect().top <= 180) {
                    current = sec;
                }
            });

            if (!current) {
                current = catSections.find(sec => sec.style.display !== 'none') || null;
            }

            catTabs.forEach(tab => {
                const active = current && tab.dataset.target === current.id;
                tab.classList.toggle('active', !!active);

                if (active) {
                    catTabsBox.scrollTo({
                        left: tab.offsetLeft - 20,
                        behavior: 'smooth'
                    });
                }
            });
        }

        window.addEventListener('scroll', updateActiveTab, {
            passive: true
        });
        updateActiveTab();


        /* ===== PENCARIAN ===== */

        function searchProducts() {

            const input = document
                .getElementById('searchInput')
                .value.toLowerCase().trim();

            let visibleCount = 0;

            document.querySelectorAll('.product-item').forEach(product => {

                const show = product.getAttribute('data-name').includes(input);

                product.style.display = show ? '' : 'none';

                if (show) visibleCount++;

            });

            // Sembunyikan kategori yang semua menunya tidak cocok
            catSections.forEach(sec => {
                const any = [...sec.querySelectorAll('.product-item')]
                    .some(el => el.style.display !== 'none');
                sec.style.display = any ? '' : 'none';
            });

            catTabs.forEach(tab => {
                const sec = document.getElementById(tab.dataset.target);
                tab.style.display = sec && sec.style.display === 'none' ? 'none' : '';
            });

            document.getElementById('emptyMessage').style.display =
                visibleCount === 0 ? 'block' : 'none';

            updateActiveTab();
        }
    </script>

</body>

</html>
