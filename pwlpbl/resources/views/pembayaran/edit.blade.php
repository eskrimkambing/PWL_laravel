@extends('dashboard.admin')

@section('title', 'Edit Pembayaran')

@push('styles')
    <style>
        .form-box {
            max-width: 750px;
        }

        .form-control,
        .form-select {
            background-color: #fff;
            border: 1px solid rgba(106, 8, 1, 0.2);
            color: var(--moza-maroon);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            color: var(--moza-maroon);
            border-color: var(--moza-orange);
            box-shadow: 0 0 0 .2rem rgba(222, 120, 1, 0.2);
        }

        .info-box {
            background: var(--bs-card-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 12px;
            padding: 14px 16px;
        }
    </style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Pembayaran</h2>
            <p class="text-secondary mb-0">Ubah data pembayaran pesanan Pizza Moza</p>
        </div>

        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="form-box">

        <div class="info-box mb-4">
            <div class="row">
                <div class="col-md-4">
                    <small class="text-secondary">ID Pesanan</small>
                    <div class="fw-semibold">#{{ $pembayaran->id_pesanan }}</div>
                </div>

                <div class="col-md-4">
                    <small class="text-secondary">Pembeli</small>
                    <div class="fw-semibold">
                        {{ $pembayaran->pembeli->nama ?? ($pembayaran->pembeli->email ?? '-') }}
                    </div>
                </div>

                <div class="col-md-4">
                    <small class="text-secondary">Total Pesanan</small>
                    <div class="fw-semibold">
                        Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('pembayaran.update', $pembayaran->id_pesanan) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- METODE PEMBAYARAN --}}
            <div class="mb-4">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>

                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                    @foreach (['Cash', 'Midtrans'] as $metode)
                        <option value="{{ $metode }}"
                            {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) === $metode ? 'selected' : '' }}>
                            {{ $metode }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS PEMBAYARAN --}}
            <div class="mb-4">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>

                <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                    @foreach (['Belum Dibayar', 'Menunggu Pembayaran', 'Dibayar', 'Gagal'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status_pembayaran', $pembayaran->status_pembayaran) === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-2">
                <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-moza">Simpan Perubahan</button>
            </div>
        </form>

    </div>

@endsection
