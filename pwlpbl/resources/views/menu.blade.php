
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Pizza Moza</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 7%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            color: #d62828;
        }

        .logo span {
            color: #333;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            margin-left: 20px;
        }

        .navbar a:hover {
            color: #d62828;
        }

        .page-header {
            padding: 45px 7% 20px;
            text-align: center;
        }

        .page-header h1 {
            font-size: 34px;
            font-weight: 800;
        }

        .page-header p {
            color: #777;
            margin-top: 8px;
        }

        .menu-section {
            padding: 25px 7% 70px;
        }

        .search-box {
            width: 100%;
            max-width: 500px;
            margin: 0 auto 25px;
            display: block;
            padding: 13px 18px;
            border: 1px solid #ddd;
            border-radius: 30px;
            font-family: inherit;
            outline: none;
        }

        .categories {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .category-btn {
            border: 1px solid #d62828;
            background: white;
            color: #d62828;
            padding: 9px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
        }

        .category-btn.active,
        .category-btn:hover {
            background: #d62828;
            color: white;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
        }

        .product-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,.09);
            background: white;
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 18px;
        }

        .product-info h3 {
            font-size: 18px;
            margin-bottom: 7px;
        }

        .product-info p {
            color: #777;
            font-size: 13px;
            min-height: 40px;
            margin-bottom: 10px;
        }

        .price {
            color: #d62828;
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .order-btn {
            width: 100%;
            border: none;
            background: #d62828;
            color: white;
            padding: 11px;
            border-radius: 25px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 700;
        }

        .order-btn:hover {
            background: #a71919;
        }

        .empty {
            text-align: center;
            color: #777;
            grid-column: 1/-1;
            padding: 30px;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 200;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .modal-content {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 25px;
            border-radius: 15px;
        }

        .modal-content h2 {
            margin-bottom: 15px;
        }

        .modal-content label {
            display: block;
            font-weight: 600;
            margin: 12px 0 6px;
        }

        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-actions button {
            flex: 1;
            padding: 11px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
        }

        .cancel-btn {
            background: #eee;
        }

        .add-btn {
            background: #d62828;
            color: white;
        }

        /* KERANJANG */
        .cart-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #d62828;
            color: white;
            padding: 14px 22px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            z-index: 150;
            font-family: inherit;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,.2);
        }

        .cart-panel {
            display: none;
            position: fixed;
            bottom: 85px;
            right: 25px;
            width: 340px;
            max-width: calc(100% - 30px);
            max-height: 400px;
            overflow-y: auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0,0,0,.2);
            z-index: 150;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
            font-size: 13px;
        }

        .cart-item button {
            margin-top: 5px;
            border: none;
            background: #d62828;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-btn {
            width: 100%;
            background: #d62828;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 700;
        }

        footer {
            background: #202020;
            color: white;
            text-align: center;
            padding: 30px;
        }

        @media(max-width: 600px) {
            .navbar {
                flex-direction: column;
                gap: 12px;
            }

            .navbar a {
                margin: 0 7px;
                font-size: 13px;
            }

            .page-header h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="logo">PIZZA <span>MOZA</span></div>

    <div>
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('login') }}">Login</a>
    </div>
</nav>

<header class="page-header">
    <h1>Menu Pizza Moza</h1>
    <p>Pilih pizza favoritmu dan nikmati kelezatannya.</p>
</header>

<section class="menu-section">

    <input type="text" id="searchInput" class="search-box"
           placeholder="Cari menu pizza...">

    <div class="categories">
        <button class="category-btn active" onclick="filterCategory('all', this)">
            Semua
        </button>

        @foreach(($products ?? collect())->pluck('kategori.nama_kategori')->filter()->unique() as $kategori)
            <button class="category-btn"
                    onclick="filterCategory('{{ addslashes($kategori) }}', this)">
                {{ $kategori }}
            </button>
        @endforeach
    </div>

    <div class="products" id="productList">

        @forelse($products as $product)

            @php
                $nama = $product->name ?? $product->nama_produk ?? 'Pizza';
                $harga = $product->price ?? $product->harga ?? 0;
                $gambar = $product->image ?? $product->gambar ?? $product->foto ?? null;
                $kategori = $product->kategori->nama_kategori ?? '';
                $deskripsi = $product->description ?? $product->deskripsi ?? 'Pizza lezat dengan topping pilihan.';
            @endphp

            <div class="product-card"
                 data-name="{{ strtolower($nama) }}"
                 data-category="{{ strtolower($kategori) }}">

                @if($gambar)
                    <img src="{{ asset('storage/' . $gambar) }}" alt="{{ $nama }}">
                @else
                    <img src="{{ asset('images/pizza.jpg') }}" alt="{{ $nama }}">
                @endif

                <div class="product-info">
                    <h3>{{ $nama }}</h3>

                    <p>{{ $deskripsi }}</p>

                    <div class="price">
                        Rp {{ number_format($harga, 0, ',', '.') }}
                    </div>

                    <button class="order-btn"
                        onclick="openModal(
                            {{ $product->id }},
                            {{ json_encode($nama) }},
                            {{ $harga }}
                        )">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

        @empty

            <div class="empty">Belum ada produk tersedia.</div>

        @endforelse

    </div>
</section>

<!-- MODAL PILIH PESANAN -->
<div class="modal" id="orderModal">
    <div class="modal-content">

        <h2 id="modalProductName">Pilih Pesanan</h2>

        <label>Ukuran Pizza</label>
        <select id="pizzaSize">
            <option value="Regular">Regular</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select>

        <label>Jumlah</label>
        <select id="pizzaQty">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        <label>Catatan Pesanan</label>
        <textarea id="pizzaNotes" rows="3"
                  placeholder="Contoh: Jangan terlalu pedas..."></textarea>

        <div class="modal-actions">
            <button class="cancel-btn" onclick="closeModal()">Batal</button>
            <button class="add-btn" onclick="addToCart()">Tambah Keranjang</button>
        </div>

    </div>
</div>

<!-- KERANJANG -->
<button class="cart-button" onclick="toggleCart()">
    🛒 Keranjang (<span id="cartCount">0</span>)
</button>

<div class="cart-panel" id="cartPanel">
    <h3>Keranjang Saya</h3>

    <div id="cartItems"></div>

    <button class="checkout-btn" onclick="checkout()">
        Checkout
    </button>
</div>

<footer>
    <h3>PIZZA MOZA</h3>
    <p>Pizza Lezat, Momen Lebih Nikmat.</p>
    <p style="margin-top:10px;">
        &copy; {{ date('Y') }} Pizza Moza. All Rights Reserved.
    </p>
</footer>

<script>
    let selectedProduct = null;

    let cart = JSON.parse(localStorage.getItem('moza_cart') || '[]');

    function openModal(id, name, price) {
        selectedProduct = {id, name, price};

        document.getElementById('modalProductName').textContent = name;
        document.getElementById('pizzaSize').value = 'Regular';
        document.getElementById('pizzaQty').value = '1';
        document.getElementById('pizzaNotes').value = '';

        document.getElementById('orderModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('orderModal').style.display = 'none';
    }

    function addToCart() {
        if (!selectedProduct) return;

        const size = document.getElementById('pizzaSize').value;
        const qty = parseInt(document.getElementById('pizzaQty').value);
        const notes = document.getElementById('pizzaNotes').value;

        const existing = cart.find(item =>
            item.id == selectedProduct.id &&
            item.size == size &&
            item.notes == notes
        );

        if (existing) {
            existing.qty += qty;
        } else {
            cart.push({
                id: selectedProduct.id,
                name: selectedProduct.name,
                price: selectedProduct.price,
                size: size,
                qty: qty,
                notes: notes
            });
        }

        saveCart();
        closeModal();

        alert('Produk berhasil ditambahkan ke keranjang!');
    }

    function saveCart() {
        localStorage.setItem('moza_cart', JSON.stringify(cart));
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItems');
        const count = cart.reduce((total, item) => total + Number(item.qty), 0);

        document.getElementById('cartCount').textContent = count;

        if (cart.length === 0) {
            container.innerHTML = '<p style="margin-top:15px;color:#777;">Keranjang masih kosong.</p>';
            return;
        }

        container.innerHTML = cart.map((item, index) => `
            <div class="cart-item">
                <strong>${escapeHTML(item.name)}</strong><br>
                Ukuran: ${escapeHTML(item.size)}<br>
                Jumlah: ${item.qty}<br>
                ${item.notes ? 'Catatan: ' + escapeHTML(item.notes) + '<br>' : ''}
                <button onclick="removeItem(${index})">Hapus</button>
            </div>
        `).join('');
    }

    function escapeHTML(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);
    }

    function removeItem(index) {
        cart.splice(index, 1);
        saveCart();
    }

    function toggleCart() {
        const panel = document.getElementById('cartPanel');

        panel.style.display =
            panel.style.display === 'block' ? 'none' : 'block';
    }

    function checkout() {
        if (cart.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        const url = new URL("{{ route('checkout.index') }}", window.location.origin);

        url.searchParams.set('cart', JSON.stringify(
            cart.map(item => ({
                id: item.id,
                size: item.size,
                qty: item.qty,
                notes: item.notes
            }))
        ));

        window.location.href = url.toString();
    }

    function filterCategory(category, button) {
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        button.classList.add('active');

        document.querySelectorAll('.product-card').forEach(card => {
            const productCategory = card.dataset.category;

            card.style.display =
                category === 'all' ||
                productCategory === category.toLowerCase()
                    ? ''
                    : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('.product-card').forEach(card => {
            const name = card.dataset.name;

            card.style.display = name.includes(keyword) ? '' : 'none';
        });
    });

    document.getElementById('orderModal').addEventListener('click', function(event) {
        if (event.target === this) closeModal();
    });

    renderCart();
</script>

</body>
</html>

