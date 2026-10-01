<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Pembeli - Pizza Moza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;

            background-image: url('/images/pizza.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            min-height: 100vh;
            margin: 0;

            position: relative;
        }

        /* OVERLAY BACKGROUND */

        body::before {
            content: "";
            position: fixed;
            inset: 0;

            background: rgba(0, 0, 0, 0.35);

            z-index: -1;
        }

        /* NAVBAR */

        .navbar {
            background: rgba(58, 48, 45, 0.96);

            height: 70px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 8%;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.35);
        }

        .brand {
            color: #ffffff;

            font-size: 24px;
            font-weight: bold;

            text-decoration: none;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .email {
            color: #ffffff;

            font-size: 14px;
        }

        /* LOGOUT */

        .logout {
            background: #000000;

            color: #ffffff;

            text-decoration: none;

            padding: 10px 20px;

            border-radius: 20px;

            font-size: 14px;

            display: inline-block;
        }

        .logout:hover {
            background: #000000;
            color: #ffffff;
        }

        /* CONTAINER */

        .container {
            width: 85%;
            max-width: 1150px;

            margin: 50px auto;
        }

        /* JUDUL */

        h1 {
            margin: 0 0 10px;

            color: #ffffff;

            font-size: 34px;
        }

        .welcome {
            color: #ffffff;

            font-size: 16px;

            margin-bottom: 28px;
        }

        /* CARD */

        .cards {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 20px;
        }

        .card {
            background: rgba(58, 48, 45, 0.94);

            padding: 28px;

            border-radius: 15px;

            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);

            color: #ffffff;
        }

        .card h2 {
            margin: 0 0 15px;

            font-size: 21px;

            color: #ffffff;
        }

        .card p {
            margin: 0 0 22px;

            color: #eeeeee;

            font-size: 15px;

            line-height: 1.5;
        }

        /* TOMBOL */

        .btn {
            display: inline-block;

            padding: 11px 20px;

            background: #000000;

            color: #ffffff;

            text-decoration: none;

            border-radius: 7px;

            font-size: 14px;
        }

        .btn:hover {
            background: #000000;

            color: #ffffff;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            .navbar {
                padding: 0 5%;
            }

            .navbar-right {
                gap: 10px;
            }

            .email {
                display: none;
            }

            .container {
                width: 90%;

                margin: 35px auto;
            }

            h1 {
                font-size: 28px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar">

        <a href="{{ route('dashboard.pembeli') }}" class="brand">
            Pizza Moza
        </a>

        <div class="navbar-right">

            <span class="email">
                {{ session('email') }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="logout"
                    style="border: none; cursor: pointer;"
                >
                    Logout
                </button>
            </form>

        </div>

    </nav>


    <!-- CONTENT -->

    <main class="container">

        <h1>
            Dashboard Pembeli
        </h1>

        <p class="welcome">
            Selamat datang di Pizza Moza. Silakan pilih menu yang ingin kamu lihat.
        </p>


        <!-- CARDS -->

        <div class="cards">

            <!-- PRODUK -->

            <div class="card">

                <h2>
                    🍕 Lihat Produk
                </h2>

                <p>
                    Lihat berbagai menu Pizza Moza yang tersedia.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="btn"
                >
                    Lihat Produk
                </a>

            </div>


            <!-- KATEGORI -->

            <div class="card">

                <h2>
                    📁 Kategori Menu
                </h2>

                <p>
                    Lihat kategori menu yang tersedia.
                </p>

                <a
                    href="{{ route('kategoris.index') }}"
                    class="btn"
                >
                    Lihat Kategori
                </a>

            </div>

        </div>

    </main>

</body>
</html>