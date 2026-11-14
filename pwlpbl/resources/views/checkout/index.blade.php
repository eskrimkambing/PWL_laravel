
@extends('layouts.pembeli')

@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-box {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
        padding: 20px !important;
        margin-bottom: 18px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .price {
        color: var(--moza-accent);
    }

    .checkout-back {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-body-color);
        text-decoration: none;
        border-radius: 50%;
        transition: .2s;
        flex-shrink: 0;
    }

    .checkout-back:hover {
        background: rgba(240, 179, 107, .2);
        color: #c8102e;
    }

    .form-control,
    .form-select {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
        border-radius: 10px;
    }

    .form-control:focus,
    .form-select:focus {
        background: var(--bs-body-bg);
        color: var(--bs-body-color);
        border-color: #f0b36b;
        box-shadow: 0 0 0 3px rgba(240, 179, 107, .2);
    }

    .form-control::placeholder {
        color: #8f7e73;
    }

    .form-select option {
        background: #261c17;
        color: #f3e9e1;
    }

    textarea.form-control {
        resize: vertical;
    }

    .choice-option {
        position: relative;
        background: var(--bs-body-bg);
        border: 1.5px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 11px 14px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: all .2s ease;
    }

    .choice-option:hover {
        border-color: #c9a27e;
    }

    .choice-option .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 5px;
        cursor: pointer;
    }

    .choice-option:has(input[type="radio"]:checked) {
        background: rgba(240, 179, 107, .15);
        border-color: #f0b36b;
        box-shadow: 0 0 0 3px rgba(240, 179, 107, .2);
    }

    html body main .choice-option .form-check,
    html body main .choice-option .form-check:has(input:checked),
    html body main .choice-option label:has(input:checked) {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    html body main .choice-option:has(input[type="radio"]:checked) strong {
        color: var(--moza-maroon) !important;
    }

    html body main .choice-option:has(input[type="radio"]:checked) .text-secondary,
    html body main .choice-option:has(input[type="radio"]:checked) small {
        color: rgba(106, 8, 1, .8) !important;
    }

    .choice-option .form-check-input:checked {
        background-color: #f0b36b;
        border-color: #f0b36b;
    }

    .product-thumb {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid var(--bs-border-color);
    }

    .cart-row {
        display: flex;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid var(--bs-border-color);
    }

    .cart-row:last-child {
        border-bottom: none;
    }

    .qty-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-box button {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #f0b36b;
        background: transparent;
        color: #f0b36b;
        font-size: 18px;
        font-weight: bold;
        line-height: 1;
        cursor: pointer;
    }

    .qty-box button:hover {
        background: rgba(240, 179, 107, .2);
    }

    .qty-num {
        min-width: 20px;
        text-align: center;
        font-weight: 700;
    }

    .remove-btn {
        border: none;
        background: none;
        color: #e57373;
        font-size: 13px;
        cursor: pointer;
        padding: 0;
    }

    .field-label {
        display: block;
        font-size: .85rem;
        font-weight: 600;
        color: #8f7e73;
        margin-bottom: 5px;
    }

    .field-label .req {
        color: #c8102e;
    }

    .field-input {
        padding: 10px 12px;
    }

    .phone-group {
        display: flex;
        align-items: center;
        border: 1px solid var(--bs-border-color);
        border-radius: 10px;
        background: var(--bs-body-bg);
        overflow: hidden;
    }

    .phone-group:focus-within {
        border-color: #f0b36b;
        box-shadow: 0 0 0 3px rgba(240, 179, 107, .2);
    }

    .phone-prefix {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 12px;
        height: 44px;
        border-right: 1px solid var(--bs-border-color);
        font-weight: 600;
        flex-shrink: 0;
    }

    .phone-group input {
        flex: 1;
        min-width: 0;
        height: 44px;
        border: none;
        outline: none;
        background: transparent;
        color: var(--bs-body-color);
        padding: 0 12px;
        font: inherit;
    }

    .phone-group input::placeholder {
        color: #8f7e73;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 7px;
        font-size: .95rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        margin-top: 8px;
        border-top: 1px solid var(--bs-border-color);
        font-size: 1.1rem;
        font-weight: 700;
    }

    #alamatBox {
        display: none;
    }

    @media (min-width: 992px) {
        .sticky-side {
            position: sticky;
            top: 90px;
        }
    }

    @media (max-width: 576px) {
        .checkout-box {
            padding: 15px !important;
        }

        .product-thumb {
            width: 65px;
            height: 65px;
        }
    }
</style>
@endpush

@section('content')

@php
    $fotoPizza = [
        'Extra Chicken' => 'extra-chicken.jpeg',
        'Cheese Volcano' => 'cheese-volcano.jpeg',
        'Ekstra Beef' => 'ekstra-beef.jpeg',
        'Original Mozza' => 'original-mozza.jpeg',
        'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
        'Long Pizza' => 'long-pizza.jpeg',
    ];

    $fotoCemilan = [
        'Tape Bakar Original' => 'tape-bakar-original.jpeg',
        'Singkong Keju' => 'singkong-keju.jpeg',
        'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
    ];

    $fotoDefault = asset('images/pizza.jpg');

    $fotoProduk = function ($product) use ($fotoPizza, $fotoCemilan, $fotoDefault) {
        if (!empty($product->image)) {
            if (\Illuminate\Support\Str::startsWith(
                $product->image,
                ['http://', 'https://']
            )) {
                return $product->image;
            }

            return asset(ltrim($product->image, '/'));
        }

        if (isset($fotoPizza[$product->nama])) {
            return asset('images/pizza/' . $fotoPizza[$product->nama]);
        }

        if (isset($fotoCemilan[$product->nama])) {
            return asset('images/cemilan/' . $fotoCemilan[$product->nama]);
        }

        return $fotoDefault;
    };

    $tambahanUkuran = [
        'Small' => -10000,
        'Medium' => 0,
        'Large' => 15000,
    ];

    $rows = [];

    $cartRaw = json_decode(request('cart', '[]'), true);

    if (!is_array($cartRaw) || count($cartRaw) === 0) {
        $cartRaw = request('product')
            ? [['id' => request('product'), 'qty' => 1]]
            : [];
    }

    foreach ($cartRaw as $row) {
        if (!is_array($row)) {
            continue;
        }

        $p = $products->firstWhere('id', $row['id'] ?? null);

        if (!$p) {
            continue;
        }

        $isPizza = strtolower(trim((string) $p->kategori)) === 'pizza';

        $size = null;

        if ($isPizza) {
            $size = isset($tambahanUkuran[$row['size'] ?? ''])
                ? $row['size']
                : 'Medium';
        }

        $rows[] = [
            'product' => $p,
            'isPizza' => $isPizza,
            'size' => $size,
            'qty' => max(1, (int) ($row['qty'] ?? 1)),
            'notes' => \Illuminate\Support\Str::limit(
                trim((string) ($row['notes'] ?? '')),
                200,
                ''
            ),
        ];
    }

    $jenisLama = old('jenis_pesanan', 'Makan di tempat');

    $namaLengkap = old(
        'nama_penerima',
        optional($pembeli ?? null)->nama
    );

    $namaParts = preg_split('/\s+/', trim((string) $namaLengkap), 2);

    $namaDepan = old('nama_depan', $namaParts[0] ?? '');
    $namaBelakang = old('nama_belakang', $namaParts[1] ?? '');

    $telpRaw = old(
        'no_telp',
        optional($pembeli ?? null)->no_telp
    );

    $telpTampil = preg_replace(
        '/^(62|0)/',
        '',
        preg_replace('/\D/', '', (string) $telpRaw)
    );

    $emailAwal = old(
        'email',
        optional(auth()->user())->email
            ?? optional($pembeli ?? null)->email
    );
@endphp

<div class="mb-4">
    <div class="d-flex align-items-center gap-3 mb-2">
        <a href="{{ url('/') }}#menu"
           class="checkout-back"
           aria-label="Kembali">
            <svg width="25" height="25"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M19 12H5"/>
                <path d="M12 19l-7-7 7-7"/>
            </svg>
        </a>

        <h2 class="fw-bold mb-0">Checkout</h2>
    </div>

    <p class="text-secondary mb-0">
        Periksa pesananmu, lalu lengkapi data dan pembayaran.
    </p>

    @if (empty($pembeli))
        <p class="small mb-0 mt-1">
            Tidak perlu daftar untuk memesan. Sudah punya akun?
            <a href="{{ route('login') }}" class="fw-semibold">Login</a>
        </p>
    @endif
</div>

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

@if (count($rows) === 0)

    <div class="checkout-box text-center">
        <p class="mb-3">
            Pesananmu masih kosong. Pilih menu favoritmu dulu ya.
        </p>

        <a href="{{ url('/') }}#menu" class="btn btn-moza px-4">
            Lihat Menu
        </a>
    </div>

@else

<form action="{{ route('checkout.store') }}"
      method="POST"
      id="checkoutForm">

    @csrf

    <div class="row g-3">

        <div class="col-lg-7">

            {{-- INFORMASI PESANAN --}}
            <div class="checkout-box">
                <div class="section-title">Informasi Pesanan</div>

                <label class="form-label text-secondary small">
                    Jenis Pesanan
                </label>

                @foreach ([
                    'Makan di tempat' => 'Dinikmati langsung di Pizza Moza.',
                    'Dibungkus' => 'Ambil sendiri di outlet.',
                    'Delivery' => 'Pesanan diantar ke alamat kamu.'
                ] as $value => $description)

                    <div class="choice-option">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="jenis_pesanan"
                                   id="jenis_{{ $loop->index }}"
                                   value="{{ $value }}"
                                   {{ $jenisLama == $value ? 'checked' : '' }}
                                   required>

                            <label class="form-check-label w-100"
                                   for="jenis_{{ $loop->index }}">
                                <strong>{{ $value }}</strong>
                                <div class="text-secondary small">
                                    {{ $description }}
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach

                <div id="alamatBox" class="mt-3">
                    <label for="alamat" class="field-label">
                        Alamat Pengiriman <span class="req">*</span>
                    </label>

                    <textarea name="alamat"
                              id="alamat"
                              class="form-control field-input"
                              rows="3"
                              maxlength="500"
                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
            </div>

            {{-- INFORMASI KONTAK --}}
            <div class="checkout-box">
                <div class="section-title">Informasi Kontak</div>

                <p class="text-secondary small mb-3">
                    Isi data di bawah ini supaya pesananmu bisa kami proses.
                </p>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nama_depan" class="field-label">
                            Nama Depan <span class="req">*</span>
                        </label>

                        <input type="text"
                               id="nama_depan"
                               name="nama_depan"
                               class="form-control field-input"
                               value="{{ $namaDepan }}"
                               placeholder="Nama depan kamu"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="nama_belakang" class="field-label">
                            Nama Belakang
                        </label>

                        <input type="text"
                               id="nama_belakang"
                               name="nama_belakang"
                               class="form-control field-input"
                               value="{{ $namaBelakang }}"
                               placeholder="Nama belakang kamu">
                    </div>

                    <div class="col-12">
                        <label for="telp_input" class="field-label">
                            Nomor HP <span class="req">*</span>
                        </label>

                        <div class="phone-group">
                            <span class="phone-prefix">
                                🇮🇩 +62
                            </span>

                            <input type="tel"
                                   id="telp_input"
                                   inputmode="numeric"
                                   value="{{ $telpTampil }}"
                                   placeholder="81212345678"
                                   required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="field-label">
                            Email <span class="req">*</span>
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control field-input"
                               value="{{ $emailAwal }}"
                               placeholder="contoh: pizzamoza@mail.com"
                               required>
                    </div>

                    <div class="col-12">
                        <label for="catatan" class="field-label">
                            Catatan Pesanan
                        </label>

                        <textarea name="catatan"
                                  id="catatan"
                                  class="form-control field-input"
                                  rows="2"
                                  maxlength="500"
                                  placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                    </div>

                    <input type="hidden"
                           name="nama_penerima"
                           id="nama_penerima"
                           value="{{ $namaLengkap }}">

                    <input type="hidden"
                           name="no_telp"
                           id="no_telp"
                           value="{{ $telpRaw }}">
                </div>
            </div>

            {{-- RINGKASAN PESANAN --}}
            <div class="checkout-box">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title mb-0">
                        Ringkasan Pesanan
                    </div>

                    <a href="{{ url('/') }}#menu"
                       class="btn btn-sm btn-outline-secondary">
                        + Tambah menu
                    </a>
                </div>

                <div id="cartRows">

                    @foreach ($rows as $i => $r)
                        @php
                            $p = $r['product'];
                        @endphp

                        <div class="cart-row"
                             data-id="{{ $p->id }}"
                             data-nama="{{ $p->nama }}"
                             data-image="{{ $fotoProduk($p) }}"
                             data-base="{{ (int) $p->price }}">

                            <img src="{{ $fotoProduk($p) }}"
                                 alt="{{ $p->nama }}"
                                 class="product-thumb"
                                 onerror="this.onerror=null; this.src='{{ $fotoDefault }}';">

                            <div class="flex-grow-1" style="min-width:0;">

                                <div class="d-flex justify-content-between gap-2">
                                    <strong>{{ $p->nama }}</strong>
                                    <span class="price fw-semibold line-total"></span>
                                </div>

                                <small class="text-secondary d-block mb-2 unit-text"></small>

                                @if ($r['isPizza'])
                                    <select name="items[{{ $i }}][size]"
                                            class="form-select form-select-sm size-select mb-2"
                                            style="max-width:200px;">

                                        @foreach ($tambahanUkuran as $nama => $tambah)
                                            <option value="{{ $nama }}"
                                                {{ $r['size'] === $nama ? 'selected' : '' }}>
                                                Ukuran {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                <input type="text"
                                       name="items[{{ $i }}][notes]"
                                       class="form-control form-control-sm notes-input mb-2"
                                       maxlength="200"
                                       placeholder="Catatan untuk menu ini (opsional)"
                                       value="{{ $r['notes'] }}">

                                <input type="hidden"
                                       name="items[{{ $i }}][product_id]"
                                       value="{{ $p->id }}">

                                <input type="hidden"
                                       name="items[{{ $i }}][qty]"
                                       class="qty-input"
                                       value="{{ $r['qty'] }}">

                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="remove-btn">
                                        Hapus
                                    </button>

                                    <div class="qty-box">
                                        <button type="button"
                                                class="btn-minus"
                                                aria-label="Kurangi">−</button>

                                        <span class="qty-num">{{ $r['qty'] }}</span>

                                        <button type="button"
                                                class="btn-plus"
                                                aria-label="Tambah">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-5">
            <div class="sticky-side">

                {{-- METODE PEMBAYARAN --}}
                <div class="checkout-box">
                    <div class="section-title">Metode Pembayaran</div>

                    <div class="choice-option">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="metode_pembayaran"
                                   id="cash"
                                   value="Cash"
                                   {{ old('metode_pembayaran', 'Cash') == 'Cash' ? 'checked' : '' }}
                                   required>

                            <label class="form-check-label w-100"
                                   for="cash">
                                <strong>Cash</strong>
                                <div class="text-secondary small">
                                    Bayar langsung kepada kasir.
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="choice-option mb-0">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="metode_pembayaran"
                                   id="midtrans"
                                   value="Midtrans"
                                   {{ old('metode_pembayaran') == 'Midtrans' ? 'checked' : '' }}
                                   required>

                            <label class="form-check-label w-100"
                                   for="midtrans">
                                <strong>Midtrans</strong>
                                <div class="text-secondary small">
                                    Bayar online melalui halaman pembayaran Midtrans.
                                </div>
                            </label>
                        </div>
                    </div>

                    <small class="text-secondary d-block mt-2">
                        Pembayaran online akan diproses setelah integrasi Midtrans diaktifkan.
                    </small>
                </div>

                {{-- RINGKASAN PEMBAYARAN --}}
                <div class="checkout-box">
                    <div class="section-title">Ringkasan Pembayaran</div>

                    <div class="summary-row">
                        <span class="text-secondary">
                            Subtotal (<span id="sumCount">0</span> item)
                        </span>

                        <span id="sumSubtotal">Rp 0</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span class="price" id="sumTotal">Rp 0</span>
                    </div>

                    <button type="submit"
                            class="btn btn-moza w-100 mt-3 py-2"
                            id="btnSubmit">
                        Check Out
                    </button>

                    <a href="{{ url('/') }}#menu"
                       class="btn btn-outline-secondary w-100 mt-2">
                        Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
</form>

<script>
(function () {

    const UKURAN = @json($tambahanUkuran);
    const CART_KEY = 'moza_cart';

    const rowsBox = document.getElementById('cartRows');
    const btnSubmit = document.getElementById('btnSubmit');
    const form = document.getElementById('checkoutForm');

    function rupiah(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function unitOf(row) {
        const sel = row.querySelector('.size-select');

        return parseInt(row.dataset.base) +
            (sel ? (UKURAN[sel.value] || 0) : 0);
    }

    function syncStorage() {
        const lines = [];
        const full = [];

        rowsBox.querySelectorAll('.cart-row').forEach(row => {

            const sel = row.querySelector('.size-select');
            const size = sel ? sel.value : null;

            const qty = parseInt(
                row.querySelector('.qty-input').value
            );

            const notes = row.querySelector('.notes-input').value.trim();

            lines.push({
                id: row.dataset.id,
                size: size,
                qty: qty,
                notes: notes
            });

            full.push({
                id: row.dataset.id,
                nama: row.dataset.nama,
                image: row.dataset.image,
                base: parseInt(row.dataset.base),
                size: size,
                notes: notes,
                qty: qty
            });
        });

        try {
            const url = new URL(window.location.href);

            url.searchParams.set('cart', JSON.stringify(lines));
            url.searchParams.delete('product');

            history.replaceState(null, '', url);
        } catch (e) {}

        try {
            localStorage.setItem(CART_KEY, JSON.stringify(full));
        } catch (e) {}
    }

    function recalc() {
        let total = 0;
        let count = 0;

        rowsBox.querySelectorAll('.cart-row').forEach(row => {

            const qty = parseInt(
                row.querySelector('.qty-input').value
            );

            const unit = unitOf(row);

            row.querySelector('.qty-num').textContent = qty;

            row.querySelector('.line-total').textContent =
                rupiah(unit * qty);

            row.querySelector('.unit-text').textContent =
                qty + ' x ' + rupiah(unit);

            total += unit * qty;
            count += qty;
        });

        document.getElementById('sumCount').textContent = count;

        document.getElementById('sumSubtotal').textContent =
            rupiah(total);

        document.getElementById('sumTotal').textContent =
            rupiah(total);

        btnSubmit.disabled = count === 0;

        syncStorage();
    }

    // Tombol jumlah dan hapus produk.
    rowsBox.addEventListener('click', function (e) {

        const row = e.target.closest('.cart-row');

        if (!row) return;

        const qtyInput = row.querySelector('.qty-input');

        if (e.target.closest('.btn-plus')) {

            const qty = parseInt(qtyInput.value);

            if (qty < 99) {
                qtyInput.value = qty + 1;
            }

            recalc();

        } else if (e.target.closest('.btn-minus')) {

            qtyInput.value = Math.max(
                1,
                parseInt(qtyInput.value) - 1
            );

            recalc();

        } else if (e.target.closest('.remove-btn')) {

            row.remove();

            if (rowsBox.querySelectorAll('.cart-row').length === 0) {
                try {
                    localStorage.removeItem(CART_KEY);
                } catch (err) {}

                window.location.href = "{{ url('/') }}#menu";
                return;
            }

            recalc();
        }
    });

    // Perubahan ukuran.
    rowsBox.addEventListener('change', recalc);

    // Catatan produk.
    rowsBox.addEventListener('input', function (e) {
        if (e.target.classList.contains('notes-input')) {
            syncStorage();
        }
    });

    // Sinkronisasi nama dan nomor telepon.
    const namaDepan = document.getElementById('nama_depan');
    const namaBelakang = document.getElementById('nama_belakang');
    const namaHidden = document.getElementById('nama_penerima');

    const telpInput = document.getElementById('telp_input');
    const telpHidden = document.getElementById('no_telp');

    function syncKontak() {

        namaHidden.value = (
            namaDepan.value.trim() + ' ' +
            namaBelakang.value.trim()
        ).trim();

        const digits = telpInput.value
            .replace(/\D/g, '')
            .replace(/^(62|0)/, '');

        telpHidden.value = digits ? '0' + digits : '';
    }

    [namaDepan, namaBelakang, telpInput].forEach(el => {
        el.addEventListener('input', syncKontak);
    });

    // Tampilkan alamat jika memilih Delivery.
    const jenisRadios = document.querySelectorAll(
        'input[name="jenis_pesanan"]'
    );

    const alamatBox = document.getElementById('alamatBox');
    const alamatInput = document.getElementById('alamat');

    function toggleAlamat() {

        const selected = document.querySelector(
            'input[name="jenis_pesanan"]:checked'
        );

        const delivery = selected && selected.value === 'Delivery';

        alamatBox.style.display = delivery ? 'block' : 'none';
        alamatInput.required = !!delivery;
    }

    jenisRadios.forEach(radio => {
        radio.addEventListener('change', toggleAlamat);
    });

    // Saat formulir dikirim.
    form.addEventListener('submit', function (e) {

        syncKontak();

        if (!namaHidden.value.trim() || !telpHidden.value.trim()) {
            e.preventDefault();
            alert('Lengkapi nama dan nomor HP terlebih dahulu.');
            return;
        }

        if (rowsBox.querySelectorAll('.cart-row').length === 0) {
            e.preventDefault();
            alert('Keranjang pesanan masih kosong.');
            return;
        }

        // Jangan hapus localStorage sebelum server berhasil menerima
        // pesanan agar keranjang tidak hilang jika validasi gagal.
    });

    syncKontak();
    toggleAlamat();
    recalc();

})();
</script>

@endif

@endsection

