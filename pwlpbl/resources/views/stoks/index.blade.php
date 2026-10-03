@extends('layouts.app')

@section('content')

<div class="card shadow-sm border-0">

    {{-- Header --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

        <div>
            <h5 class="mb-0 fw-bold text-dark">
                Data Stok Produk
            </h5>

            <small class="text-muted">
                Kelola stok produk Pizza Moza
            </small>
        </div>

        <div class="d-flex gap-2">

            {{-- Tombol kembali ke dashboard --}}
            <a
                href="{{ route('dashboard.admin') }}"
                class="btn btn-secondary btn-sm px-3"
            >
                ← Kembali ke Dashboard
            </a>

            {{-- Tombol tambah stok --}}
            <a
                href="{{ route('stoks.create') }}"
                class="btn btn-dark btn-sm px-3"
            >
                + Tambah Stok
            </a>

        </div>

    </div>


    {{-- Isi --}}
    <div class="card-body p-0">

        {{-- Pesan sukses --}}
        @if (session('success'))

            <div class="alert alert-success m-3">
                {{ session('success') }}
            </div>

        @endif


        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-dark">

                    <tr>

                        <th class="text-center" style="width: 5%">
                            No
                        </th>

                        <th>
                            Produk
                        </th>

                        <th>
                            Tanggal Stok
                        </th>

                        <th>
                            Jumlah Stok
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-center" style="width: 20%">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($stoks as $stok)

                        <tr>

                            {{-- Nomor --}}
                            <td class="text-center fw-bold">
                                {{ $loop->iteration }}
                            </td>


                            {{-- Produk --}}
                            <td>

                                <span class="fw-semibold">
                                    {{ $stok->product->name ?? 'Produk tidak ditemukan' }}
                                </span>

                            </td>


                            {{-- Tanggal --}}
                            <td>

                                {{ \Carbon\Carbon::parse($stok->tanggal_stok)->format('d-m-Y') }}

                            </td>


                            {{-- Jumlah --}}
                            <td>

                                <span class="fw-bold">
                                    {{ $stok->jumlah_stok }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if ($stok->jumlah_stok > 0)

                                    <span class="badge bg-success">
                                        Tersedia
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Habis
                                    </span>

                                @endif

                            </td>


                            {{-- Aksi --}}
                            <td class="text-center">

                                {{-- Edit --}}
                                <a
                                    href="{{ route('stoks.edit', $stok->id_stok) }}"
                                    class="btn btn-outline-warning btn-sm"
                                >
                                    Edit
                                </a>


                                {{-- Hapus --}}
                                <form
                                    action="{{ route('stoks.destroy', $stok->id_stok) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Hapus data stok ini?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-4 text-muted"
                            >
                                Belum ada data stok.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection