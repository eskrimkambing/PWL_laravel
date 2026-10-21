@extends('dashboard.admin')

@section('title', 'Kelola Pesanan')

@section('content')

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>
            <h2 class="fw-bold mb-1">Kelola Pesanan</h2>
            <p class="text-secondary mb-0">Daftar semua pesanan yang masuk ke Pizza Moza</p>
        </div>

        <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>


    {{-- PENCARIAN & TOTAL --}}
    <div class="row align-items-center mb-4 px-2">

        <div class="col-md-7">
            <input
                type="text"
                id="cariPesanan"
                class="form-control"
                placeholder="Cari pesanan (ID, pembeli, status)..."
            >
        </div>

        <div class="col-md-5 text-md-end text-secondary mt-2 mt-md-0">
            Total pesanan: <strong class="text-white">{{ $pesanans->count() }}</strong>
        </div>

    </div>


    {{-- TABEL --}}
    <div class="table-responsive">

        <table class="table align-middle" id="tabelPesanan">

            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pesanan</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($pesanans as $pesanan)

                    @php
                        $status = strtolower($pesanan->status ?? 'menunggu');
                    @endphp

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold">#{{ $pesanan->id_pesanan }}</td>

                        <td>{{ $pesanan->nama_penerima ?? $pesanan->pembeli->nama ?? $pesanan->pembeli->email ?? '-' }}</td>

                        <td>
                            {{ $pesanan->created_at
                                ? $pesanan->created_at->format('d/m/Y H:i')
                                : '-' }}
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- STATUS PEMBAYARAN --}}
                        <td>
                            @if (($pesanan->status_pembayaran ?? '') === 'Dibayar')
                                <span class="badge bg-success">Dibayar</span>
                            @else
                                <span class="badge bg-secondary">Belum Dibayar</span>
                            @endif
                        </td>

                        {{-- STATUS PESANAN --}}
                        <td>
                            @if ($status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif ($status == 'diproses')
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @elseif ($status == 'dibatalkan')
                                <span class="badge bg-danger">Dibatalkan</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="text-end">

                            <a
                                href="{{ route('admin.pesanans.show', $pesanan->id_pesanan) }}"
                                class="btn btn-sm btn-outline-info"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('admin.pesanans.edit', $pesanan->id_pesanan) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                Edit
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center text-secondary py-5">
                            Belum ada pesanan. Pesanan yang masuk akan tampil di halaman ini.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

@endsection


@push('scripts')
<script>
    // Filter tabel pesanan berdasarkan teks yang diketik
    document.getElementById('cariPesanan').addEventListener('input', function () {

        const kata = this.value.toLowerCase();

        document.querySelectorAll('#tabelPesanan tbody tr').forEach(function (baris) {
            baris.style.display = baris.textContent.toLowerCase().includes(kata) ? '' : 'none';
        });

    });
</script>
@endpush