<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Pizza Moza</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #FDF8EE;
            --beige: #FBF0D5;
            --orange: #E8751A;
            --yellow: #FBE7A1;
            --brown: #8B1A10;
            --ink: #2B1B14;
            --border: #EBDDBA;
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
            font-family: 'Raleway', system-ui, sans-serif;
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .login-link:hover {
            color: var(--orange);
        }

        .order-btn {
            background: var(--orange);
            color: white;
            text-decoration: none;
            padding: 13px 23px;
            border-radius: 9px;
            font-weight: bold;
        }

        .order-btn:hover {
            background: #C95F0F;
        }

        /* AREA UTAMA */

        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 5%;
            background-image:
                linear-gradient(90deg, rgba(139, 26, 16, 0.88), rgba(139, 26, 16, 0.55), rgba(139, 26, 16, 0.25)),
                url('{{ asset('images/pizza.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .auth-wrap {
            width: 100%;
            max-width: 440px;
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

        /* KARTU FORM */

        .auth-card {
            background: #FFFBF0;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 36px;
            box-shadow: 0 9px 22px rgba(80, 40, 10, .14);
        }

        .auth-card h2 {
            text-align: center;
            color: var(--brown);
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .auth-desc {
            text-align: center;
            color: #7A6A5F;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 26px;
        }

        .auth-card label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: var(--brown);
        }

        .auth-card input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 9px;
            font-family: inherit;
            font-size: 14px;
            margin-bottom: 18px;
            outline: none;
            background: white;
            color: var(--ink);
        }

        .auth-card input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(232, 117, 26, .15);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 46px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 11px;
            width: 24px;
            height: 24px;
            padding: 0;
            border: none;
            background: transparent;
            color: var(--brown);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: var(--orange);
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 28px;
            background: var(--orange);
            color: white;
            border: none;
            border-radius: 9px;
            font-family: inherit;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .submit-btn:hover {
            background: #C95F0F;
        }

        .auth-bottom {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #7A6A5F;
        }

        .auth-bottom a {
            color: var(--brown);
            font-weight: bold;
            text-decoration: none;
        }

        .auth-bottom a:hover {
            color: var(--orange);
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px 14px;
            border-radius: 9px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .error ul {
            padding-left: 18px;
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

        @media(max-width: 900px) {
            .nav-menu {
                gap: 15px;
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

            .auth-main {
                padding: 35px 20px;
            }

            .auth-card {
                padding: 28px 22px;
            }

            .footer-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
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
            <a href="{{ route('home') }}#menu">MENU</a>
            <a href="{{ route('home') }}#tentang">TENTANG KAMI</a>
        </nav>

        <div class="nav-actions">
            <a href="{{ route('login') }}" class="login-link">
                Login / Register
            </a>

            <a href="{{ route('home') }}#menu" class="order-btn">
                Order Now
            </a>
        </div>

    </header>


    <!-- KONTEN (LOGIN / REGISTER) -->

    <main class="auth-main">
        <div class="auth-wrap">
            @yield('content')
        </div>
    </main>


    <!-- FOOTER -->

    <footer id="tentang">

        <div class="footer-container">

            <div class="footer-brand">
                <h3>🍕 PIZZA MOZA</h3>
                <p>Rasa Juara, Harga Bersahabat!</p>
            </div>

            <div class="footer-contact">

                <h3>Hubungi Kami</h3>

                <div class="contact-links">

                    <a href="https://www.instagram.com/pizzamozza2025/" target="_blank" rel="noopener noreferrer"
                        class="contact-item">
                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm0 2h10c1.66 0 3 1.34 3 3v10c0 1.66-1.34 3-3 3H7c-1.66 0-3-1.34-3-3V7c0-1.66 1.34-3 3-3zm10.5 1.5a1 1 0 100 2 1 1 0 000-2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z" />
                        </svg>
                        <span>@pizzamozza2025</span>
                    </a>

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

        <div class="footer-bottom">
            © {{ date('Y') }} Pizza Moza. All Rights Reserved.
        </div>

    </footer>

    @stack('scripts')

</body>

</html>
