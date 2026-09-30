<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-2">Menu Produk</h2>

        <p class="text-muted mb-4">
            Pilih produk yang ingin dipesan.
        </p>

        <form action="{{ route('checkout.store') }}" method="POST">

            @csrf

            <div class="row">

                @forelse($products as $product)
                    <div class="col-md-6 mb-4">

                        <div class="card shadow-sm h-100">

                            <div class="card-body">

                                <h5 class="card-title">
                                    {{ $product->name }}
                                </h5>

                                <p class="mb-1">
                                    Kategori: {{ $product->category }}
                                </p>

                                <p class="mb-1">
                                    Harga:
                                    <strong>
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </strong>
                                </p>

                                <p class="text-muted">
                                    {{ $product->description ?? 'Tidak ada deskripsi.' }}
                                </p>

                                <label class="form-label">
                                    Jumlah
                                </label>

                                <input type="number" name="products[{{ $product->id }}]" class="form-control"
                                    min="0" value="0">

                            </div>

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

            @if ($products->count() > 0)
                <div class="card mt-2 mb-5">

                    <div class="card-body">

                        <h5 class="mb-3">Jenis Pesanan</h5>

                        <select name="jenis_pesanan" class="form-select mb-3" required>

                            <option value="">
                                -- Pilih Jenis Pesanan --
                            </option>

                            <option value="Makan di tempat">
                                Makan di tempat
                            </option>

                            <option value="Dibungkus">
                                Dibungkus
                            </option>

                        </select>

                        <button type="submit" class="btn btn-primary">
                            Checkout
                        </button>

                    </div>

                </div>
            @endif

        </form>

    </div>

</body>

</html>
