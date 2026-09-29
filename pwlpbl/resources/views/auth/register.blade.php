<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 32px; border-radius: 10px; width: 100%; max-width: 380px; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
        h2 { margin: 0 0 20px; text-align: center; }
        label { display: block; margin-bottom: 6px; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
        button { width: 100%; padding: 11px; background: #16a34a; color: #fff; border: 0; border-radius: 6px; font-size: 15px; cursor: pointer; }
        button:hover { background: #15803d; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .error ul { margin: 0; padding-left: 18px; }
        .bawah { text-align: center; margin-top: 16px; font-size: 14px; }
        .bawah a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Register</h2>

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
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Sign In</button>
        </form>

        <div class="bawah">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>