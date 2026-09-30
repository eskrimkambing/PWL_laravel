<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">Edit Pesanan</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('pesanans.update', $pesanan->id_pesanan) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>

                        <input type="text" name="nama_pelanggan" class="form-control"
                            value="{{ old('nama_pelanggan', $pesanan->nama_pelanggan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>

                        <input type="text" name="nama_produk" class="form-control"
                            value="{{ old('nama_produk', $pesanan->nama_produk) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>

                        <input type="number" name="jumlah" class="form-control"
                            value="{{ old('jumlah', $pesanan->jumlah) }}" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>

                        <input type="number" name="total_harga" class="form-control"
                            value="{{ old('total_harga', $pesanan->total_harga) }}" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select" required>

                            <option value="Menunggu" {{ $pesanan->status == 'Menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="Dibatalkan" {{ $pesanan->status == 'Dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                    <a href="{{ route('pesanans.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </div>

</body>

</html>
