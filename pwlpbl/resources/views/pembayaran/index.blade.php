<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Kelola Pembayaran</h2>
            <p class="text-muted mb-0">
                Daftar pembayaran pesanan Pizza Moza
            </p>
        </div>

        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
            + Tambah Pembayaran
        </a>
    </div>

    {{-- Pesan berhasil --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>ID Pesanan</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Dibayar Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pembayarans as $pembayaran)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    #{{ $pembayaran->id_pesanan }}
                                </td>

                                <td>
                                    {{ $pembayaran->pembeli->nama ?? $pembayaran->pembeli->email ?? '-' }}
                                </td>

                                <td>
                                    Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $pembayaran->metode_pembayaran ?? '-' }}
                                </td>

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

                                <td>
                                    @if ($pembayaran->dibayar_pada)
                                        {{ $pembayaran->dibayar_pada->format('d-m-Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        <a
                                            href="{{ route('pembayaran.show', $pembayaran->id_pesanan) }}"
                                            class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('pembayaran.edit', $pembayaran->id_pesanan) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('pembayaran.destroy', $pembayaran->id_pesanan) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data pembayaran ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-4">

                                    <p class="mb-0 text-muted">
                                        Belum ada data pembayaran.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="mt-3">

        <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">
            Kembali ke Dashboard
        </a>

    </div>

</div>

</body>
</html>
