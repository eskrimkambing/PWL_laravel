<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard Admin') - Pizza Moza</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
            --bs-tertiary-bg: #33261f;
            --bs-secondary-bg: #261c17;
            --bs-card-bg: #261c17;
            --bs-table-bg: transparent;
            --bs-table-color: #f3e9e1;
            --bs-link-color-rgb: 234, 220, 207;
            --bs-link-hover-color-rgb: 255, 255, 255;
            --moza-accent: #eadccf;
            --moza-accent-text: #2a1e17;
        }

        .sidebar {
            --bs-offcanvas-width: 250px;
            --bs-offcanvas-bg: #261c17;
            --bs-offcanvas-color: #f3e9e1;

            width: 250px;
            flex-shrink: 0;
            border-right: 1px solid var(--bs-border-color);
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin-bottom: 6px;
            border-radius: 12px;
            color: var(--bs-secondary-color);
            font-size: 16px;
        }

        .sidebar .nav-link:hover {
            background: #33261f;
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: #3d2e26;
            color: #fff;
            box-shadow: inset 0 0 0 1px var(--bs-border-color);
        }

        .btn-moza {
            background: var(--moza-accent);
            color: var(--moza-accent-text);
            border: none;
            font-weight: 600;
        }

        .btn-moza:hover {
            background: #fff;
            color: var(--moza-accent-text);
        }

        .topbar {
            border-bottom: 1px solid var(--bs-border-color);
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--moza-accent);
            color: var(--moza-accent-text);
            font-weight: bold;
        }

        .card {
            border-color: var(--bs-border-color);
            border-radius: 16px;
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="d-flex min-vh-100">

    {{-- SIDEBAR --}}
    <aside
        class="sidebar offcanvas-lg offcanvas-start p-3 d-flex flex-column"
        tabindex="-1"
        id="sidebarMenu"
    >

        <div class="d-flex align-items-center justify-content-between px-2 pb-4">

            <div class="d-flex align-items-center gap-2">

                <span class="fs-2">🍕</span>

                <div>

                    <div
                        class="fw-bold"
                        style="letter-spacing:1px;"
                    >
                        PIZZA MOZA
                    </div>

                    <small
                        class="text-secondary"
                        style="letter-spacing:2px; font-size:11px;"
                    >
                        ADMIN PANEL
                    </small>

                </div>

            </div>

            <button
                type="button"
                class="btn-close d-lg-none"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
            ></button>

        </div>


        <nav class="nav flex-column">

            <a
                class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                href="{{ url('/admin/dashboard') }}"
            >
                <span>🏠</span>
                Beranda
            </a>

            <a
                class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                href="{{ route('products.index') }}"
            >
                <span>🍕</span>
                Kelola Produk
            </a>

            <a class="nav-link {{ request()->routeIs('pesanans.*') ? 'active' : '' }}"
                href="{{ route('pesanans.index') }}">
                <span>📋</span> Kelola Pesanan
            </a>

            <a
                class="nav-link {{ request()->routeIs('kategoris.*') ? 'active' : '' }}"
                href="{{ route('kategoris.index') }}"
            >
                <span>📂</span>
                Kelola Kategori
            </a>

            <a
                class="nav-link {{ request()->routeIs('stoks.*') ? 'active' : '' }}"
                href="{{ route('stoks.index') }}"
            >
                <span>📦</span>
                Kelola Stok
            </a>

            <a
                class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}"
                href="{{ route('pembayaran.index') }}"
            >
                <span>💳</span>
                Kelola Pembayaran
            </a>

            <a
                class="nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}"
                href="{{ route('pengguna.index') }}"
            >
                <span>👤</span>
                Kelola Pengguna
            </a>

        </nav>


        <form
            action="{{ route('logout') }}"
            method="POST"
            class="mt-auto"
        >

            @csrf

            <button
                type="submit"
                class="btn btn-outline-danger w-100 py-2"
            >
                ⏻ Logout
            </button>

        </form>

    </aside>


    {{-- AREA KANAN --}}
    <div
        class="flex-grow-1 d-flex flex-column"
        style="min-width:0;"
    >


        {{-- TOPBAR --}}
        <header
            class="topbar d-flex align-items-center gap-3 px-3 px-lg-4 py-3"
        >

            <button
                class="btn btn-outline-secondary d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu"
            >
                ☰
            </button>


            <div class="ms-auto d-flex align-items-center gap-3">

                <div class="text-end d-none d-sm-block">

                    <div class="fw-semibold">
                        Admin
                    </div>

                    <small class="text-secondary">
                        {{ session('email') }}
                    </small>

                </div>


                <div class="avatar d-flex align-items-center justify-content-center">

                    {{ strtoupper(substr(session('email') ?? 'A', 0, 1)) }}

                </div>


                <div class="text-end border-start ps-3">

                    <div
                        class="fs-5"
                        id="jam"
                    >
                        --:--
                    </div>

                    <small
                        class="text-secondary"
                        id="tanggal"
                    >
                        -
                    </small>

                </div>

            </div>

        </header>


        {{-- ISI HALAMAN --}}
        <main class="p-3 p-lg-4">

            @yield('content')

        </main>


    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

    function updateWaktu() {

        const now = new Date();

        document.getElementById('jam').textContent =
            now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            }).replace('.', ':');

        document.getElementById('tanggal').textContent =
            now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
    }

    updateWaktu();

    setInterval(updateWaktu, 30000);

</script>

@stack('scripts')

</body>
</html>
