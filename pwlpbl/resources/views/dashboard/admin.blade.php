<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - Pizza Moza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            color: #222;
        }

        .navbar {
            background: #212529;
            color: white;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar span {
            font-size: 14px;
        }

        .container {
            width: 84%;
            margin: 35px auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            margin: 0;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin: 0 0 12px;
            font-size: 16px;
            color: #555;
        }

        .card .number {
            font-size: 32px;
            font-weight: bold;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .menu-card h3 {
            margin-top: 0;
        }

        .menu-card p {
            color: #666;
        }

        .button {
            display: inline-block;
            padding: 10px 18px;
            background: #212529;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 8px;
        }

        .button:hover {
            background: #343a40;
        }

        .logout {
            background: #dc3545;
            border: none;
            color: white;
            padding: 9px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .cards,
            .menu {
                grid-template-columns: 1fr;
            }

            .container {
                width: 92%;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Pizza Moza</h2>

        <div>
            <span>
                {{ session('email') }}
            </span>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container">

        <div class="header">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang di halaman pengelolaan Pizza Moza.</p>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Total Produk</h3>
                <div class="number">
                    {{ $totalProduk }}
                </div>
            </div>

            <div class="card">
                <h3>Total Kategori</h3>
                <div class="number">
                    {{ $totalKategori }}
                </div>
            </div>

            <div class="card">
                <h3>Total Pembeli</h3>
                <div class="number">
                    {{ $totalPembeli }}
                </div>
            </div>

        </div>

        <div class="menu">

            <div class="menu-card">
                <h3>🍕 Kelola Produk</h3>

                <p>
                    Tambah, lihat, edit, dan hapus menu Pizza Moza.
                </p>

                <a href="{{ route('products.index') }}" class="button">
                    Kelola Produk
                </a>
            </div>

            <div class="menu-card">
                <h3>📂 Kelola Kategori</h3>

                <p>
                    Kelola kategori menu yang tersedia di Pizza Moza.
                </p>

                <a href="{{ route('kategoris.index') }}" class="button">
                    Kelola Kategori
                </a>
            </div>

        </div>

    </div>

</body>
</html>
