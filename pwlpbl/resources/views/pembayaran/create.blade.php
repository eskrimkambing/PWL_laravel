<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tambah Pembayaran - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
            --bs-secondary-bg: #261c17;
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
            background: #eadccf;
            color: #2a1e17;
            font-weight: bold;
        }

        .form-box {
            max-width: 750px;
        }

        .form-control,
        .form-select {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            color: #f3e9e1;
        }

        .form-control:focus,
        .form-select:focus {
            background: #261c17;
            color: #f3e9e1;
            border-color: #6b5648;
            box-shadow: none;
        }

        .form-select option {
            background: #261c17;
            color: #f3e9e1;
        }

        .btn-simpan {
            background: #0d6efd;
            color: #fff;
            border: none;
        }

        .btn-simpan:hover {
            background: #0b5ed7;
            color: #fff;
        }

        .btn-kembali {
            background: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-kembali:hover {
            background: #5c636a;
            color: #fff;
        }

        .form-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            background: transparent;
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
                        ADMIN PANEL
                    </small>
                </div>

            </div>

        </div>

        <nav class="nav flex-column">

            <a class="nav-link"
               href="{{ route('dashboard.admin') }}">
                <span>🏠</span>
                Beranda
            </a>

            <a class="nav-link"
               href="{{ route('products.index') }}">
                <span>🍕</span>
                Kelola Produk
            </a>

            <a class="nav-link"
               href="{{ route('kategoris.index') }}">
                <span>📂</span>
                Kelola Kategori
            </a>

            <a class="nav-link"
               href="{{ route('stoks.index') }}">
                <span>📦</span>
                Kelola Stok
            </a>

            <a class="nav-link active"
               href="{{ route('pembayaran.index') }}">
                <span>💳</span>
                Kelola Pembayaran
            </a>

            <a class="nav-link"
               href="{{ route('pengguna.index') }}">
                <span>👤</span>
                Kelola Pengguna
            </a>

        </nav>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">

            @csrf

            <button type="submit"
                    class="btn btn-outline-danger w-100 py-2">
                ⏻ Logout
            </button>

        </form>

    </aside>


    {{-- ================= AREA KANAN ================= --}}
    <div class="flex-grow-1 d-flex flex-column">

        {{-- TOPBAR --}}
        <header class="topbar d-flex align-items-center px-4 py-3">

            <div class="ms-auto d-flex align-items-center gap-3">

                <div class="text-end">

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
        <main class="p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="mb-1">
                        Tambah Pembayaran
                    </h1>

                    <p class="text-secondary mb-0">
                        Tambahkan data pembayaran pesanan Pizza Moza
                    </p>

                </div>

                <a href="{{ route('pembayaran.index') }}"
                   class="btn btn-kembali">
                    Kembali
                </a>

            </div>


            {{-- ERROR VALIDASI --}}
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


            {{-- FORM --}}
            <div class="form-box">

                <div class="form-card p-4">

                    <form action="{{ route('pembayaran.store') }}"
                          method="POST">

                        @csrf


                        {{-- PESANAN --}}
                        <div class="mb-4">

                            <label for="pesanan_id"
                                   class="form-label">
                                Pesanan
                            </label>

                            <select
                                name="pesanan_id"
                                id="pesanan_id"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Pesanan --
                                </option>

                                @forelse ($pesanans as $pesanan)

                                    <option
                                        value="{{ $pesanan->id_pesanan }}"
                                        {{ old('pesanan_id') == $pesanan->id_pesanan ? 'selected' : '' }}>

                                        #{{ $pesanan->id_pesanan }}
                                        -
                                        {{ $pesanan->pembeli->nama
                                            ?? $pesanan->pembeli->email
                                            ?? 'Pembeli' }}

                                        -
                                        Rp {{ number_format(
                                            $pesanan->total_harga,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </option>

                                @empty

                                    <option value="" disabled>
                                        Tidak ada pesanan yang tersedia
                                    </option>

                                @endforelse

                            </select>

                            <small class="text-secondary">
                                Pilih pesanan yang ingin dicatat pembayarannya.
                            </small>

                        </div>


                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-4">

                            <label for="metode_pembayaran"
                                   class="form-label">
                                Metode Pembayaran
                            </label>

                            <select
                                name="metode_pembayaran"
                                id="metode_pembayaran"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Metode --
                                </option>

                                <option value="Cash"
                                    {{ old('metode_pembayaran') === 'Cash' ? 'selected' : '' }}>
                                    Cash
                                </option>

                                <option value="Midtrans"
                                    {{ old('metode_pembayaran') === 'Midtrans' ? 'selected' : '' }}>
                                    Midtrans
                                </option>

                            </select>

                        </div>


                        {{-- STATUS PEMBAYARAN --}}
                        <div class="mb-4">

                            <label for="status_pembayaran"
                                   class="form-label">
                                Status Pembayaran
                            </label>

                            <select
                                name="status_pembayaran"
                                id="status_pembayaran"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="Belum Dibayar"
                                    {{ old('status_pembayaran') === 'Belum Dibayar' ? 'selected' : '' }}>
                                    Belum Dibayar
                                </option>

                                <option value="Menunggu Pembayaran"
                                    {{ old('status_pembayaran') === 'Menunggu Pembayaran' ? 'selected' : '' }}>
                                    Menunggu Pembayaran
                                </option>

                                <option value="Dibayar"
                                    {{ old('status_pembayaran') === 'Dibayar' ? 'selected' : '' }}>
                                    Dibayar
                                </option>

                                <option value="Gagal"
                                    {{ old('status_pembayaran') === 'Gagal' ? 'selected' : '' }}>
                                    Gagal
                                </option>

                            </select>

                        </div>


                        {{-- BUTTON --}}
                        <div class="d-flex gap-2">

                            <a href="{{ route('pembayaran.index') }}"
                               class="btn btn-kembali">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-simpan">
                                Simpan Pembayaran
                            </button>

                        </div>

                    </form>

                </div>

            </div>

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
