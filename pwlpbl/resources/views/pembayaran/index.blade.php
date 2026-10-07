<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kelola Pembayaran - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
            --bs-tertiary-bg: #33261f;
            --bs-secondary-bg: #261c17;
            --bs-table-bg: transparent;
            --bs-table-color: #f3e9e1;
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

        .page-title {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .search-box {
            background: transparent;
            border: 1px solid var(--bs-border-color);
            color: #f3e9e1;
            border-radius: 8px;
        }

        .search-box:focus {
            background: transparent;
            color: #f3e9e1;
            border-color: #6b5648;
            box-shadow: none;
        }

        .search-box::placeholder {
            color: #a89485;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #f3e9e1;
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 1px solid var(--bs-border-color);
            color: #f3e9e1;
            font-weight: 600;
            padding: 14px 10px;
        }

        .table tbody td {
            border-bottom: 1px solid var(--bs-border-color);
            padding: 14px 10px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .btn-tambah {
            background: #0d6efd;
            color: #fff;
            border: none;
        }

        .btn-tambah:hover {
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

        .badge-metode {
            background: #3d2e26;
            color: #eadccf;
            font-weight: 500;
        }

        .content-wrapper {
            min-width: 0;
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

            {{-- Beranda --}}
            <a class="nav-link"
               href="{{ route('dashboard.admin') }}">
                <span>🏠</span>
                Beranda
            </a>

            {{-- Produk --}}
            <a class="nav-link"
               href="{{ route('products.index') }}">
                <span>🍕</span>
                Kelola Produk
            </a>

            {{-- Kategori --}}
            <a class="nav-link"
               href="{{ route('kategoris.index') }}">
                <span>📂</span>
                Kelola Kategori
            </a>

            {{-- Stok --}}
            <a class="nav-link"
               href="{{ route('stoks.index') }}">
                <span>📦</span>
                Kelola Stok
            </a>

            {{-- Pembayaran --}}
            <a class="nav-link active"
               href="{{ route('pembayaran.index') }}">
                <span>💳</span>
                Kelola Pembayaran
            </a>

            {{-- Pengguna --}}
            <a class="nav-link"
               href="{{ route('pengguna.index') }}">
                <span>👤</span>
                Kelola Pengguna
            </a>

        </nav>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">

            @csrf

            <button type="submit"
                    class="btn btn-outline-danger w-100 py-2">
                ⏻ Logout
            </button>

        </form>

    </aside>


    {{-- ================= AREA KANAN ================= --}}
    <div class="content-wrapper flex-grow-1 d-flex flex-column">

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

            {{-- Judul --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="page-title">
                        Kelola Pembayaran
                    </h1>

                    <p class="text-secondary mb-0">
                        Daftar pembayaran pesanan Pizza Moza
                    </p>

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route('dashboard.admin') }}"
                       class="btn btn-kembali">
                        Kembali
                    </a>

                    <a href="{{ route('pembayaran.create') }}"
                       class="btn btn-tambah">
                        + Tambah Pembayaran
                    </a>

                </div>

            </div>


            {{-- Pesan berhasil --}}
            @if (session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Pesan error --}}
            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- ================= SEARCH ================= --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div style="width: 500px;">

                    <input
                        type="text"
                        id="searchPembayaran"
                        class="form-control search-box"
                        placeholder="Cari pembayaran..."
                    >

                </div>

                <div class="text-secondary">
                    Total pembayaran:
                    <span id="totalPembayaran">
                        {{ $pembayarans->count() }}
                    </span>
                </div>

            </div>


            {{-- ================= TABEL ================= --}}
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th style="width: 60px;">
                                No
                            </th>

                            <th>
                                ID Pesanan
                            </th>

                            <th>
                                Pembeli
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Metode
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Dibayar Pada
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="tabelPembayaran">

                        @forelse ($pembayarans as $pembayaran)

                            <tr>

                                {{-- No --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- ID Pesanan --}}
                                <td>
                                    #{{ $pembayaran->id_pesanan }}
                                </td>


                                {{-- Pembeli --}}
                                <td>

                                    {{ $pembayaran->pembeli->nama
                                        ?? $pembayaran->pembeli->email
                                        ?? '-' }}

                                </td>


                                {{-- Total --}}
                                <td class="fw-semibold">

                                    Rp
                                    {{ number_format(
                                        $pembayaran->total_harga,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>


                                {{-- Metode --}}
                                <td>

                                    <span class="badge badge-metode">
                                        {{ $pembayaran->metode_pembayaran ?? '-' }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if ($pembayaran->status_pembayaran === 'Dibayar')

                                        <span class="badge bg-success">
                                            Dibayar
                                        </span>

                                    @elseif ($pembayaran->status_pembayaran === 'Gagal')

                                        <span class="badge bg-danger">
                                            Gagal
                                        </span>

                                    @elseif ($pembayaran->status_pembayaran === 'Menunggu Pembayaran')

                                        <span class="badge bg-warning text-dark">
                                            Menunggu Pembayaran
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Belum Dibayar
                                        </span>

                                    @endif

                                </td>


                                {{-- Dibayar Pada --}}
                                <td>

                                    @if ($pembayaran->dibayar_pada)

                                        {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td>

                                    <div class="d-flex gap-1">

                                        <a
                                            href="{{ route(
                                                'pembayaran.show',
                                                $pembayaran->id_pesanan
                                            ) }}"
                                            class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>


                                        <a
                                            href="{{ route(
                                                'pembayaran.edit',
                                                $pembayaran->id_pesanan
                                            ) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>


                                        <form
                                            action="{{ route(
                                                'pembayaran.destroy',
                                                $pembayaran->id_pesanan
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Yakin ingin menghapus data pembayaran ini?'
                                            )">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5 text-secondary">

                                    Belum ada data pembayaran.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    // Jam dan tanggal
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


    // Search pembayaran
    document
        .getElementById('searchPembayaran')
        .addEventListener('keyup', function () {

            const keyword = this.value.toLowerCase();

            const rows = document.querySelectorAll(
                '#tabelPembayaran tr'
            );

            rows.forEach(function (row) {

                const text = row.textContent.toLowerCase();

                if (text.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }

            });

        });

</script>

</body>
</html>
