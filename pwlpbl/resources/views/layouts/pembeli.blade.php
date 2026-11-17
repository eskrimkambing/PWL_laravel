<!DOCTYPE html>

<html lang="id" data-bs-theme="light">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard Pembeli') - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ===== PALET: dominan krem, aksen oranye & maroon =====

           Krem #FBE7A1 | Oranye #E8751A | Merah #D2392B | Maroon #8B1A10

        */

        :root,

        [data-bs-theme="light"],

        [data-bs-theme="dark"] {

            --moza-cream: #FBE7A1;

            --moza-cream-light: #FDF8EE;

            --moza-cream-card: #FFFBF0;

            --moza-cream-hover: #FDF0C4;

            --moza-cream-selected: #FCE3B8;

            --moza-orange: #E8751A;

            --moza-red: #D2392B;

            --moza-maroon: #8B1A10;

            --moza-ink: #2B1B14;
            --bs-body-font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', sans-serif;
            --font-heading: 'Poppins', system-ui, -apple-system, 'Segoe UI', sans-serif;

            --moza-accent-text: #fff;

            --bs-body-bg: var(--moza-cream-light);

            --bs-body-color: var(--moza-ink);

            --bs-secondary-color: rgba(43, 27, 20, 0.65);

            --bs-border-color: rgba(139, 26, 16, 0.12);

            --bs-tertiary-bg: #FDF0C4;

            --bs-secondary-bg: #FDF0C4;

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

        /* Teks abu-abu mengikuti tema (maroon lembut) */

        .text-secondary,

        .text-muted {

            color: var(--bs-secondary-color) !important;

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

        /* ===== TOMBOL FILTER KATEGORI (Semua, Pizza, Cemilan, Minuman) ===== */

        .btn-dark,

        .btn-outline-dark,

        .filter-btn,

        .kategori-btn,

        .btn-kategori,

        .btn-filter,

        .kategori-filter,

        .kategori-chip,

        .chip,

        .pill,

        .category-btn,

        .category-pill {

            background: var(--moza-cream) !important;

            color: var(--moza-maroon) !important;

            border: 1px solid rgba(139, 26, 16, 0.25) !important;

            border-radius: 12px;

            font-weight: 500;

            transition: all .2s ease;

        }

        .btn-dark:hover,

        .btn-outline-dark:hover,

        .filter-btn:hover,

        .kategori-btn:hover,

        .btn-kategori:hover,

        .btn-filter:hover,

        .kategori-filter:hover,

        .kategori-chip:hover,

        .chip:hover,

        .pill:hover,

        .category-btn:hover,

        .category-pill:hover {

            background: var(--moza-maroon) !important;

            color: #fff !important;

        }

        .btn-dark.active,

        .btn-outline-dark.active,

        .filter-btn.active,

        .kategori-btn.active,

        .btn-kategori.active,

        .btn-filter.active,

        .kategori-filter.active,

        .kategori-chip.active,

        .chip.active,

        .pill.active,

        .category-btn.active,

        .category-pill.active {

            background: var(--moza-orange) !important;

            border-color: var(--moza-orange) !important;

            color: #fff !important;

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

            box-shadow: 0 2px 8px rgba(139, 26, 16, 0.05);

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

        /* =====================================================

           KONTRAS ISI HALAMAN (checkout, pesanan, detail pesanan)

           Memakai "main" + !important supaya warna gelap lama

           di masing-masing halaman otomatis tertimpa.

           ===================================================== */

        /* --- 1. Kartu & kotak kosong: krem terang --- */

        main .card,

        main .empty-state,

        main .empty,

        main .kosong,

        main .no-data,

        main .pesanan-card,

        main .order-card,

        main .box,

        main .panel,

        main [class*="empty"],

        main [class*="kosong"] {

            background: var(--moza-cream-card) !important;

            color: var(--moza-maroon) !important;

            border: 1px solid var(--bs-border-color) !important;

            border-radius: 16px;

            box-shadow: 0 2px 8px rgba(139, 26, 16, 0.05);

            transition: all .2s ease;

        }

        /* Elemen di dalam kotak kosong tidak ikut berkotak (hindari garis ganda) */

        main [class*="empty"] [class*="empty"],

        main [class*="kosong"] [class*="kosong"] {

            background: transparent !important;

            border: 0 !important;

            box-shadow: none !important;

        }

        /* --- 2. Jaring pengaman: warna gelap lama yang tertulis langsung di tag --- */

        main [style*="#261c17"],

        main [style*="#2b1d17"],

        main [style*="#2d221d"],

        main [style*="#3d2e26"],

        main [style*="#33261f"],

        main [style*="#010101"],

        main [style*="#000"] {

            background: var(--moza-cream-card) !important;

            color: var(--moza-maroon) !important;

        }

        /* --- 3. Hover: krem lebih hangat + garis oranye --- */

        main .card:hover,

        main .card:focus-within,

        main .form-check:hover,

        main label:has(input[type="radio"]):hover,

        main label:has(input[type="checkbox"]):hover,

        main .metode-option:hover,

        main .metode-item:hover,

        main .payment-option:hover,

        main .payment-card:hover,

        main .option-card:hover,

        main .produk-card:hover,

        main .product-card:hover {

            background: var(--moza-cream-hover) !important;

            color: var(--moza-maroon) !important;

            border-color: rgba(232, 117, 26, 0.5) !important;

        }

        /* --- 4. Dipilih / aktif: hanya kotak terluar yang berwarna --- */

        main .card.active,

        main .card.selected,

        main .card.is-selected,

        main .card.checked,

        main .selected,

        main .is-selected,

        main .checked,

        main .is-active,

        main .form-check:has(input:checked),

        main label:has(input:checked),

        main .metode-option:has(input:checked),

        main .metode-item:has(input:checked),

        main .payment-option:has(input:checked),

        main .payment-card:has(input:checked),

        main .option-card:has(input:checked) {

            background: var(--moza-cream-selected) !important;

            border: 1px solid var(--moza-orange) !important;

            box-shadow: 0 0 0 2px rgba(232, 117, 26, 0.25) !important;

            color: var(--moza-maroon) !important;

            opacity: 1 !important;

        }

        /* --- 5. Isi kotak terpilih: tanpa kotak sendiri, teks maroon jelas --- */

        main .selected *:not(input),

        main .is-selected *:not(input),

        main .checked *:not(input),

        main .is-active *:not(input),

        main .form-check:has(input:checked) *:not(input),

        main label:has(input:checked) *:not(input),

        main .metode-option:has(input:checked) *:not(input),

        main .metode-item:has(input:checked) *:not(input),

        main .payment-option:has(input:checked) *:not(input),

        main .payment-card:has(input:checked) *:not(input),

        main .option-card:has(input:checked) *:not(input) {

            background: transparent !important;

            border: 0 !important;

            box-shadow: none !important;

            opacity: 1 !important;

            color: var(--moza-maroon) !important;

            text-shadow: none !important;

        }

        /* Keterangan kecil di kotak terpilih */

        main .selected small,

        main .selected p,

        main .is-selected small,

        main .is-selected p,

        main .checked small,

        main .checked p,

        main .form-check:has(input:checked) small,

        main .form-check:has(input:checked) p,

        main label:has(input:checked) small,

        main label:has(input:checked) p,

        main .metode-option:has(input:checked) small,

        main .metode-option:has(input:checked) p,

        main .payment-option:has(input:checked) small,

        main .payment-option:has(input:checked) p {

            color: rgba(139, 26, 16, 0.8) !important;

        }

        /* --- 6. Teks di dalam kartu selalu terbaca --- */

        main .card h1,

        main .card h2,

        main .card h3,

        main .card h4,

        main .card h5,

        main .card h6,

        main .card label,

        main [class*="empty"] h1,

        main [class*="empty"] h2,

        main [class*="empty"] h3,

        main [class*="empty"] h4,

        main [class*="empty"] h5,

        main [class*="empty"] h6,

        main [class*="kosong"] h1,

        main [class*="kosong"] h2,

        main [class*="kosong"] h3,

        main [class*="kosong"] h4,

        main [class*="kosong"] h5,

        main [class*="kosong"] h6 {

            color: var(--moza-maroon) !important;

        }

        main .card p,

        main .card small,

        main [class*="empty"] p,

        main [class*="kosong"] p {

            color: var(--bs-secondary-color) !important;

        }

        /* --- 7. Radio & checkbox oranye --- */

        .form-check-input:checked {

            background-color: var(--moza-orange);

            border-color: var(--moza-orange);

        }

        input[type="radio"],

        input[type="checkbox"] {

            accent-color: var(--moza-orange);

        }

        /* =====================================================

           FINAL A: teks keterangan selalu jelas

           (sengaja ditaruh paling bawah supaya menang)

           ===================================================== */

        html body main .card small,

        html body main .card p,

        html body main .card .text-secondary,

        html body main .card .text-muted,

        html body main .card [class*="desc"],

        html body main .card [class*="sub"],

        html body main label small,

        html body main label p,

        html body main label span:not(.badge) {

            color: rgba(139, 26, 16, 0.8) !important;

            opacity: 1 !important;

        }

        /* Judul opsi (Cash, Midtrans) tetap maroon pekat */

        html body main label strong,

        html body main label b,

        html body main label h1,

        html body main label h2,

        html body main label h3,

        html body main label h4,

        html body main label h5,

        html body main label h6,

        html body main label .fw-bold,

        html body main label .fw-semibold,

        html body main label [class*="title"],

        html body main label [class*="judul"] {

            color: var(--moza-maroon) !important;

            opacity: 1 !important;

        }

        /* =====================================================

           FINAL B: teks tabel selalu terbaca

           (nama produk, jumlah, harga, subtotal)

           ===================================================== */

        html body main .table {

            --bs-table-color: var(--moza-maroon) !important;

            --bs-table-bg: transparent !important;

            color: var(--moza-maroon) !important;

        }

        html body main .table tbody td,

        html body main .table tbody th,

        html body main .table tbody td *:not(.badge):not(.btn),

        html body main table tbody td,

        html body main table tbody td *:not(.badge):not(.btn) {

            color: var(--moza-maroon) !important;

            opacity: 1 !important;

        }

        /* Kolom harga & subtotal sedikit lebih tegas */

        html body main .table tbody td:nth-last-child(-n+2) {

            font-weight: 600;

        }

        /* Garis antar baris lebih jelas */

        html body main .table tbody td {

            border-bottom: 1px solid rgba(139, 26, 16, 0.15) !important;

            background: transparent !important;

        }

        /* Baris tabel saat di-hover */

        html body main .table tbody tr:hover td {

            background: rgba(247, 217, 145, 0.35) !important;

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
        .btn,
        .card-title,
        .table thead th {
            font-family: var(--font-heading);
        }

        .table td,
        .badge {
            font-variant-numeric: lining-nums tabular-nums;
        }
    </style>

    @stack('styles')

</head>

<body>

    @php

        // Data pembeli yang sedang login (nama & foto selalu terbaru dari database)

        $pembeliLogin = \App\Models\Pembeli::find(session('user_id'));

        $emailPembeli = $pembeliLogin->email ?? session('email');

        $namaPembeli = $pembeliLogin->nama ?? 'Pembeli';

        $fotoPembeli = $pembeliLogin->foto ?? null;

    @endphp

    <div class="d-flex min-vh-100">

        {{-- ========== AREA KANAN: TOPBAR + ISI TENGAH ========== --}}

        <div class="w-100 flex-grow-1 d-flex flex-column" style="min-width:0;">

            <header class="topbar d-flex align-items-center gap-3 px-3 px-lg-4 py-3">

                <div class="ms-auto d-flex align-items-center gap-3">

                    {{-- NAMA & EMAIL --}}

                    <div class="text-end d-none d-sm-block">

                        <div class="fw-semibold">{{ $namaPembeli }}</div>

                        <small class="text-secondary">{{ $emailPembeli }}</small>

                    </div>

                    {{-- FOTO / AVATAR --}}

                    @if ($fotoPembeli)
                        <img src="{{ $fotoPembeli }}" alt="Foto {{ $namaPembeli }}" class="avatar-img">
                    @else
                        <div class="avatar d-flex align-items-center justify-content-center">

                            {{ strtoupper(substr($pembeliLogin->nama ?? ($emailPembeli ?? 'P'), 0, 1)) }}

                        </div>
                    @endif

                    {{-- LOGOUT --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2 fw-semibold">
                            ⏻ <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>

                </div>

            </header>

            {{-- ISI HALAMAN MASUK DI SINI --}}

            <main class="p-3 p-lg-4">

                @yield('content')

            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>
