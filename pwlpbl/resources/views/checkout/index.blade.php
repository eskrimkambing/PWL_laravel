<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Checkout - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
            --bs-secondary-bg: #261c17;
            --moza-accent: #eadccf;
            --moza-accent-text: #2a1e17;
        }

        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background: #261c17;
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

        .product-card {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
            height: 100%;
        }

        .product-card:hover {
            background: #2d211b;
        }

        .checkout-box {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
        }

        .form-control,
        .form-select {
            background: #1c1512;
            border: 1px solid var(--bs-border-color);
            color: #f3e9e1;
        }

        .form-control:focus,
        .form-select:focus {
            background: #1c1512;
            color: #f3e9e1;
            border-color: #6b5648;
            box-shadow: none;
        }

        .form-select option {
            background: #261c17;
            color: #f3e9e1;
        }

        .payment-option {
            background: #1c1512;
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
        }

        .payment-option:hover {
            background: #2d211b;
        }

        .payment-option .form-check-input {
            margin-top: 5px;
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

        .price {
            color: #eadccf;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="d-flex min-vh-100">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar p-3 d-flex flex-column">

        <div class="d-flex align-items-center px-2 pb-4">

            <div class="d-flex align-items-center gap-2">

                <span class="fs-2">🍕</span>

                <div>
                    <div class="fw-bold" style="letter-spacing:1px;">
                        PIZZA MOZA
                    </div>

                    <small class="text-secondary"
                           style="letter-spacing:2px; font-size:11px;">
                        PEMBELI PANEL
                    </small>
                </div>

            </div>

        </div>


        <nav class="nav flex-column">

            <a class="nav-link"
               href="{{ route('dashboard.pembeli') }}">
                <span>🏠</span>
                Beranda
            </a>

            <a class="nav-link"
               href="{{ route('pembeli.products') }}">
                <span>🍕</span>
                Menu Produk
            </a>

            <a class="nav-link"
               href="{{ route('pembeli.kategoris') }}">
                <span>📂</span>
                Kategori
            </a>

            <a class="nav-link"
               href="{{ route('pesanans.index') }}">
                <span>📋</span>
                Pesanan Saya
            </a>

            <a class="nav-link active"
               href="{{ route('checkout.index') }}">
                <span>🛒</span>
                Checkout
            </a>

            <a class="nav-link"
               href="{{ route('profil.show') }}">
                <span>👤</span>
                Profil
            </a>

        </nav>


        <form action="{{ route('logout') }}"
              method="POST"
              class="mt-auto">

            @csrf

            <button type="submit"
                    class="btn btn-outline-danger w-100 py-2">
                ⏻ Logout
            </button>

        </form>

    </aside>


    {{-- ================= AREA KANAN ================= --}}
    <div class="flex-grow-1 d-flex flex-column"
         style="min-width:0;">

        {{-- TOPBAR --}}
        <header class="topbar d-flex align-items-center px-3 px-lg-4 py-3">

            <div class="ms-auto d-flex align-items-center gap-3">

                <div class="text-end d-none d-sm-block">

                    <div class="fw-semibold">
                        {{ session('nama') ?? 'Pembeli' }}
                    </div>

                    <small class="text-secondary">
                        {{ session('email') }}
                    </small>

                </div>


                <div class="avatar d-flex align-items-center justify-content-center">

                    {{ strtoupper(
                        substr(
                            session('email') ?? 'P',
                            0,
                            1
                        )
                    ) }}

                </div>


                <div class="text-end border-start ps-3">

                    <div class="fs-5" id="jam">
                        --:--
                    </div>

                    <small class="text-secondary" id="tanggal">
                        -
                    </small>

                </div>

            </div>

        </header>


        {{-- ================= ISI ================= --}}
        <main class="p-3 p-lg-4">

            {{-- JUDUL --}}
            <div class="mb-4">

                <div class="page-title">
                    Checkout
                </div>

                <p class="text-secondary mb-0">
                    Pilih produk dan tentukan pembayaran pesanan kamu.
                </p>

            </div>


            {{-- ERROR --}}
            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>Terjadi kesalahan:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('checkout.store') }}"
                  method="POST">

                @csrf


                {{-- ================= PRODUK ================= --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h5 class="mb-1">
                                Pilih Produk
                            </h5>

                            <small class="text-secondary">
                                Masukkan jumlah produk yang ingin dipesan.
                            </small>
                        </div>

                    </div>


                    <div class="row g-3">

                        @forelse ($products as $product)

                            <div class="col-md-6 col-xl-4">

                                <div class="product-card p-3">

                                    <div class="d-flex justify-content-between align-items-start mb-2">

                                        <h5 class="mb-0">
                                            {{ $product->name }}
                                        </h5>

                                        <span class="badge bg-secondary">
                                            {{ $product->category }}
                                        </span>

                                    </div>


                                    <div class="price fw-semibold mb-2">

                                        Rp {{ number_format(
                                            $product->price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </div>


                                    <p class="text-secondary small mb-3">

                                        {{ $product->description
                                            ?? 'Tidak ada deskripsi.' }}

                                    </p>


                                    <label class="form-label small">
                                        Jumlah
                                    </label>

                                    <input
                                        type="number"
                                        name="products[{{ $product->id }}]"
                                        class="form-control"
                                        min="0"
                                        value="{{ old(
                                            'products.' . $product->id,
                                            0
                                        ) }}"
                                    >

                                </div>

                            </div>

                        @empty

                            <div class="col-12">

                                <div class="alert alert-info">
                                    Belum ada produk yang tersedia.
                                </div>

                            </div>

                        @endforelse

                    </div>

                </div>


                @if ($products->count() > 0)

                    {{-- ================= DETAIL CHECKOUT ================= --}}
                    <div class="checkout-box p-4">

                        <h5 class="mb-1">
                            Detail Pesanan
                        </h5>

                        <p class="text-secondary small mb-4">
                            Tentukan jenis pesanan dan metode pembayaran.
                        </p>


                        {{-- JENIS PESANAN --}}
                        <div class="mb-4">

                            <label for="jenis_pesanan"
                                   class="form-label">
                                Jenis Pesanan
                            </label>

                            <select
                                name="jenis_pesanan"
                                id="jenis_pesanan"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Jenis Pesanan --
                                </option>

                                <option value="Makan di tempat"
                                    {{ old('jenis_pesanan') == 'Makan di tempat'
                                        ? 'selected'
                                        : '' }}>
                                    Makan di tempat
                                </option>

                                <option value="Dibungkus"
                                    {{ old('jenis_pesanan') == 'Dibungkus'
                                        ? 'selected'
                                        : '' }}>
                                    Dibungkus
                                </option>

                            </select>

                        </div>


                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Metode Pembayaran
                            </label>


                            {{-- CASH --}}
                            <div class="payment-option">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="metode_pembayaran"
                                        id="cash"
                                        value="Cash"
                                        {{ old('metode_pembayaran') == 'Cash'
                                            ? 'checked'
                                            : '' }}
                                        required
                                    >

                                    <label
                                        class="form-check-label w-100"
                                        for="cash">

                                        <strong>
                                            Cash
                                        </strong>

                                        <div class="text-secondary small">
                                            Bayar langsung kepada kasir.
                                        </div>

                                    </label>

                                </div>

                            </div>


                            {{-- MIDTRANS --}}
                            <div class="payment-option">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="metode_pembayaran"
                                        id="midtrans"
                                        value="Midtrans"
                                        {{ old('metode_pembayaran') == 'Midtrans'
                                            ? 'checked'
                                            : '' }}
                                        required
                                    >

                                    <label
                                        class="form-check-label w-100"
                                        for="midtrans">

                                        <strong>
                                            Midtrans
                                        </strong>

                                        <div class="text-secondary small">
                                            Bayar secara online melalui halaman pembayaran Midtrans.
                                        </div>

                                    </label>

                                </div>

                            </div>

                        </div>


                        {{-- TOMBOL --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('pembeli.products') }}"
                               class="btn btn-outline-secondary">
                                Kembali
                            </a>

                            <button type="submit"
                                    class="btn btn-moza px-4">
                                Buat Pesanan
                            </button>

                        </div>

                    </div>

                @endif

            </form>

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

</body>
</html>
