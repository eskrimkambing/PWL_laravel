<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detail Pesanan - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root,
        [data-bs-theme="dark"] {
            --bs-body-bg: #1c1512;
            --bs-body-color: #f3e9e1;
            --bs-secondary-color: #a89485;
            --bs-border-color: rgba(255, 255, 255, 0.08);
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

        .content-card {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
        }

        .info-box {
            background: #1c1512;
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            padding: 14px;
        }

        .info-label {
            color: var(--bs-secondary-color);
            font-size: 13px;
            margin-bottom: 4px;
        }

        .total-box {
            border-top: 1px solid var(--bs-border-color);
        }

        .price {
            color: #eadccf;
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

        .page-title {
            font-size: 28px;
            font-weight: 600;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #f3e9e1;
            --bs-table-border-color: var(--bs-border-color);
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

            <a class="nav-link active"
               href="{{ route('pesanans.index') }}">
                <span>📋</span>
                Pesanan Saya
            </a>

            <a class="nav-link"
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
                    Detail Pesanan
                </div>

                <p class="text-secondary mb-0">
                    Informasi lengkap mengenai pesanan kamu.
                </p>

            </div>


            {{-- SUCCESS --}}
            @if (session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROR --}}
            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- ================= INFORMASI PESANAN ================= --}}
            <div class="content-card p-4 mb-4">

                <div class="d-flex justify-content-between align-items-start mb-4">

                    <div>

                        <h5 class="mb-1">
                            Pesanan #{{ $pesanan->id_pesanan }}
                        </h5>

                        <small class="text-secondary">
                            {{ $pesanan->created_at
                                ? $pesanan->created_at->format('d M Y, H:i')
                                : '-' }}
                        </small>

                    </div>


                    @if ($pesanan->status === 'Menunggu')

                        <span class="badge bg-warning text-dark">
                            Menunggu
                        </span>

                    @elseif ($pesanan->status === 'Diproses')

                        <span class="badge bg-info text-dark">
                            Diproses
                        </span>

                    @elseif ($pesanan->status === 'Selesai')

                        <span class="badge bg-success">
                            Selesai
                        </span>

                    @elseif ($pesanan->status === 'Dibatalkan')

                        <span class="badge bg-danger">
                            Dibatalkan
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            {{ $pesanan->status }}
                        </span>

                    @endif

                </div>


                {{-- INFORMASI --}}
                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="info-box">

                            <div class="info-label">
                                Jenis Pesanan
                            </div>

                            <div class="fw-semibold">
                                {{ $pesanan->jenis_pesanan }}
                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="info-box">

                            <div class="info-label">
                                Metode Pembayaran
                            </div>

                            <div class="fw-semibold">
                                {{ $pesanan->metode_pembayaran ?? '-' }}
                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="info-box">

                            <div class="info-label">
                                Status Pembayaran
                            </div>

                            <div>

                                @if ($pesanan->status_pembayaran === 'Dibayar')

                                    <span class="badge bg-success">
                                        Dibayar
                                    </span>

                                @elseif ($pesanan->status_pembayaran === 'Gagal')

                                    <span class="badge bg-danger">
                                        Gagal
                                    </span>

                                @elseif ($pesanan->status_pembayaran === 'Menunggu Pembayaran')

                                    <span class="badge bg-warning text-dark">
                                        Menunggu Pembayaran
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ $pesanan->status_pembayaran ?? '-' }}
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= DETAIL PRODUK ================= --}}
            <div class="content-card p-4 mb-4">

                <h5 class="mb-3">
                    Produk Pesanan
                </h5>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Produk</th>
                                <th class="text-center">
                                    Jumlah
                                </th>
                                <th class="text-end">
                                    Harga
                                </th>
                                <th class="text-end">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($pesanan->detailPesanans as $detail)

                                <tr>

                                    <td>

                                        {{ $detail->product->name
                                            ?? 'Produk tidak ditemukan' }}

                                    </td>

                                    <td class="text-center">
                                        {{ $detail->jumlah }}
                                    </td>

                                    <td class="text-end">

                                        Rp {{ number_format(
                                            $detail->harga,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                    <td class="text-end price fw-semibold">

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

                                    <td colspan="4"
                                        class="text-center text-secondary py-4">

                                        Tidak ada detail produk.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="total-box mt-3 pt-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-secondary">
                            Total Pesanan
                        </span>

                        <span class="fs-4 fw-bold price">

                            Rp {{ number_format(
                                $pesanan->total_harga,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- ================= PEMBAYARAN ================= --}}
            @if ($pesanan->metode_pembayaran === 'Midtrans'
                && $pesanan->status_pembayaran !== 'Dibayar')

                <div class="content-card p-4 mb-4">

                    <h5 class="mb-1">
                        Pembayaran
                    </h5>

                    <p class="text-secondary small mb-3">
                        Lanjutkan pembayaran untuk menyelesaikan pesanan.
                    </p>

                    <form
                        action="{{ route(
                            'pesanans.bayar',
                            $pesanan->id_pesanan
                        ) }}"
                        method="POST">

                        @csrf

                        <button type="submit"
                                class="btn btn-moza px-4">
                            💳 Bayar Sekarang
                        </button>

                    </form>

                </div>

            @endif


            {{-- ================= INFORMASI CASH ================= --}}
            @if ($pesanan->metode_pembayaran === 'Cash')

                <div class="content-card p-4 mb-4">

                    <h5 class="mb-1">
                        Pembayaran Cash
                    </h5>

                    <p class="text-secondary mb-0">
                        Silakan lakukan pembayaran langsung kepada kasir.
                    </p>

                </div>

            @endif


            {{-- ================= TOMBOL ================= --}}
            <div class="d-flex gap-2">

                <a href="{{ route('pesanans.index') }}"
                   class="btn btn-outline-secondary">

                    ← Kembali ke Pesanan

                </a>

                <a href="{{ route('checkout.index') }}"
                   class="btn btn-moza">

                    + Buat Pesanan Lagi

                </a>

            </div>

        </main>

    </div>

</div>


{{-- MIDTRANS SNAP --}}
@if (
    session('snap_token')
    && $pesanan->metode_pembayaran === 'Midtrans'
    && $pesanan->status_pembayaran !== 'Dibayar'
)

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const snapToken = @json(session('snap_token'));

            if (snapToken) {

                window.snap.pay(snapToken, {

                    onSuccess: function () {
                        window.location.reload();
                    },

                    onPending: function () {
                        window.location.reload();
                    },

                    onError: function () {
                        alert('Pembayaran gagal.');
                    },

                    onClose: function () {
                        console.log('Halaman pembayaran ditutup.');
                    }

                });

            }

        });

    </script>

@endif


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
