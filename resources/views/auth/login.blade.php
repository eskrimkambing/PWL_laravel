<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Masuk - Pizza Moza</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #F7D991;
            --cream-light: #FCF3DC;
            --cream-card: #FFFAEE;
            --orange: #DE7801;
            --red: #CA4238;
            --maroon: #6A0801;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: var(--cream-light);
            color: var(--maroon);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== NAVBAR ===== */
        .topbar {
            background: var(--orange);
            box-shadow: 0 2px 6px rgba(0, 0, 0, .25);
        }

        .topbar .inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 900;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: .5px;
            text-decoration: none;
        }

        .brand .logo {
            background: #fff;
            color: var(--orange);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .topbar .daftar {
            color: #fff;
            border: 2px solid #fff;
            border-radius: 50px;
            padding: 6px 18px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
        }

        .topbar .daftar:hover {
            background: #fff;
            color: var(--orange);
        }

        /* ===== KONTEN: banner kiri + form kanan ===== */
        .wrap {
            flex: 1;
            max-width: 1040px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 16px;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 0;
            align-items: stretch;
        }

        .banner {
            border-radius: 18px 0 0 18px;
            background:
                linear-gradient(160deg, rgba(106, 8, 1, .88), rgba(202, 66, 56, .78)),
                url('/images/pizza.jpg') center / cover no-repeat;
            color: #fff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .banner .tag {
            align-self: flex-start;
            background: var(--cream);
            color: var(--maroon);
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 50px;
        }

        .banner h1 {
            margin: 14px 0 10px;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 900;
            line-height: 1.05;
            text-transform: uppercase;
        }

        .banner p {
            margin: 0 0 22px;
            color: rgba(255, 255, 255, .9);
            max-width: 360px;
        }

        .banner ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
            font-size: 14px;
        }

        .card {
            background: var(--cream-card);
            border-radius: 0 18px 18px 0;
            padding: 48px 40px;
            box-shadow: 0 8px 30px rgba(106, 8, 1, .15);
        }

        .card h2 {
            margin: 0 0 4px;
            font-size: 28px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .card .sub {
            margin: 0 0 24px;
            color: rgba(106, 8, 1, .7);
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        input {
            width: 100%;
            padding: 13px 16px;
            margin-bottom: 18px;
            border: 2px solid rgba(106, 8, 1, .15);
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            background: #fff;
            color: var(--maroon);
        }

        input:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(222, 120, 1, .2);
        }

        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 46px; }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 13px;
            width: 24px;
            height: 24px;
            padding: 0;
            background: transparent;
            color: var(--maroon);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password svg { width: 20px; height: 20px; display: block; }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .5px;
            cursor: pointer;
            font-family: inherit;
            transition: background .2s ease;
        }

        button[type="submit"]:hover { background: var(--maroon); }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .bawah {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
        }

        .bawah a {
            color: var(--orange);
            font-weight: 700;
            text-decoration: none;
        }

        .bawah a:hover { text-decoration: underline; }

        footer {
            background: var(--maroon);
            color: rgba(255, 255, 255, .75);
            text-align: center;
            font-size: 12px;
            padding: 14px;
        }

        @media (max-width: 820px) {
            .wrap { grid-template-columns: 1fr; }
            .banner { display: none; }
            .card { border-radius: 18px; padding: 32px 24px; }
        }
    </style>
</head>

<body>

    <header class="topbar">
        <div class="inner">
            <a href="{{ route('login') }}" class="brand"><span class="logo">🍕</span> Pizza Moza</a>
            <a href="{{ route('register') }}" class="daftar">Daftar</a>
        </div>
    </header>

    <div class="wrap">

        <div class="banner">
            <span class="tag">Order Now</span>
            <h1>Lapar?<br>Pesan Pizza<br>Sekarang!</h1>
            <p>Masuk untuk memesan pizza dan cemilan favoritmu, diantar hangat sampai depan pintu.</p>
            <ul>
                <li>🍕 Pizza dengan keju melimpah</li>
                <li>🛵 Delivery cepat</li>
                <li>💳 Bayar Cash atau Midtrans</li>
            </ul>
        </div>

        <div class="card">

            <h2>Masuk</h2>
            <p class="sub">Masuk ke akun Pizza Moza kamu</p>

            @if (session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                    required autofocus>

                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Password kamu" required>

                    <button type="button" class="toggle-password" onclick="togglePassword()">

                        <!-- ICON MATA -->

                    <span id="eyeIcon">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="3"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                        </svg>

                    </span>

                    <!-- ICON MATA DICORET -->

                    <span
                        id="eyeSlashIcon"
                        style="display: none;"
                    >

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M3 3l18 18"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                            <path
                                d="M10.6 6.2A10.7 10.7 0 0 1 12 6c6.5 0 10 6 10 6a18.5 18.5 0 0 1-3.1 3.7"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                            <path
                                d="M6.2 8.2C3.6 9.8 2 12 2 12s3.5 6 10 6c1.1 0 2.1-.2 3-.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                        </svg>

                    </span>

                </button>
                </div>

                <button type="submit">Masuk</button>
            </form>

            <div class="bawah">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

        </div>
    </div>

    <footer>&copy; {{ date('Y') }} Pizza Moza. Semua hak dilindungi.</footer>

    <script>

        function togglePassword() {

            const password =
                document.getElementById('password');
            const eyeIcon =
                document.getElementById('eyeIcon');
            const eyeSlashIcon =
                document.getElementById('eyeSlashIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';

            } else {
                password.type = 'password';
                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';

            }

        }

    </script>

</body>
</html>
