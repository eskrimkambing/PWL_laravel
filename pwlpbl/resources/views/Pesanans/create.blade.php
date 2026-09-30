<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">Tambah Pesanan</h2>

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

                <form action="{{ route('pesanans.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control"
                            value="{{ old('nama_pelanggan') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}"
                            min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <input type="number" name="total_harga" class="form-control" value="{{ old('total_harga') }}"
                            min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan
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
