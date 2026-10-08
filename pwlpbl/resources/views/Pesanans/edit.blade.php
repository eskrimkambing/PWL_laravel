@extends('dashboard.admin')

@section('title', 'Edit Pesanan')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Edit Pesanan</h2>
        <p class="text-secondary mb-0">Perbarui data pesanan.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="max-width: 850px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width: 850px;">
        <div class="card-body p-4">

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

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach (['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $pesanan->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-moza">Update</button>
                    <a href="{{ route('pesanans.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>

        </div>
    </div>
@endsection