@extends('dashboard.admin')

@section('title', 'Tambah Pembayaran')

@push('styles')
<style>
    .form-box {
        max-width: 750px;
    }

    .form-control,
    .form-select {
        background: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color);
        color: var(--bs-body-color);
    }

    .form-control:focus,
    .form-select:focus {
        background: var(--bs-card-bg);
        color: var(--bs-body-color);
        border-color: #6b5648;
        box-shadow: none;
    }

    .form-select option {
        background: #261c17;
        color: #f3e9e1;
    }

    .form-card {
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        background: transparent;
    }
</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Pembayaran</h2>
            <p class="text-secondary mb-0">Tambahkan data pembayaran pesanan Pizza Moza</p>
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
        <div class="form-card p-4">

            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                {{-- PESANAN --}}
                <div class="mb-4">
                    <label for="pesanan_id" class="form-label">Pesanan</label>

                    <select name="pesanan_id" id="pesanan_id" class="form-select" required>
                        <option value="">-- Pilih Pesanan --</option>

                        @forelse ($pesanans as $pesanan)
                            <option value="{{ $pesanan->id_pesanan }}"
                                {{ old('pesanan_id') == $pesanan->id_pesanan ? 'selected' : '' }}>
                                #{{ $pesanan->id_pesanan }}
                                -
                                {{ $pesanan->pembeli->nama
                                    ?? $pesanan->pembeli->email
                                    ?? 'Pembeli' }}
                                -
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada pesanan yang tersedia</option>
                        @endforelse
                    </select>

                    <small class="text-secondary">
                        Pilih pesanan yang ingin dicatat pembayarannya.
                    </small>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="mb-4">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>

                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        @foreach (['Cash', 'Midtrans'] as $metode)
                            <option value="{{ $metode }}"
                                {{ old('metode_pembayaran') === $metode ? 'selected' : '' }}>
                                {{ $metode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS PEMBAYARAN --}}
                <div class="mb-4">
                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>

                    <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach (['Belum Dibayar', 'Menunggu Pembayaran', 'Dibayar', 'Gagal'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status_pembayaran') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TOMBOL --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-moza">Simpan Pembayaran</button>
                </div>
            </form>

        </div>
    </div>

@endsection