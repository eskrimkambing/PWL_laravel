@extends('dashboard.admin')

@section('title', 'Data Stok')

@section('content')

<div class="container-fluid">


{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Data Stok Produk
        </h3>

        <p class="text-secondary mb-0">
            Kelola stok produk Pizza Moza
        </p>
    </div>

    <a
        href="{{ route('stoks.create') }}"
        class="btn btn-moza px-3"
    >
        + Tambah Stok
    </a>

</div>


{{-- Pesan sukses --}}
@if (session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- Tabel --}}
<div class="card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
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

                                <a
                                    href="{{ route('stoks.edit', $stok->id_stok) }}"
                                    class="btn btn-outline-warning btn-sm"
                                >
                                    Edit
                                </a>


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
                                class="text-center py-5 text-secondary"
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


</div>

@endsection

