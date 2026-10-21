@extends('dashboard.admin')

@section('title', 'Edit Pesanan')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Edit Pesanan #{{ $pesanan->id_pesanan }}</h2>
        <p class="text-secondary mb-0">Perbarui status pesanan.</p>
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

    {{-- INFORMASI PESANAN (hanya dibaca) --}}
    <div class="card mb-4" style="max-width: 850px;">
        <div class="card-body p-4">

            <div class="row mb-3">
                <div class="col-sm-4 text-secondary">Pelanggan</div>
                <div class="col-sm-8">
                    {{ $pesanan->pembeli->nama ?? '-' }}
                    <div class="small text-secondary">{{ $pesanan->pembeli->email ?? '' }}</div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 text-secondary">Status Pembayaran</div>
                <div class="col-sm-8">{{ $pesanan->status_pembayaran ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 text-secondary">Total Harga</div>
                <div class="col-sm-8 fw-semibold">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>
            </div>

            <div class="text-secondary mb-2">Produk yang dipesan</div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan->detailPesanans as $detail)
                            <tr>
                                <td>
                                    {{ $detail->product->name
                                        ?? $detail->product->nama_produk
                                        ?? 'Produk dihapus' }}
                                </td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-end">
                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-secondary">
                                    Tidak ada detail pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- FORM UBAH STATUS --}}
    <div class="card" style="max-width: 850px;">
        <div class="card-body p-4">

            <form action="{{ route('admin.pesanans.update', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Status Pesanan</label>
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
                    <a href="{{ route('admin.pesanans.indexAdmin') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>

        </div>
    </div>
@endsection