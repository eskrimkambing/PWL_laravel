<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">Detail Pesanan</h2>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="mb-3">
                    <strong>Nama Pelanggan</strong>
                    <p class="mb-0">
                        {{ $pesanan->user->name ?? 'Data pengguna tidak ditemukan' }}
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Jenis Pesanan</strong>
                    <p class="mb-0">
                        {{ $pesanan->jenis_pesanan }}
                    </p>
                </div>

                <hr>

                <h5 class="mb-3">Daftar Produk</h5>

                <div class="table-responsive">

                    <table class="table table-bordered align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pesanan->detailPesanans as $detail)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $detail->product->name ?? 'Produk tidak ditemukan' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $detail->jumlah }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">
                                        Tidak ada produk dalam pesanan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="text-end mb-4">
                    <strong>Total Harga:</strong>
                    <span class="fs-5">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                <div class="mb-4">
                    <strong>Status Pesanan</strong>

                    <p class="mt-2">

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

                    </p>
                </div>

                <hr>

                <h5 class="mb-3">Ubah Status Pesanan</h5>

                <form action="{{ route('pesanans.update', $pesanan->id_pesanan) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <select name="status" class="form-select mb-3">

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

                    <button type="submit" class="btn btn-primary">
                        Simpan Status
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
