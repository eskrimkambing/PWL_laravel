<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #1c1512;
            color: #f3e9e1;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #261c17;
            border-right: 1px solid rgba(255,255,255,.08);
            padding: 24px 16px;
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand h4 {
            margin: 0;
            font-weight: 700;
            color: #eadccf;
        }

        .brand small {
            color: #a89485;
        }

        .nav-link {
            color: #cdbeb3;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 10px;
            text-decoration: none;
            display: block;
        }

        .nav-link:hover {
            background: #33261f;
            color: #fff;
        }

        .nav-link.active {
            background: #3d2e26;
            color: #fff;
        }

        .logout {
            position: absolute;
            bottom: 20px;
            left: 16px;
            right: 16px;
        }

        .logout-btn {
            width: 100%;
            padding: 11px 15px;
            border: 1px solid #dc3545;
            border-radius: 6px;
            background: transparent;
            color: #dc3545;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #dc3545;
            color: #fff;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 75px;
            padding: 0 30px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #eadccf;
            color: #2a1e17;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .content {
            padding: 30px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h3 {
            margin-bottom: 5px;
        }

        .page-title p {
            color: #a89485;
            margin: 0;
        }

        .form-card {
            max-width: 850px;
            background: #261c17;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 30px;
        }

        .form-label {
            color: #e8dcd4;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            background: #33261f;
            border: 1px solid rgba(255,255,255,.1);
            color: #f3e9e1;
            border-radius: 9px;
            padding: 11px 13px;
        }

        .form-control:focus {
            background: #33261f;
            color: #fff;
            border-color: #eadccf;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: #8f7e73;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .password-info {
            color: #a89485;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-moza {
            background: #eadccf;
            color: #2a1e17;
            border: none;
            padding: 10px 20px;
            border-radius: 9px;
            font-weight: 600;
        }

        .btn-moza:hover {
            background: #fff;
            color: #2a1e17;
        }

        .btn-outline-moza {
            border: 1px solid #eadccf;
            color: #eadccf;
            padding: 10px 20px;
            border-radius: 9px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-moza:hover {
            background: #eadccf;
            color: #2a1e17;
        }

        .alert {
            max-width: 850px;
            border-radius: 10px;
        }

        .invalid-feedback {
            color: #e9aaa0;
        }

        @media (max-width: 768px) {

            .sidebar {
                width: 210px;
            }

            .main {
                margin-left: 210px;
            }

            .topbar,
            .content {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="brand">
            <h4>🍕 PIZZA MOZA</h4>
            <small>PEMBELI PANEL</small>
        </div>

        <nav>

            <a href="{{ route('dashboard.pembeli') }}" class="nav-link">
                🏠 Beranda
            </a>

            <a href="{{ route('pembeli.products') }}" class="nav-link">
                🍕 Menu Produk
            </a>

            <a href="{{ route('pembeli.kategoris') }}" class="nav-link">
                📂 Kategori
            </a>

            <a href="{{ route('pesanans.index') }}" class="nav-link">
                📋 Pesanan Saya
            </a>

            <a href="{{ route('checkout.index') }}" class="nav-link">
                🛒 Checkout
            </a>

            <a href="{{ route('profil.show') }}" class="nav-link active">
                👤 Profil
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-btn">
                    ⏻ Logout
                </button>

            </form>

        </div>

    </div>


    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>
                <strong>Edit Profil</strong>
            </div>

            <div class="user-info">

                <div class="text-end">

                    <div style="font-size: 14px;">
                        {{ session('nama') ?? 'Pembeli' }}
                    </div>

                    <small style="color:#a89485;">
                        {{ session('email') ?? '' }}
                    </small>

                </div>

                <div class="avatar">
                    {{ strtoupper(substr(session('nama') ?? 'P', 0, 1)) }}
                </div>

            </div>

        </div>


        <!-- CONTENT -->
        <div class="content">

            <div class="page-title">
                <h3>Edit Profil</h3>
                <p>Perbarui informasi akun kamu di sini.</p>
            </div>


            <!-- ERROR -->
            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>Data belum benar.</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- FORM CARD -->
            <div class="form-card">

                <form action="{{ route('profil.update') }}" method="POST">

                    @csrf
                    @method('PUT')


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="{{ old('nama', $pembeli->nama) }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    <!-- EMAIL -->
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $pembeli->email) }}"
                            placeholder="Masukkan email"
                            required
                        >

                    </div>


                    <!-- NOMOR TELEPON -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            name="no_telp"
                            class="form-control"
                            value="{{ old('no_telp', $pembeli->no_telp) }}"
                            placeholder="Masukkan nomor telepon"
                        >

                    </div>


                    <!-- ALAMAT -->
                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            placeholder="Masukkan alamat lengkap"
                        >{{ old('alamat', $pembeli->alamat) }}</textarea>

                    </div>


                    <hr style="border-color: rgba(255,255,255,.08); margin: 25px 0;">


                    <!-- PASSWORD -->
                    <h5 class="mb-3">
                        Ubah Password
                    </h5>


                    <div class="mb-3">

                        <label class="form-label">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengubah password"
                        >

                        <div class="password-info">
                            Minimal 6 karakter. Kosongkan jika password tidak ingin diubah.
                        </div>

                    </div>


                    <!-- KONFIRMASI PASSWORD -->
                    <div class="mb-4">

                        <label class="form-label">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru"
                        >

                    </div>


                    <!-- BUTTON -->
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn-moza">
                            💾 Simpan Perubahan
                        </button>

                        <a href="{{ route('profil.show') }}"
                           class="btn-outline-moza">
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>
</html>
