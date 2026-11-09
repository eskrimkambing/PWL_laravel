
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Pizza Moza</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fffaf4;
            color: #222;
        }

        /* NAVBAR */

        .navbar {
            height: 85px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            border-bottom: 1px solid #eeeeee;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #bd001c;
            font-size: 25px;
            font-weight: bold;
        }

        .logo-icon {
            font-size: 36px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #222;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
        }

        .nav-menu a:hover {
            color: #d00020;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-right a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-order {
            background: #c90024;
            color: white !important;
            padding: 14px 25px;
            border-radius: 8px;
        }

        .btn-order:hover {
            background: #a9001c;
        }

        /* HERO BANNER */

        .hero {
            min-height: 520px;
            background:
                linear-gradient(90deg,
                    rgba(190, 0, 20, 0.98) 0%,
                    rgba(190, 0, 20, 0.88) 42%,
                    rgba(190, 0, 20, 0.1) 100%),
                url('/images/pizza.jpg');

            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 55px 7%;
            position: relative;
        }

        .hero-content {
            max-width: 570px;
            color: white;
        }

        .hero-label {
            display: inline-block;
            background: #ffcf45;
            color: #9e0016;
            font-size: 15px;
            font-weight: bold;
            padding: 9px 17px;
            border-radius: 30px;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: 65px;
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .hero h2 {
            font-size: 27px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 17px;
            line-height: 1.7;
            color: #ffe6e6;
            margin-bottom: 28px;
        }

        .hero-button {
            display: inline-block;
            padding: 15px 30px;
            background: #ffca40;
            color: #920017;
            text-decoration: none;
            font-weight: bold;
            border-radius: 7px;
            transition: 0.3s;
        }

        .hero-button:hover {
            background: white;
            transform: translateY(-3px);
        }

        /* LOGIN SECTION */

        .login-section {
            padding: 65px 20px;
            display: flex;
            justify-content: center;
            background: #fffaf4;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: white;
            padding: 38px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.10);
            border-top: 5px solid #c90024;
        }

        .login-card h2 {
            text-align: center;
            color: #a9001c;
            font-size: 29px;
            margin-bottom: 10px;
        }

        .login-description {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
            margin-bottom: 20px;
            outline: none;
            background: #fff;
        }

        input:focus {
            border-color: #c90024;
            box-shadow: 0 0 0 3px rgba(201,0,36,0.08);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 12px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 19px;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background: #c90024;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-button:hover {
            background: #a9001c;
        }

        .bawah {
            text-align: center;
            margin-top: 23px;
            font-size: 14px;
            color: #666;
        }

        .bawah a {
            color: #c90024;
            font-weight: bold;
            text-decoration: none;
        }

        .bawah a:hover {
            text-decoration: underline;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        /* LAYANAN */

        .services {
            padding: 0 5% 55px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .service-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.07);
            border: 1px solid #eee;
        }

        .service-icon {
            font-size: 38px;
        }

        .service-card h3 {
            font-size: 19px;
            color: #222;
        }

        .service-card p {
            font-size: 13px;
            color: #777;
            margin-top: 5px;
        }

        /* FOOTER */

        footer {
            background: #a9001c;
            color: white;
            text-align: center;
            padding: 25px;
            font-size: 13px;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .navbar {
                padding: 0 3%;
            }

            .nav-menu {
                gap: 15px;
            }

            .hero h1 {
                font-size: 48px;
            }
        }

        @media (max-width: 650px) {
            .navbar {
                height: auto;
                padding: 18px;
                flex-wrap: wrap;
                gap: 15px;
            }

            .logo {
                font-size: 21px;
            }

            .nav-menu {
                width: 100%;
                justify-content: center;
                gap: 18px;
                order: 3;
            }

            .nav-menu a {
                font-size: 12px;
            }

            .nav-right {
                gap: 10px;
            }

            .btn-order {
                padding: 10px 13px;
                font-size: 12px !important;
            }

            .hero {
                min-height: 430px;
                padding: 45px 25px;
                background-position: center;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero h2 {
                font-size: 21px;
            }

            .hero p {
                font-size: 14px;
            }

            .services {
                grid-template-columns: 1fr;
                padding: 0 20px 40px;
            }

            .login-card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <header class="navbar">

        <div class="logo">
            <span class="logo-icon">🍕</span>
            <span>PIZZA MOZA</span>
        </div>

        <nav class="nav-menu">
            <a href="/">HOME</a>
            <a href="#menu">MENU</a>
            <a href="#tentang">TENTANG KAMI</a>
        </nav>

        <div class="nav-right">
            <a href="{{ route('login') }}">Login / Sign Up</a>
            <a href="#login" class="btn-order">Order Now</a>
        </div>

    </header>


    <!-- HERO BANNER -->

    <section class="hero" id="menu">

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
                Pesan sekarang dan nikmati favoritmu!
            </p>

            <a href="#login" class="hero-button">
                ORDER NOW →
            </a>

        </div>

    </section>


    <!-- LOGIN -->

    <section class="login-section" id="login">

        <div class="login-card">

            <h2>Welcome Back!</h2>

            <p class="login-description">
                Login untuk mulai menikmati Pizza Moza.
            </p>

            @if (session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">

                @csrf

                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email kamu"
                    required
                    autofocus
                >

                <label for="password">Password</label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword()"
                        aria-label="Tampilkan password"
                    >
                        <span id="eyeIcon">👁</span>
                    </button>

                </div>

                <button type="submit" class="login-button">
                    LOGIN SEKARANG
                </button>

            </form>

            <div class="bawah">
                Belum punya akun?

                <a href="{{ route('register') }}">
                    Register
                </a>
            </div>

        </div>

    </section>


    <!-- PILIHAN LAYANAN -->

    <section class="services" id="tentang">

        <div class="service-card">
            <span class="service-icon">🛵</span>

            <div>
                <h3>Delivery</h3>
                <p>Pizza favorit diantar ke tempatmu.</p>
            </div>
        </div>

        <div class="service-card">
            <span class="service-icon">🍕</span>

            <div>
                <h3>Takeaway</h3>
                <p>Pesan dan ambil pesananmu langsung.</p>
            </div>
        </div>

        <div class="service-card">
            <span class="service-icon">🎉</span>

            <div>
                <h3>Party</h3>
                <p>Temani momen spesial bersama Pizza Moza.</p>
            </div>
        </div>

    </section>


    <!-- FOOTER -->

    <footer>
        © {{ date('Y') }} Pizza Moza. All Rights Reserved.
    </footer>


    <!-- SHOW / HIDE PASSWORD -->

    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                password.type = 'password';
                eyeIcon.textContent = '👁';
            }

        }
    </script>

</body>
</html>

