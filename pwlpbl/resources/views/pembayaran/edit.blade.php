<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-2">Edit Pembayaran</h2>

    <p class="text-muted mb-4">
        Ubah data pembayaran pesanan.
    </p>

    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('pembayaran.update', $pembayaran->id_pesanan) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                {{-- ID Pesanan --}}
                <div class="mb-3">
                    <label class="form-label">
                        ID Pesanan
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="#{{ $pembayaran->id_pesanan }}"
                        readonly
                    >
                </div>

                {{-- Pembeli --}}
                <div class="mb-3">
                    <label class="form-label">
                        Pembeli
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $pembayaran->pembeli->nama ?? $pembayaran->pembeli->email ?? '-' }}"
                        readonly
                    >
                </div>

                {{-- Total --}}
                <div class="mb-3">
                    <label class="form-label">
                        Total Pesanan
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}"
                        readonly
                    >
                </div>

                {{-- Metode Pembayaran --}}
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

                        <option value="Cash"
                            {{ $pembayaran->metode_pembayaran === 'Cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option value="Midtrans"
                            {{ $pembayaran->metode_pembayaran === 'Midtrans' ? 'selected' : '' }}>
                            Midtrans
                        </option>

                    </select>

                </div>

                {{-- Status Pembayaran --}}
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

                        <option value="Belum Dibayar"
                            {{ $pembayaran->status_pembayaran === 'Belum Dibayar' ? 'selected' : '' }}>
                            Belum Dibayar
                        </option>

                        <option value="Menunggu Pembayaran"
                            {{ $pembayaran->status_pembayaran === 'Menunggu Pembayaran' ? 'selected' : '' }}>
                            Menunggu Pembayaran
                        </option>

                        <option value="Dibayar"
                            {{ $pembayaran->status_pembayaran === 'Dibayar' ? 'selected' : '' }}>
                            Dibayar
                        </option>

                        <option value="Gagal"
                            {{ $pembayaran->status_pembayaran === 'Gagal' ? 'selected' : '' }}>
                            Gagal
                        </option>

                    </select>

                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('pembayaran.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>
