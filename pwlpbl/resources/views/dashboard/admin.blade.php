<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard Admin') - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ===== PALET WARNA ===== */

        :root,
        [data-bs-theme="light"],
        [data-bs-theme="dark"] {
            --moza-cream: #F9ECE8;
            --moza-cream-light: #FAF7F4;
            --moza-cream-card: #FFFFFF;
            --moza-orange: #E8751A;
            --moza-red: #D2392B;
            --moza-maroon: #8B1A10;

            --moza-ink: #2B1B14;

            --bs-body-font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', sans-serif;
            --font-heading: 'Poppins', system-ui, -apple-system, 'Segoe UI', sans-serif;
            --moza-accent: var(--moza-orange);
            --moza-accent-text: #fff;

            --bs-body-bg: var(--moza-cream-light);
            --bs-body-color: var(--moza-ink);
            --bs-secondary-color: rgba(43, 27, 20, 0.65);
            --bs-border-color: rgba(139, 26, 16, 0.12);
            --bs-tertiary-bg: #F9ECE8;
            --bs-secondary-bg: #F9ECE8;
            --bs-card-bg: var(--moza-cream-card);
            --bs-table-bg: transparent;
            --bs-table-color: var(--moza-ink);
            --bs-heading-color: var(--moza-ink);
            --bs-link-color: var(--moza-orange);
            --bs-link-color-rgb: 232, 117, 26;
            --bs-link-hover-color: var(--moza-maroon);
            --bs-link-hover-color-rgb: 106, 8, 1;
            --bs-primary: var(--moza-orange);
            --bs-primary-rgb: 222, 120, 1;
            --bs-danger: var(--moza-red);
            --bs-danger-rgb: 202, 66, 56;
        }

        /* ===== TEKS SEKUNDER ===== */

        .text-secondary,
        .text-muted {
            color: var(--bs-secondary-color) !important;
        }

        /* ===== SIDEBAR ===== */

        .sidebar {
            --bs-offcanvas-width: 220px;
            --bs-offcanvas-bg: var(--moza-maroon);
            --bs-offcanvas-color: #fff;

            width: 220px;
            flex-shrink: 0;
            background: var(--moza-maroon);
            color: #8B1A10;
            border-right: none;
        }

        /* Tulisan logo dan admin panel */
        .sidebar .fw-bold,
        .sidebar small {
            color: #8B1A10 !important;
        }

        /* Tulisan menu sidebar */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            margin-bottom: 3px;
            border-radius: 10px;
            color: #8B1A10 !important;
            font-size: var(--fs-sm);
            transition: all .2s ease;
        }

        /* Hover menu */
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #8B1A10 !important;
        }

        /* Menu aktif */
        .sidebar .nav-link.active {
            background: var(--moza-orange);
            color: #FFFFFF !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(232, 117, 26, 0.3);
        }

        /* ===== LOGOUT ===== */

        .sidebar-logout {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar .btn-outline-danger {
            --bs-btn-color: #8B1A10;
            --bs-btn-border-color: #8B1A10;
            --bs-btn-hover-bg: #8B1A10;
            --bs-btn-hover-color: #FFFFFF;
            --bs-btn-hover-border-color: #8B1A10;
            --bs-btn-active-bg: #8B1A10;
            --bs-btn-active-color: #FFFFFF;
        }

        .sidebar .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* ===== TOMBOL ===== */

        .btn-moza,
        .btn-primary {
            --bs-btn-bg: var(--moza-orange);
            --bs-btn-border-color: var(--moza-orange);
            --bs-btn-color: #fff;
            --bs-btn-hover-bg: var(--moza-maroon);
            --bs-btn-hover-border-color: var(--moza-maroon);
            --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: var(--moza-maroon);
            --bs-btn-active-border-color: var(--moza-maroon);
            --bs-btn-active-color: #fff;

            background: var(--moza-orange);
            color: #fff;
            border: none;
            font-weight: 600;
        }

        .btn-moza:hover {
            background: var(--moza-maroon);
            color: #fff;
        }

        .btn-outline-danger {
            --bs-btn-color: var(--moza-red);
            --bs-btn-border-color: var(--moza-red);
            --bs-btn-hover-bg: var(--moza-red);
            --bs-btn-hover-border-color: var(--moza-red);
            --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: var(--moza-red);
            --bs-btn-active-border-color: var(--moza-red);
        }

        .btn-outline-secondary {
            --bs-btn-color: var(--moza-maroon);
            --bs-btn-border-color: rgba(139, 26, 16, 0.35);
            --bs-btn-hover-bg: var(--moza-maroon);
            --bs-btn-hover-border-color: var(--moza-maroon);
            --bs-btn-hover-color: #fff;
        }

        /* ===== TOPBAR ===== */

        .topbar {
            background: var(--moza-cream-card);
            border-bottom: 1px solid var(--bs-border-color);
        }

        .avatar {
            width: 34px;
            height: 34px;
            font-size: var(--fs-sm);
            border-radius: 50%;
            background: var(--moza-orange);
            color: #fff;
            font-weight: bold;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--moza-orange);
        }

        .profil-link {
            padding: 4px 8px;
            border-radius: 12px;
            transition: background 0.2s ease;
        }

        .profil-link:hover {
            background: var(--bs-tertiary-bg);
        }

        /* ===== KARTU, TABEL, FORM ===== */

        .card {
            background: var(--moza-cream-card);
            border-color: var(--bs-border-color);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(139, 26, 16, 0.05);
        }

        .table {
            --bs-table-striped-bg: rgba(139, 26, 16, 0.03);
            --bs-table-hover-bg: rgba(139, 26, 16, 0.06);
            --bs-table-border-color: var(--bs-border-color);
        }

        .table thead th {
            background: var(--moza-cream);
            color: var(--moza-maroon);
        }

        .form-control,
        .form-select {
            background-color: #fff;
            border-color: rgba(139, 26, 16, 0.2);
            color: var(--moza-maroon);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            color: var(--moza-maroon);
            border-color: var(--moza-orange);
            box-shadow: 0 0 0 .2rem rgba(232, 117, 26, 0.2);
        }

        .form-control::placeholder {
            color: rgba(139, 26, 16, 0.4);
        }

        .badge.bg-success {
            background-color: var(--moza-orange) !important;
            color: #fff;
        }

        .badge.bg-danger {
            background-color: var(--moza-red) !important;
        }

        .pagination {
            --bs-pagination-bg: var(--moza-cream-card);
            --bs-pagination-color: var(--moza-maroon);
            --bs-pagination-border-color: var(--bs-border-color);
            --bs-pagination-hover-bg: var(--moza-cream);
            --bs-pagination-hover-color: var(--moza-maroon);
            --bs-pagination-active-bg: var(--moza-orange);
            --bs-pagination-active-border-color: var(--moza-orange);
            --bs-pagination-active-color: #fff;
        }

        /* ===== DROPDOWN ===== */

        html body select,
        html body select.form-control,
        html body select.form-select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-color: #fff !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236A0801' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.85rem center !important;
            background-size: 16px 12px !important;
            padding-right: 2.5rem !important;
            color: var(--moza-maroon) !important;
            border: 1px solid rgba(139, 26, 16, 0.2) !important;
            border-radius: 8px;
            color-scheme: light;
            cursor: pointer;
        }

        html body select:hover {
            border-color: var(--moza-orange) !important;
        }

        html body select:focus {
            border-color: var(--moza-orange) !important;
            box-shadow: 0 0 0 .2rem rgba(232, 117, 26, 0.2) !important;
            outline: none;
        }

        html body select option {
            background: var(--moza-cream-card) !important;
            color: var(--moza-maroon) !important;
        }

        /* ===== SIDEBAR TETAP SAAT SCROLL ===== */

        @media (min-width: 992px) {

            .sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                bottom: 0;

                width: 220px !important;
                height: 100vh;

                overflow-y: auto;
                overflow-x: hidden;

                z-index: 1030;
            }

            .sidebar+.flex-grow-1 {
                margin-left: 220px;
                min-width: 0;
            }
        }

        /* ===== SCROLLBAR SIDEBAR ===== */

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #E8751A;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #6E1209;
        }


        /* ===== MODE KOMPAK (tampilan lebih kecil & rapi) ===== */

        body {
            font-size: var(--fs-sm);
        }

        h1,
        .h1 {
            font-size: var(--fs-2xl);
        }

        h2,
        .h2 {
            font-size: var(--fs-xl);
        }

        h3,
        .h3 {
            font-size: var(--fs-lg);
        }

        h4,
        .h4 {
            font-size: var(--fs-base);
        }

        h5,
        .h5 {
            font-size: var(--fs-base);
        }

        .sidebar .fw-bold {
            font-size: var(--fs-sm);
        }

        .sidebar small {
            font-size: var(--fs-xs) !important;
        }

        .card {
            border-radius: 12px;
        }

        .card-body {
            padding: 1rem;
        }

        .card-header,
        .card-footer {
            padding: .6rem 1rem;
        }

        .table> :not(caption)>*>* {
            padding: .5rem .65rem;
        }

        .table thead th {
            font-size: var(--fs-sm);
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .btn {
            --bs-btn-padding-y: .3rem;
            --bs-btn-padding-x: .75rem;
            --bs-btn-font-size: var(--fs-sm);
            --bs-btn-border-radius: 8px;
        }

        .btn-sm {
            --bs-btn-padding-y: .2rem;
            --bs-btn-padding-x: .55rem;
            --bs-btn-font-size: var(--fs-xs);
        }

        .form-control,
        .form-select {
            padding: .4rem .7rem;
            font-size: var(--fs-sm);
            border-radius: 8px;
        }

        .form-label {
            margin-bottom: .25rem;
            font-size: var(--fs-sm);
        }

        .badge {
            font-size: var(--fs-xs);
        }

        .alert {
            padding: .6rem .9rem;
            font-size: var(--fs-sm);
        }

        .pagination {
            --bs-pagination-padding-x: .6rem;
            --bs-pagination-padding-y: .25rem;
            --bs-pagination-font-size: var(--fs-sm);
        }

        /* Rapatkan jarak antar elemen */
        main .mb-5 {
            margin-bottom: 1.75rem !important;
        }

        main .mb-4 {
            margin-bottom: 1.1rem !important;
        }

        main .py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        main .p-5 {
            padding: 2rem !important;
        }

        main .p-4 {
            padding: 1.1rem !important;
        }

        main .fs-1 {
            font-size: var(--fs-3xl) !important;
        }

        main .fs-2 {
            font-size: var(--fs-2xl) !important;
        }

        /* ===== TIPOGRAFI ===== */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        .navbar-brand,
        .sidebar-logout,
        .btn,
        .card-title,
        .table thead th {
            font-family: var(--font-heading);
        }

        .table td,
        .badge {
            font-variant-numeric: lining-nums tabular-nums;
        }

        /* ===== TOMBOL AKSI (SERAGAM DI SEMUA HALAMAN KELOLA) ===== */

        .aksi-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }

        .aksi-group form {
            margin: 0;
        }

        .btn-aksi {
            font-size: 14px;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
            padding: .35rem .85rem;
            white-space: nowrap;
        }

        .btn-aksi-icon {
            padding: .4rem .65rem;
            line-height: 1;
        }

        .btn-aksi-icon i {
            margin: 0;
            font-size: 15px;
        }

        /* Utama (oranye): Stok, Detail */
        .btn-aksi-stok,
        .btn-aksi-detail {
            background: var(--moza-orange);
            color: #fff;
        }

        .btn-aksi-stok:hover,
        .btn-aksi-detail:hover {
            background: var(--moza-maroon);
            color: #fff;
        }

        /* Edit (krem, ikon merah) */
        .btn-aksi-edit {
            background: #F9ECE8;
            color: var(--moza-maroon);
        }

        .btn-aksi-edit:hover {
            background: var(--moza-cream);
            color: var(--moza-maroon);
        }

        .btn-aksi-edit i {
            color: var(--moza-red);
        }

        /* Hapus (merah) */
        .btn-aksi-hapus {
            background: #E5575A;
            color: #fff;
        }

        .btn-aksi-hapus:hover {
            background: var(--moza-red);
            color: #fff;
        }
    </style>

    @stack('styles')

</head>

<body>

    @php
        // Data admin yang sedang login
        $adminLogin = \App\Models\Admin::find(session('user_id'));

        $emailAdmin = $adminLogin->email ?? session('email');

        // Mengambil nama admin
        $namaAdmin = $adminLogin->nama ?? ucfirst(\Illuminate\Support\Str::before($emailAdmin ?? 'admin', '@'));

        $fotoAdmin = $adminLogin->foto ?? null;
    @endphp

    <div class="d-flex min-vh-100">

        {{-- SIDEBAR --}}

        <aside class="sidebar offcanvas-lg offcanvas-start p-2 d-flex flex-column" tabindex="-1" id="sidebarMenu">

            <div class="d-flex align-items-center justify-content-between px-2 pb-3">

                <div class="d-flex align-items-center gap-2">

                    <span class="fs-4">🍕</span>

                    <div>

                        <div class="fw-bold" style="letter-spacing:1px;">
                            PIZZA MOZA
                        </div>

                        <small style="letter-spacing:2px; font-size: var(--fs-xs); opacity:.7;">
                            ADMIN PANEL
                        </small>

                    </div>

                </div>

                <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas"
                    data-bs-target="#sidebarMenu"></button>

            </div>

            <nav class="nav flex-column">

                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ url('/admin/dashboard') }}">
                    <span>🏠</span>
                    Beranda
                </a>

                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                    href="{{ route('products.index') }}">
                    <span>🍕</span>
                    Kelola Produk
                </a>

                <a class="nav-link {{ request()->routeIs('toppings.*') ? 'active' : '' }}"
                    href="{{ route('toppings.index') }}">
                    <span>🧀</span>
                    Kelola Topping
                </a>

                <a class="nav-link {{ request()->routeIs('kategoris.*') ? 'active' : '' }}"
                    href="{{ route('kategoris.index') }}">
                    <span>📂</span>
                    Kelola Kategori
                </a>

                <a class="nav-link {{ request()->routeIs('stoks.*') ? 'active' : '' }}"
                    href="{{ route('stoks.index') }}">
                    <span>📦</span>
                    Kelola Stok
                </a>

                {{-- KELOLA PESANAN --}}

                <a class="nav-link {{ request()->routeIs('admin.pesanans.*') ? 'active' : '' }}"
                    href="{{ route('admin.pesanans.indexAdmin') }}">
                    <span>📋</span>
                    Kelola Pesanan
                </a>

                <a class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}"
                    href="{{ route('pembayaran.index') }}">
                    <span>💳</span>
                    Kelola Transaksi
                </a>

                <a class="nav-link {{ request()->routeIs('admin.analisis.*') ? 'active' : '' }}"
                    href="{{ route('admin.analisis.index') }}">
                    <span>📊</span>
                    Analisis Keputusan
                </a>

                <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"
                    href="{{ route('admin.laporan.index') }}">
                    <span>📊</span>
                    Laporan Penjualan
                </a>

                <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}"
                    href="{{ route('pengguna.index') }}">
                    <span>👤</span>
                    Kelola Pengguna
                </a>

            </nav>

            {{-- LOGOUT --}}

            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">

                @csrf

                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                    ⏻ Logout
                </button>

            </form>

        </aside>

        {{-- AREA KANAN --}}

        <div class="flex-grow-1 d-flex flex-column" style="min-width:0;">

            {{-- TOPBAR --}}

            <header class="topbar d-flex align-items-center gap-3 px-3 px-lg-4 py-2">

                <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu">
                    ☰
                </button>

                <div class="ms-auto d-flex align-items-center gap-3">

                    {{-- NAMA, EMAIL & FOTO ADMIN --}}

                    <a href="{{ route('admin.profil.show') }}"
                        class="profil-link d-flex align-items-center gap-3 text-decoration-none text-reset"
                        title="Lihat profil">

                        <div class="text-end d-none d-sm-block">

                            <div class="fw-semibold">
                                {{ $namaAdmin }}
                            </div>

                            <small class="text-secondary">
                                {{ $emailAdmin }}
                            </small>

                        </div>

                        @if ($fotoAdmin)
                            <img src="{{ $fotoAdmin }}" alt="Foto {{ $namaAdmin }}" class="avatar-img">
                        @else
                            <div class="avatar d-flex align-items-center justify-content-center">
                                {{ strtoupper(substr($namaAdmin ?: 'A', 0, 1)) }}
                            </div>
                        @endif

                    </a>

                </div>

            </header>

            {{-- ISI HALAMAN --}}

            <main class="p-3">

                @yield('content')

            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>
