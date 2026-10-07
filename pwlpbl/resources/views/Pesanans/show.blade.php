<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    @if (session('role') === 'pembeli')
        <script
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
        </script>
    @endif
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Pesanan</h2>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            Kembali
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


    {{-- Validasi error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            {{-- Informasi Pesanan --}}
            <div class="row mb-3">

                <div class="col-md-6">

                    <strong>Nomor Pesanan</strong>

                    <p>
                        #{{ $pesanan->id_pesanan }}
                    </p>

                </div>


                <div class="col-md-6">

                    <strong>Nama Pelanggan</strong>

                    <p>
                        {{ $pesanan->pembeli->nama ?? 'Data pembeli tidak ditemukan' }}
                    </p>

                </div>

            </div>


            {{-- Jenis Pesanan --}}
            <div class="mb-3">

                <strong>Jenis Pesanan</strong>

                <p>
                    {{ $pesanan->jenis_pesanan }}
                </p>

            </div>


            <hr>


            {{-- Daftar Produk --}}
            <h5 class="mb-3">
                Daftar Produk
            </h5>


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

                        @forelse ($pesanan->detailPesanans as $detail)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $detail->product->name
                                        ?? $detail->product->nama_produk
                                        ?? 'Produk tidak ditemukan' }}
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


            {{-- Total Harga --}}
            <div class="text-end mb-4">

                <strong>
                    Total Harga:
                </strong>

                <span class="fs-5 fw-bold">

                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}

                </span>

            </div>


            {{-- Status Pesanan --}}
            <div class="mb-3">

                <strong>
                    Status Pesanan
                </strong>

                <p class="mt-2">

                    @if ($pesanan->status === 'Menunggu')

                        <span class="badge bg-warning text-dark">
                            Menunggu
                        </span>

                    @elseif ($pesanan->status === 'Diproses')

                        <span class="badge bg-info text-dark">
                            Diproses
                        </span>

                    @elseif ($pesanan->status === 'Selesai')

                        <span class="badge bg-success">
                            Selesai
                        </span>

                    @else

                        <span class="badge bg-danger">
                            {{ $pesanan->status }}
                        </span>

                    @endif

                </p>

            </div>


            {{-- Metode Pembayaran --}}
            <div class="mb-3">

                <strong>
                    Metode Pembayaran
                </strong>

                <p class="mt-2">

                    @if ($pesanan->metode_pembayaran === 'Cash')

                        <span class="badge bg-secondary">
                            Cash
                        </span>

                    @elseif ($pesanan->metode_pembayaran === 'Midtrans')

                        <span class="badge bg-primary">
                            Midtrans
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Belum Dipilih
                        </span>

                    @endif

                </p>

            </div>


            {{-- Status Pembayaran --}}
            <div class="mb-4">

                <strong>
                    Status Pembayaran
                </strong>

                <p class="mt-2">

                    @if ($pesanan->status_pembayaran === 'Dibayar')

                        <span class="badge bg-success">
                            Sudah Dibayar
                        </span>

                    @elseif ($pesanan->status_pembayaran === 'Menunggu Pembayaran')

                        <span class="badge bg-warning text-dark">
                            Menunggu Pembayaran
                        </span>

                    @elseif ($pesanan->status_pembayaran === 'Gagal')

                        <span class="badge bg-danger">
                            Gagal
                        </span>

                    @else

                        <span class="badge bg-warning text-dark">
                            {{ $pesanan->status_pembayaran ?? 'Belum Dibayar' }}
                        </span>

                    @endif

                </p>

            </div>


            {{-- ========================================= --}}
            {{-- PEMBAYARAN UNTUK PEMBELI --}}
            {{-- ========================================= --}}

            @if (session('role') === 'pembeli')

                {{-- Jika sudah dibayar --}}
                @if ($pesanan->status_pembayaran === 'Dibayar')

                    <div class="alert alert-success">

                        Pembayaran pesanan ini sudah berhasil.

                    </div>


                {{-- Jika belum dibayar dan pesanan belum dibatalkan --}}
                @elseif ($pesanan->status !== 'Dibatalkan')


                    {{-- PEMBAYARAN MIDTRANS --}}
                    @if ($pesanan->metode_pembayaran === 'Midtrans')

                        <form
                            action="{{ route('pesanans.bayar', $pesanan->id_pesanan) }}"
                            method="POST"
                            class="mb-4">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success btn-lg w-100">

                                Bayar dengan Midtrans

                            </button>

                        </form>


                    {{-- PEMBAYARAN CASH --}}
                    @elseif ($pesanan->metode_pembayaran === 'Cash')

                        <div class="alert alert-info">

                            <strong>
                                Metode Pembayaran: Cash
                            </strong>

                            <br>

                            Silakan lakukan pembayaran langsung kepada kasir.

                            <br>

                            Status pembayaran:

                            <strong>
                                {{ $pesanan->status_pembayaran }}
                            </strong>

                        </div>

                    @endif

                @endif

            @endif


            {{-- ========================================= --}}
            {{-- ADMIN --}}
            {{-- ========================================= --}}

            @if (session('role') === 'admin')

                <hr>

                <h5 class="mb-3">
                    Ubah Status Pesanan
                </h5>


                <form
                    action="{{ route('pesanans.update', $pesanan->id_pesanan) }}"
                    method="POST">

                    @csrf

                    @method('PUT')


                    <select
                        name="status"
                        class="form-select mb-3"
                        required>

                        <option
                            value="Menunggu"
                            {{ $pesanan->status === 'Menunggu' ? 'selected' : '' }}>

                            Menunggu

                        </option>


                        <option
                            value="Diproses"
                            {{ $pesanan->status === 'Diproses' ? 'selected' : '' }}>

                            Diproses

                        </option>


                        <option
                            value="Selesai"
                            {{ $pesanan->status === 'Selesai' ? 'selected' : '' }}>

                            Selesai

                        </option>


                        <option
                            value="Dibatalkan"
                            {{ $pesanan->status === 'Dibatalkan' ? 'selected' : '' }}>

                            Dibatalkan

                        </option>

                    </select>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan Status

                    </button>

                </form>

            @endif

        </div>

    </div>

</div>


{{-- ========================================= --}}
{{-- SCRIPT MIDTRANS --}}
{{-- HANYA BERJALAN JIKA SNAP TOKEN ADA --}}
{{-- ========================================= --}}

@if (session('role') === 'pembeli' && session('snap_token'))

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const snapToken = @json(session('snap_token'));


            if (snapToken && window.snap) {

                window.snap.pay(snapToken, {

                    onSuccess: function () {

                        alert(
                            'Pembayaran berhasil diproses. Status akan diperbarui setelah dikonfirmasi.'
                        );

                        window.location.reload();

                    },


                    onPending: function () {

                        alert(
                            'Pembayaran masih menunggu penyelesaian.'
                        );

                    },


                    onError: function () {

                        alert(
                            'Pembayaran gagal. Silakan coba kembali.'
                        );

                    },


                    onClose: function () {

                        console.log(
                            'Jendela pembayaran ditutup.'
                        );

                    }

                });

            } else {

                alert(
                    'Jendela pembayaran belum dapat dibuka. Periksa Client Key Midtrans dan koneksi internet.'
                );

            }

        });

    </script>

@endif


</body>

</html>
