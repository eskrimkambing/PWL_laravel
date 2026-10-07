<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-2">Tambah Pembayaran</h2>

    <p class="text-muted mb-4">
        Tambahkan data pembayaran untuk pesanan.
    </p>

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

            @if ($pesanans->count() > 0)

                <form action="{{ route('pembayaran.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">

                        <label for="pesanan_id" class="form-label">
                            Pesanan
                        </label>

                        <select
                            name="pesanan_id"
                            id="pesanan_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Pesanan --
                            </option>

                            @foreach ($pesanans as $pesanan)

                                <option
                                    value="{{ $pesanan->id_pesanan }}"
                                >
                                    Pesanan #{{ $pesanan->id_pesanan }}
                                    -
                                    {{ $pesanan->pembeli->nama ?? $pesanan->pembeli->email ?? '-' }}
                                    -
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label for="metode_pembayaran" class="form-label">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran"
                            id="metode_pembayaran"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Metode --
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="Midtrans">
                                Midtrans
                            </option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label for="status_pembayaran" class="form-label">
                            Status Pembayaran
                        </label>

                        <select
                            name="status_pembayaran"
                            id="status_pembayaran"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Status --
                            </option>

                            <option value="Belum Dibayar">
                                Belum Dibayar
                            </option>

                            <option value="Menunggu Pembayaran">
                                Menunggu Pembayaran
                            </option>

                            <option value="Dibayar">
                                Dibayar
                            </option>

                            <option value="Gagal">
                                Gagal
                            </option>

                        </select>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a
                        href="{{ route('pembayaran.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                </form>

            @else

                <div class="alert alert-info mb-0">

                    Tidak ada pesanan yang bisa ditambahkan
                    pembayaran secara manual.

                </div>

            @endif

        </div>

    </div>

</div>

</body>
</html>
