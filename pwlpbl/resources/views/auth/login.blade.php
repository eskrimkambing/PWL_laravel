@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <span class="hero-label">🍕 SPECIAL MENU PIZZA MOZA</span>

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

            <input type="email" id="email" name="email" value="{{ old('email') }}"
                placeholder="Masukkan email kamu" required autofocus>

            <label for="password">Password</label>

            <div class="password-wrapper">

                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                <button type="button" class="toggle-password" onclick="togglePassword()"
                    aria-label="Tampilkan password">
                    <span id="eyeIcon">👁</span>
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
        function togglePassword(inputId, eyeId, eyeSlashId) {

            const password = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeId);
            const eyeSlashIcon = document.getElementById(eyeSlashId);

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
@endpush
