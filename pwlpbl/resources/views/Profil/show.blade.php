<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Pizza Moza</title>

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

        .profile-card {
            max-width: 850px;
            background: #261c17;
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 30px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-bottom: 25px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #eadccf;
            color: #2a1e17;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: bold;
        }

        .profile-header h4 {
            margin-bottom: 5px;
        }

        .profile-header p {
            margin: 0;
            color: #a89485;
        }

        .info-box {
            background: #33261f;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 16px;
        }

        .info-label {
            color: #a89485;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #f3e9e1;
        }

        .btn-moza {
            background: #eadccf;
            color: #2a1e17;
            border: none;
            padding: 10px 18px;
            border-radius: 9px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-moza:hover {
            background: #fff;
            color: #2a1e17;
        }

        .btn-outline-moza {
            border: 1px solid #eadccf;
            color: #eadccf;
            padding: 10px 18px;
            border-radius: 9px;
            text-decoration: none;
        }

        .btn-outline-moza:hover {
            background: #eadccf;
            color: #2a1e17;
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
                <strong>Profil</strong>
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

                <h3>Profil Saya</h3>

                <p>
                    Lihat dan kelola informasi akun kamu.
                </p>

            </div>


            <!-- PROFILE CARD -->
            <div class="profile-card">

                <!-- PROFILE HEADER -->
                <div class="profile-header">

                    <div class="profile-avatar">
                        {{ strtoupper(substr($pembeli->nama ?? 'P', 0, 1)) }}
                    </div>

                    <div>

                        <h4>
                            {{ $pembeli->nama ?? 'Pembeli' }}
                        </h4>

                        <p>
                            {{ $pembeli->email ?? '-' }}
                        </p>

                    </div>

                </div>


                <!-- DATA PROFIL -->
                <div class="row">

                    <!-- NAMA -->
                    <div class="col-md-6">

                        <div class="info-box">

                            <div class="info-label">
                                Nama Lengkap
                            </div>

                            <div class="info-value">
                                {{ $pembeli->nama ?? '-' }}
                            </div>

                        </div>

                    </div>


                    <!-- EMAIL -->
                    <div class="col-md-6">

                        <div class="info-box">

                            <div class="info-label">
                                Email
                            </div>

                            <div class="info-value">
                                {{ $pembeli->email ?? '-' }}
                            </div>

                        </div>

                    </div>


                    <!-- NOMOR TELEPON -->
                    <div class="col-md-6">

                        <div class="info-box">

                            <div class="info-label">
                                Nomor Telepon
                            </div>

                            <div class="info-value">
                                {{ $pembeli->no_telp ?? '-' }}
                            </div>

                        </div>

                    </div>


                    <!-- ID PEMBELI -->
                    <div class="col-md-6">

                        <div class="info-box">

                            <div class="info-label">
                                ID Pembeli
                            </div>

                            <div class="info-value">
                                {{ $pembeli->id_pembeli }}
                            </div>

                        </div>

                    </div>


                    <!-- ALAMAT -->
                    <div class="col-12">

                        <div class="info-box">

                            <div class="info-label">
                                Alamat
                            </div>

                            <div class="info-value">
                                {{ $pembeli->alamat ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>


                <!-- BUTTON -->
                <div class="d-flex gap-2 mt-3">

                    <a href="{{ route('profil.edit') }}"
                       class="btn-moza">
                        ✏️ Edit Profil
                    </a>

                    <a href="{{ route('dashboard.pembeli') }}"
                       class="btn-outline-moza">
                        Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>
</html>
