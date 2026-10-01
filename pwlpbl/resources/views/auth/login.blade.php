<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Pizza Moza</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: -1;
        }

        .card {
            background: rgba(58, 48, 45, 0.94);
            padding: 32px;
            border-radius: 15px;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        h2 {
            margin: 0 0 25px;
            text-align: center;
            color: #ffffff;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 16px;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            background: #d9d9d9;
            color: #222222;
        }

        input:focus {
            outline: 2px solid #a85f43;
        }

        /* PASSWORD */

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 42px;
        }

        .toggle-password {
            position: absolute;

            right: 10px;
            top: 50%;
            transform: translateY(-80%);
            width: 24px;
            height: 24px;
            padding: 0;
            background: transparent;
            color: #222222;
            border: none;
            border-radius: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            background: transparent;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        /* TOMBOL LOGIN */

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #000000;
            color: #ffffff;
            border: none;
            border-radius: 20px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 3px;
        }

        /* SAAT MOUSE DIARAHKAN */
        button[type="submit"]:hover {
            background: #000000;
            color: #ffffff;
        }

        /* ERROR */

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        /* REGISTER */

        .bawah {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #ffffff;
        }

        .bawah a {
            color: #ff6b5f;
            text-decoration: none;
        }

        .bawah a:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */

        @media (max-width: 480px) {
            .card {
                width: 90%;
                padding: 28px 24px;
            }
        }
    </style>
</head>

<body>

    <div class="card">

        <h2>Login</h2>

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

            <!-- EMAIL -->

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

            <!-- PASSWORD -->

            <label for="password">
                Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

                <button
                    type="button"
                    class="toggle-password"
                    onclick="togglePassword()"
                >

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

            <!-- TOMBOL LOGIN -->

            <button type="submit">
                Login
            </button>

        </form>

        <!-- LINK REGISTER -->

        <div class="bawah">

            Belum punya akun?

            <a href="{{ route('register') }}">
                Register
            </a>

        </div>

    </div>

    <!-- SCRIPT SHOW / HIDE PASSWORD -->

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
