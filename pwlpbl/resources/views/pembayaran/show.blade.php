<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-2">Detail Pembayaran</h2>

    <p class="text-muted mb-4">
        Informasi pembayaran pesanan Pizza Moza.
    </p>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="220">ID Pesanan</th>
                    <td>#{{ $pembayaran->id_pesanan }}</td>
                </tr>

                <tr>
                    <th>Pembeli</th>
                    <td>
                        {{ $pembayaran->pembeli->nama ?? $pembayaran->pembeli->email ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>
                        {{ $pembayaran->pembeli->email ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Total Pesanan</th>
                    <td>
                        Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Jenis Pesanan</th>
                    <td>
                        {{ $pembayaran->jenis_pesanan }}
                    </td>
                </tr>

                <tr>
                    <th>Metode Pembayaran</th>
                    <td>
                        {{ $pembayaran->metode_pembayaran ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status Pembayaran</th>
                    <td>

                        @if ($pembayaran->status_pembayaran === 'Dibayar')

                            <span class="badge bg-success">
                                Dibayar
                            </span>

                        @elseif ($pembayaran->status_pembayaran === 'Gagal')

                            <span class="badge bg-danger">
                                Gagal
                            </span>

                        @elseif ($pembayaran->status_pembayaran === 'Menunggu Pembayaran')

                            <span class="badge bg-warning text-dark">
                                Menunggu Pembayaran
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Belum Dibayar
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Dibayar Pada</th>
                    <td>
                        @if ($pembayaran->dibayar_pada)
                            {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Snap Token</th>
                    <td>
                        @if ($pembayaran->snap_token)
                            Tersedia
                        @else
                            -
                        @endif
                    </td>
                </tr>

            </table>

            <div class="mt-4">

                <a
                    href="{{ route('pembayaran.edit', $pembayaran->id_pesanan) }}"
                    class="btn btn-warning">
                    Edit
                </a>

                <a
                    href="{{ route('pembayaran.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>
