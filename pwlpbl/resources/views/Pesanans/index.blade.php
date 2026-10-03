<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <div class="mb-4">
            <h2>Data Pesanan</h2>
            <p class="text-muted">
                Daftar pesanan yang masuk dari pembeli
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                                <th>Jenis Pesanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pesanans as $pesanan)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $pesanan->pembeli->email ?? 'Data pembeli tidak ditemukan' }}
                                    </td>

                                    <td>
                                        @forelse($pesanan->detailPesanans as $detail)
                                            <div class="mb-1">
                                                <strong>{{ $detail->product->name ?? 'Produk tidak ditemukan' }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $detail->jumlah }} ×
                                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        @empty
                                            <span class="text-muted">
                                                Tidak ada produk
                                            </span>
                                        @endforelse
                                    </td>

                                    <td>
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $pesanan->jenis_pesanan }}
                                    </td>

                                    <td>

                                        @if ($pesanan->status == 'Menunggu')
                                            <span class="badge bg-warning text-dark">
                                                Menunggu
                                            </span>
                                        @elseif($pesanan->status == 'Diproses')
                                            <span class="badge bg-info">
                                                Diproses
                                            </span>
                                        @elseif($pesanan->status == 'Selesai')
                                            <span class="badge bg-success">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Dibatalkan
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{ route('pesanans.show', $pesanan->id_pesanan) }}"
                                            class="btn btn-primary btn-sm">
                                            Detail
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center">
                                        Belum ada pesanan dari pembeli.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
