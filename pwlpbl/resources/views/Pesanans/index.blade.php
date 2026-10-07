<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pesanan Saya - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

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

        .order-card {
            background: #261c17;
            border: 1px solid var(--bs-border-color);
            border-radius: 14px;
        }

        .order-card:hover {
            background: #2d211b;
        }

        .price {
            color: #eadccf;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
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
    </style>
</head>

<body>

<div class="d-flex min-vh-100">

    {{-- SIDEBAR --}}
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
                    class="btn btn-outline-danger w-100">
                ⏻ Logout
            </button>

        </form>

    </aside>


    {{-- AREA KANAN --}}
    <div class="flex-grow-1 d-flex flex-column">

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
                        substr(session('email') ?? 'P', 0, 1)
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


        {{-- CONTENT --}}
        <main class="p-3 p-lg-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <div class="page-title">
                        Pesanan Saya
                    </div>

                    <p class="text-secondary mb-0">
                        Lihat dan pantau pesanan yang sudah kamu buat.
                    </p>

                </div>

                <a href="{{ route('checkout.index') }}"
                   class="btn btn-moza">
                    + Buat Pesanan
                </a>

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


            @forelse ($pesanans as $pesanan)

                <div class="order-card p-4 mb-3">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div>

                            <div class="fw-semibold fs-5">
                                Pesanan #{{ $pesanan->id_pesanan }}
                            </div>

                            <small class="text-secondary">

                                {{ $pesanan->created_at
                                    ? $pesanan->created_at->format('d M Y, H:i')
                                    : '-' }}

                            </small>

                        </div>


                        {{-- STATUS PESANAN --}}
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


                    <div class="row g-3 mb-3">

                        <div class="col-md-4">

                            <small class="text-secondary d-block">
                                Jenis Pesanan
                            </small>

                            <span>
                                {{ $pesanan->jenis_pesanan }}
                            </span>

                        </div>


                        <div class="col-md-4">

                            <small class="text-secondary d-block">
                                Pembayaran
                            </small>

                            <span>
                                {{ $pesanan->metode_pembayaran ?? '-' }}
                            </span>

                        </div>


                        <div class="col-md-4">

                            <small class="text-secondary d-block">
                                Status Pembayaran
                            </small>

                            @if ($pesanan->status_pembayaran === 'Dibayar')

                                <span class="badge bg-success">
                                    Dibayar
                                </span>

                            @elseif ($pesanan->status_pembayaran === 'Menunggu Pembayaran')

                                <span class="badge bg-warning text-dark">
                                    Menunggu Pembayaran
                                </span>

                            @elseif ($pesanan->status_pembayaran === 'Gagal')

                                <span class="badge bg-danger">
                                    Gagal
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ $pesanan->status_pembayaran ?? '-' }}
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="border-top pt-3 d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-secondary d-block">
                                Total Pesanan
                            </small>

                            <span class="price fw-bold fs-5">

                                Rp {{ number_format(
                                    $pesanan->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>


                        <a href="{{ route(
                            'pesanans.show',
                            $pesanan->id_pesanan
                        ) }}"
                           class="btn btn-outline-light">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            @empty

                <div class="order-card p-5 text-center">

                    <div class="fs-1 mb-3">
                        📋
                    </div>

                    <h5>
                        Belum Ada Pesanan
                    </h5>

                    <p class="text-secondary mb-4">
                        Kamu belum membuat pesanan.
                    </p>

                    <a href="{{ route('checkout.index') }}"
                       class="btn btn-moza">

                        Buat Pesanan

                    </a>

                </div>

            @endforelse

        </main>

    </div>

</div>


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
