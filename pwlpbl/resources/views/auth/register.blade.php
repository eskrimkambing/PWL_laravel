@extends('layouts.auth')

@section('title', 'Register')

@section('content')

    <span class="hero-label">🍕 BERGABUNG DENGAN PIZZA MOZA</span>

    <div class="auth-card">

        <h2>Buat Akun</h2>

        <p class="auth-desc">
            Daftar sekarang untuk mulai memesan pizza favoritmu.
        </p>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.proses') }}" method="POST">

            @csrf

            <label for="email">Email</label>

            <input type="email" id="email" name="email" value="{{ old('email') }}"
                placeholder="Masukkan email kamu" required autofocus>

            <label for="password">Password</label>

            <div class="password-wrapper">

                <input type="password" id="password" name="password" required>

                <button type="button" class="toggle-password"
                    onclick="togglePassword('password', 'eyePassword', 'eyeSlashPassword')"
                    aria-label="Tampilkan password">
                    <span id="eyePassword">
                        <svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" fill="none" stroke="currentColor" stroke-width="2" /><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="2" /></svg>
                    </span>
                    <span id="eyeSlashPassword" style="display: none;">
                        <svg viewBox="0 0 24 24"><path d="M3 3l18 18" fill="none" stroke="currentColor" stroke-width="2" /><path d="M10.6 6.2A10.7 10.7 0 0 1 12 6c6.5 0 10 6 10 6a18.5 18.5 0 0 1-3.1 3.7" fill="none" stroke="currentColor" stroke-width="2" /><path d="M6.2 8.2C3.6 9.8 2 12 2 12s3.5 6 10 6c1.1 0 2.1-.2 3-.5" fill="none" stroke="currentColor" stroke-width="2" /></svg>
                    </span>
                </button>

            </div>

            <label for="password_confirmation">Konfirmasi Password</label>

            <div class="password-wrapper">

                <input type="password" id="password_confirmation" name="password_confirmation" required>

                <button type="button" class="toggle-password"
                    onclick="togglePassword('password_confirmation', 'eyeConfirmation', 'eyeSlashConfirmation')"
                    aria-label="Tampilkan password">
                    <span id="eyeConfirmation">
                        <svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" fill="none" stroke="currentColor" stroke-width="2" /><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="2" /></svg>
                    </span>
                    <span id="eyeSlashConfirmation" style="display: none;">
                        <svg viewBox="0 0 24 24"><path d="M3 3l18 18" fill="none" stroke="currentColor" stroke-width="2" /><path d="M10.6 6.2A10.7 10.7 0 0 1 12 6c6.5 0 10 6 10 6a18.5 18.5 0 0 1-3.1 3.7" fill="none" stroke="currentColor" stroke-width="2" /><path d="M6.2 8.2C3.6 9.8 2 12 2 12s3.5 6 10 6c1.1 0 2.1-.2 3-.5" fill="none" stroke="currentColor" stroke-width="2" /></svg>
                    </span>
                </button>

            </div>

            <button type="submit" class="submit-btn">
                DAFTAR SEKARANG
            </button>

        </form>

        <div class="auth-bottom">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login</a>
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
