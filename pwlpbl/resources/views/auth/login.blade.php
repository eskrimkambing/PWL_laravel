@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper input {
            width: 100%;
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
            color: #8B1A10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #E8751A;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            display: block;
        }
    </style>

    <div class="auth-card">

        <h2>Welcome Back!</h2>

        <p class="auth-desc">
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

            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email kamu"
                required autofocus>

            <label for="password">Password</label>

            <div class="password-wrapper">

                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Tampilkan password">

                    <!-- Ikon mata terbuka -->
                    <span id="eyePassword">

                        <svg viewBox="0 0 24 24">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" fill="none" stroke="currentColor"
                                stroke-width="2" />
                            <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor"
                                stroke-width="2" />
                        </svg>

                    </span>

                    <!-- Ikon mata dicoret -->
                    <span id="eyeSlashPassword" style="display: none;">

                        <svg viewBox="0 0 24 24">
                            <path d="M3 3l18 18" fill="none" stroke="currentColor" stroke-width="2" />
                            <path d="M10.6 6.2A10.7 10.7 0 0 1 12 6c6.5 0 10 6 10 6a18.5 18.5 0 0 1-3.1 3.7" fill="none"
                                stroke="currentColor" stroke-width="2" />
                            <path d="M6.2 8.2C3.6 9.8 2 12 2 12s3.5 6 10 6c1.1 0 2.1-.2 3-.5" fill="none"
                                stroke="currentColor" stroke-width="2" />
                        </svg>

                    </span>

                </button>

            </div>

            <button type="submit" class="submit-btn">
                LOGIN SEKARANG
            </button>

        </form>

        <div class="auth-bottom">
            Belum punya akun?
            <a href="{{ route('register') }}">Register</a>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyePassword');
            const eyeSlashIcon = document.getElementById('eyeSlashPassword');
            const toggleButton = document.querySelector('.toggle-password');

            if (password.type === 'password') {

                // Tampilkan password
                password.type = 'text';

                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';

                toggleButton.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {

                // Sembunyikan password
                password.type = 'password';

                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';

                toggleButton.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );

            }
        }
    </script>
@endpush
