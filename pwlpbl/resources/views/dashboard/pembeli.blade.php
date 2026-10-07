<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pembeli - Pizza Moza</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #1c1412;
            color: #ffffff;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #191210;
            border-right: 1px solid #342724;
            padding: 20px 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px 22px;
            border-bottom: 1px solid #342724;
        }

        .brand-icon {
            font-size: 32px;
        }

        .brand h2 {
            font-size: 17px;
            letter-spacing: 1px;
            margin-bottom: 7px;
        }

        .brand span {
            color: #92766a;
            font-size: 11px;
            letter-spacing: 3px;
        }

        .menu {
            margin-top: 20px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: #c9aaa0;
            padding: 14px 18px;
            margin-bottom: 6px;
            border-radius: 12px;
            font-size: 15px;
        }

        .menu a:hover,
        .menu a.active {
            background: #403027;
            color: #ffffff;
        }

        .menu-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .logout {
            position: absolute;
            bottom: 16px;
            left: 16px;
            right: 16px;
        }

        .logout button {
            width: 100%;
            padding: 11px;
            background: transparent;
            border: 1px solid #dc3545;
            border-radius: 6px;
            color: #ff3347;
            font-size: 14px;
            cursor: pointer;
        }

        .logout button:hover {
            background: #dc3545;
            color: white;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 84px;
            border-bottom: 1px solid #342724;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 28px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-text {
            text-align: right;
        }

        .user-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .user-email {
            color: #92766a;
            font-size: 12px;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #eee3d9;
            color: #352923;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 17px;
        }

        .date-box {
            border-left: 1px solid #342724;
            padding-left: 18px;
            margin-left: 2px;
            text-align: right;
        }

        .time {
            font-size: 17px;
            margin-bottom: 5px;
        }

        .date {
            color: #92766a;
            font-size: 12px;
        }

        .content {
            padding: 35px;
        }

        .welcome {
            margin-bottom: 28px;
        }

        .welcome h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #a98e82;
            font-size: 14px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            max-width: 1000px;
        }

        .card {
            background: #241a17;
            border: 1px solid #3a2b26;
            border-radius: 12px;
            padding: 22px;
        }

        .card-icon {
            font-size: 27px;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 17px;
            margin-bottom: 8px;
        }

        .card p {
            color: #a98e82;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 17px;
        }

        .card a {
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
        }

        .card a:hover {
            color: #d7b7a8;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="brand">
            <div class="brand-icon">🍕</div>

            <div>
                <h2>PIZZA MOZA</h2>
                <span>PEMBELI PANEL</span>
            </div>
        </div>

        <nav class="menu">

            <a href="{{ route('dashboard.pembeli') }}" class="active">
                <span class="menu-icon">🏠</span>
                <span>Beranda</span>
            </a>

            <a href="{{ route('pembeli.products') }}">
                <span class="menu-icon">🍕</span>
                <span>Menu Produk</span>
            </a>

            <a href="{{ route('pembeli.kategoris') }}">
                <span class="menu-icon">📁</span>
                <span>Kategori</span>
            </a>

            <a href="{{ route('pesanans.index') }}">
                <span class="menu-icon">📦</span>
                <span>Pesanan Saya</span>
            </a>

            <a href="{{ route('checkout.index') }}">
                <span class="menu-icon">🛒</span>
                <span>Checkout</span>
            </a>

            <a href="{{ route('profil.show') }}">
                <span class="menu-icon">👤</span>
                <span>Profil</span>
            </a>

        </nav>

        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit">
                    ⏻ Logout
                </button>
            </form>

        </div>

    </aside>


    {{-- MAIN --}}
    <main class="main">

        {{-- TOPBAR --}}
        <header class="topbar">

            <div class="user-info">

                <div class="user-text">

                    <div class="user-name">
                        {{ session('nama') ?? 'Pembeli' }}
                    </div>

                    <div class="user-email">
                        {{ session('email') ?? '' }}
                    </div>

                </div>

                <div class="avatar">
                    {{ strtoupper(substr(session('nama') ?? 'P', 0, 1)) }}
                </div>

                <div class="date-box">

                    <div class="time" id="clock">
                        00:00
                    </div>

                    <div class="date" id="date">
                        -
                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="content">

            <div class="welcome">

                <h1>
                    Selamat Datang 👋
                </h1>

                <p>
                    Selamat datang di Dashboard Pembeli Pizza Moza.
                </p>

            </div>


            <div class="cards">

                <div class="card">

                    <div class="card-icon">
                        🍕
                    </div>

                    <h3>
                        Menu Produk
                    </h3>

                    <p>
                        Lihat berbagai produk pizza yang tersedia di Pizza Moza.
                    </p>

                    <a href="{{ route('pembeli.products') }}">
                        Lihat Produk →
                    </a>

                </div>


                <div class="card">

                    <div class="card-icon">
                        🛒
                    </div>

                    <h3>
                        Buat Pesanan
                    </h3>

                    <p>
                        Pilih produk dan buat pesanan sesuai kebutuhan kamu.
                    </p>

                    <a href="{{ route('checkout.index') }}">
                        Mulai Pesan →
                    </a>

                </div>


                <div class="card">

                    <div class="card-icon">
                        📦
                    </div>

                    <h3>
                        Pesanan Saya
                    </h3>

                    <p>
                        Lihat pesanan dan status pembayaran yang sudah dibuat.
                    </p>

                    <a href="{{ route('pesanans.index') }}">
                        Lihat Pesanan →
                    </a>

                </div>

            </div>

        </section>

    </main>


    <script>

        function updateDateTime() {

            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            document.getElementById('clock').textContent =
                hours + ':' + minutes;


            const days = [
                'Minggu',
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ];

            const months = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];

            const dateText =
                days[now.getDay()] + ', ' +
                now.getDate() + ' ' +
                months[now.getMonth()] + ' ' +
                now.getFullYear();

            document.getElementById('date').textContent = dateText;
        }

        updateDateTime();

        setInterval(updateDateTime, 1000);

    </script>

</body>

</html>
