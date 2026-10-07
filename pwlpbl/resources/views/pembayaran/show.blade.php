<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Pembayaran - Pizza Moza</title>

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

        .info-box {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
        }

        .info-item {
            padding: 16px;
            border-bottom: 1px solid var(--bs-border-color);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .label {
            color: #a89485;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .value {
            font-size: 16px;
            font-weight: 500;
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

        .btn-edit {
            background: #ffc107;
            color: #1c1512;
            border: none;
        }

        .btn-edit:hover {
            background: #ffca2c;
            color: #1c1512;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #f3e9e1;
        }

        .table th,
        .table td {
            border-color: var(--bs-border-color);
            padding: 12px 10px;
        }

        .table thead th {
            font-weight: 600;
        }

        .token-box {
            background: #1c1512;
            border: 1px solid var(--bs-border-color);
            border-radius: 8px;
            padding: 10px 12px;
            word-break: break-all;
            font-size: 13px;
            color: #a89485;
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

            {{-- JUDUL --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="mb-1">
                        Detail Pembayaran
                    </h1>

                    <p class="text-secondary mb-0">
                        Informasi pembayaran pesanan Pizza Moza
                    </p>

                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('pembayaran.index') }}"
                       class="btn btn-kembali">
                        Kembali
                    </a>

                    <a href="{{ route(
                        'pembayaran.edit',
                        $pembayaran->id_pesanan
                    ) }}"
                       class="btn btn-edit">
                        Edit
                    </a>

                </div>

            </div>


            {{-- ================= INFORMASI PEMBAYARAN ================= --}}
            <div class="info-box mb-4">

                <div class="p-3 border-bottom"
                     style="border-color: var(--bs-border-color) !important;">

                    <div class="section-title">
                        Informasi Pembayaran
                    </div>

                </div>


                <div class="row g-0">

                    {{-- ID PESANAN --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            ID Pesanan
                        </div>

                        <div class="value">
                            #{{ $pembayaran->id_pesanan }}
                        </div>

                    </div>


                    {{-- PEMBELI --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Pembeli
                        </div>

                        <div class="value">

                            {{ $pembayaran->pembeli->nama
                                ?? $pembayaran->pembeli->email
                                ?? '-' }}

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Email
                        </div>

                        <div class="value">

                            {{ $pembayaran->pembeli->email ?? '-' }}

                        </div>

                    </div>


                    {{-- TOTAL --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Total Pesanan
                        </div>

                        <div class="value">

                            Rp {{ number_format(
                                $pembayaran->total_harga,
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>


                    {{-- JENIS PESANAN --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Jenis Pesanan
                        </div>

                        <div class="value">

                            {{ $pembayaran->jenis_pesanan ?? '-' }}

                        </div>

                    </div>


                    {{-- METODE --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Metode Pembayaran
                        </div>

                        <div class="value">

                            {{ $pembayaran->metode_pembayaran ?? '-' }}

                        </div>

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Status Pembayaran
                        </div>

                        <div class="value">

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

                        </div>

                    </div>


                    {{-- DIBAYAR PADA --}}
                    <div class="col-md-6 info-item">

                        <div class="label">
                            Dibayar Pada
                        </div>

                        <div class="value">

                            @if ($pembayaran->dibayar_pada)

                                {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= DETAIL PRODUK ================= --}}
            <div class="info-box">

                <div class="p-3 border-bottom"
                     style="border-color: var(--bs-border-color) !important;">

                    <div class="section-title">
                        Detail Pesanan
                    </div>

                </div>


                <div class="p-3">

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>
                                        No
                                    </th>

                                    <th>
                                        Produk
                                    </th>

                                    <th>
                                        Harga
                                    </th>

                                    <th>
                                        Jumlah
                                    </th>

                                    <th>
                                        Subtotal
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse (
                                    $pembayaran->detailPesanans
                                    as $detail
                                )

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>

                                            {{ $detail->product->name
                                                ?? $detail->product->nama_produk
                                                ?? '-' }}

                                        </td>

                                        <td>

                                            Rp {{ number_format(
                                                $detail->harga,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                        <td>
                                            {{ $detail->jumlah }}
                                        </td>

                                        <td class="fw-semibold">

                                            Rp {{ number_format(
                                                $detail->subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5"
                                            class="text-center py-4 text-secondary">

                                            Detail produk tidak ditemukan.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- TOTAL --}}
                    <div class="d-flex justify-content-end mt-3">

                        <div class="text-end">

                            <div class="text-secondary">
                                Total Pembayaran
                            </div>

                            <div class="fs-4 fw-bold">

                                Rp {{ number_format(
                                    $pembayaran->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= SNAP TOKEN ================= --}}
            @if ($pembayaran->snap_token)

                <div class="info-box mt-4">

                    <div class="p-3">

                        <div class="label">
                            Snap Token Midtrans
                        </div>

                        <div class="token-box mt-2">
                            {{ $pembayaran->snap_token }}
                        </div>

                    </div>

                </div>

            @endif

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
