<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard Admin') - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== PALET: dominan krem, aksen oranye & maroon =====
           Krem #F7D991 | Oranye #DE7801 | Merah #CA4238 | Maroon #6A0801
        */
        :root,
        [data-bs-theme="light"],
        [data-bs-theme="dark"] {
            --moza-cream: #F7D991;
            --moza-cream-light: #FCF3DC;
            --moza-cream-card: #FFFAEE;
            --moza-orange: #DE7801;
            --moza-red: #CA4238;
            --moza-maroon: #6A0801;

            --moza-accent: var(--moza-orange);
            --moza-accent-text: #fff;

            --bs-body-bg: var(--moza-cream-light);
            --bs-body-color: var(--moza-maroon);
            --bs-secondary-color: rgba(106, 8, 1, 0.65);
            --bs-border-color: rgba(106, 8, 1, 0.12);
            --bs-tertiary-bg: #F9E9BD;
            --bs-secondary-bg: #F9E9BD;
            --bs-card-bg: var(--moza-cream-card);
            --bs-table-bg: transparent;
            --bs-table-color: var(--moza-maroon);
            --bs-heading-color: var(--moza-maroon);
            --bs-link-color: var(--moza-orange);
            --bs-link-color-rgb: 222, 120, 1;
            --bs-link-hover-color: var(--moza-maroon);
            --bs-link-hover-color-rgb: 106, 8, 1;
            --bs-primary: var(--moza-orange);
            --bs-primary-rgb: 222, 120, 1;
            --bs-danger: var(--moza-red);
            --bs-danger-rgb: 202, 66, 56;
        }

        /* Teks abu-abu mengikuti tema (maroon lembut) */
        .text-secondary,
        .text-muted {
            color: var(--bs-secondary-color) !important;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            --bs-offcanvas-width: 250px;
            --bs-offcanvas-bg: var(--moza-cream);
            --bs-offcanvas-color: var(--moza-maroon);

            width: 250px;
            flex-shrink: 0;
            background: var(--moza-cream);
            border-right: 1px solid var(--bs-border-color);
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin-bottom: 6px;
            border-radius: 12px;
            color: var(--moza-maroon);
            font-size: 16px;
            transition: all .2s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(106, 8, 1, 0.08);
            color: var(--moza-maroon);
        }

        .sidebar .nav-link.active {
            background: var(--moza-orange);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(222, 120, 1, 0.3);
        }

        /* Logout: tepat di bawah menu, dipisah garis tipis */
        .sidebar-logout {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--bs-border-color);
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
            --bs-btn-border-color: rgba(106, 8, 1, 0.35);
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
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--moza-orange);
            color: #fff;
            font-weight: bold;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 42px;
            height: 42px;
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
            box-shadow: 0 2px 8px rgba(106, 8, 1, 0.05);
        }

        .table {
            --bs-table-striped-bg: rgba(247, 217, 145, 0.25);
            --bs-table-hover-bg: rgba(247, 217, 145, 0.4);
            --bs-table-border-color: var(--bs-border-color);
        }

        .table thead th {
            background: var(--moza-cream);
            color: var(--moza-maroon);
        }

        .form-control,
        .form-select {
            background-color: #fff;
            border-color: rgba(106, 8, 1, 0.2);
            color: var(--moza-maroon);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            color: var(--moza-maroon);
            border-color: var(--moza-orange);
            box-shadow: 0 0 0 .2rem rgba(222, 120, 1, 0.2);
        }

        .form-control::placeholder {
            color: rgba(106, 8, 1, 0.4);
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

        /* ===== DROPDOWN: semua <select> punya panah + daftar krem ===== */
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
            border: 1px solid rgba(106, 8, 1, 0.2) !important;
            border-radius: 8px;
            color-scheme: light;
            cursor: pointer;
        }

        html body select:hover {
            border-color: var(--moza-orange) !important;
        }

        html body select:focus {
            border-color: var(--moza-orange) !important;
            box-shadow: 0 0 0 .2rem rgba(222, 120, 1, 0.2) !important;
            outline: none;
        }

        html body select option {
            background: var(--moza-cream-card) !important;
            color: var(--moza-maroon) !important;
        }


        /* =================================
   SIDEBAR TETAP SAAT HALAMAN DI-SCROLL
================================= */

        @media (min-width: 992px) {

            .sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                bottom: 0;

                width: 250px !important;
                height: 100vh;

                overflow-y: auto;
                overflow-x: hidden;

                z-index: 1030;
            }

            /* AREA KONTEN DI SEBELAH KANAN */
            .sidebar+.flex-grow-1 {
                margin-left: 250px;
                min-width: 0;
            }

        }

        /* SCROLLBAR SIDEBAR */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #DE7801;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #F7D991;
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
        // Data admin yang sedang login (untuk nama & foto di topbar)
        $adminLogin = \App\Models\Admin::find(session('user_id'));

        $emailAdmin = $adminLogin->email ?? session('email');

        // Pakai kolom "nama" jika ada, jika tidak pakai bagian email sebelum "@"
        $namaAdmin = $adminLogin->nama ?? ucfirst(\Illuminate\Support\Str::before($emailAdmin ?? 'admin', '@'));

        $fotoAdmin = $adminLogin->foto ?? null;
    @endphp

    <div class="d-flex min-vh-100">

        {{-- SIDEBAR --}}
        <aside class="sidebar offcanvas-lg offcanvas-start p-3 d-flex flex-column" tabindex="-1" id="sidebarMenu">

            <div class="d-flex align-items-center justify-content-between px-2 pb-4">

                <div class="d-flex align-items-center gap-2">

                    <span class="fs-2">🍕</span>

                    <div>
                        <div class="fw-bold" style="letter-spacing:1px;">
                            PIZZA MOZA
                        </div>

                        <small style="letter-spacing:2px; font-size:11px; opacity:.7;">
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

                <a class="nav-link {{ request()->routeIs('admin.pesanans.*') ? 'active' : '' }}"
                    href="{{ route('admin.pesanans.indexAdmin') }}">
                    <span>📋</span>
                    Kelola Pesanan
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

                <a class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}"
                    href="{{ route('pembayaran.index') }}"
                    <span>💳</span>
                    Kelola Transaksi
                </a>

                <a class="nav-link {{ request()->routeIs('admin.analisis.*') ? 'active' : '' }}"
                    href="{{ route('admin.analisis.index') }}">
                     <span>📊</span>
                     Analisis Keputusan
                 </a>

                <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}"
                    href="{{ route('pengguna.index') }}">
                    <span>👤</span>
                    Kelola Pengguna
                </a>

            </nav>


            {{-- LOGOUT: tepat di bawah menu (bukan menempel di dasar sidebar) --}}
            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout">

                @csrf

                <button type="submit" class="btn btn-outline-danger w-100 py-2">
                    ⏻ Logout
                </button>

            </form>

        </aside>


        {{-- AREA KANAN --}}
        <div class="flex-grow-1 d-flex flex-column" style="min-width:0;">


            {{-- TOPBAR --}}
            <header class="topbar d-flex align-items-center gap-3 px-3 px-lg-4 py-3">

                <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu">
                    ☰
                </button>


                <div class="ms-auto d-flex align-items-center gap-3">

                    {{-- NAMA, EMAIL & FOTO (klik untuk membuka profil admin) --}}
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
            <main class="p-3 p-lg-4">

                @yield('content')

            </main>


        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>
