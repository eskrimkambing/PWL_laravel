@extends('dashboard.admin')

@section('title', 'Kelola Produk')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        {{-- Header --}}
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">

            <div>
                <h5 class="mb-1 fw-bold">
                    Katalog Produk Pizza Moza
                </h5>

                <small class="text-muted">
                    Daftar menu produk Pizza Moza
                </small>
            </div>

            {{-- Tombol khusus ADMIN --}}
            @if (session('role') === 'admin')
                <a
                    href="{{ route('products.create') }}"
                    class="btn btn-moza btn-sm px-3"
                >
                    + Tambah Menu Baru
                </a>
            @endif

        </div>


        {{-- Tabel Produk --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 100px">Foto</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Ukuran &amp; Harga</th>
                            <th class="text-center" style="width: 12%">Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @php
                            // FOTO CADANGAN untuk produk lama yang belum punya gambar di database
                            $fotoPizza = [
                                'Extra Chicken' => 'extra-chicken.jpeg',
                                'Cheese Volcano' => 'cheese-volcano.jpeg',
                                'Ekstra Beef' => 'ekstra-beef.jpeg',
                                'Original Mozza' => 'original-mozza.jpeg',
                                'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
                                'Long Pizza' => 'long-pizza.jpeg',
                            ];

                            $fotoCemilan = [
                                'Tape Bakar Original' => 'tape-bakar-original.jpeg',
                                'Singkong Keju' => 'singkong-keju.jpeg',
                                'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
                            ];
                        @endphp

                        @forelse ($products as $index => $item)

                            @php
                                // 1. Pakai gambar dari database kalau ada
                                // 2. Kalau tidak ada, pakai foto cadangan di folder public/images
                                if ($item->image) {
                                    $srcFoto = $item->image;
                                } else {
                                    if (isset($fotoPizza[$item->nama])) {
                                        $pathFoto = 'images/pizza/' . $fotoPizza[$item->nama];
                                    } elseif (isset($fotoCemilan[$item->nama])) {
                                        $pathFoto = 'images/cemilan/' . $fotoCemilan[$item->nama];
                                    } else {
                                        $pathFoto = 'images/pizza.jpg';
                                    }
                                    $srcFoto = asset($pathFoto);
                                }
                            @endphp


                            <tr>

                                {{-- Nomor --}}
                                <td class="text-center fw-bold">
                                    {{ $index + 1 }}
                                </td>


                                {{-- Foto Produk --}}
                                <td class="text-center">

                                    <img
                                        src="{{ $srcFoto }}"
                                        alt="{{ $item->nama }}"
                                        style="
                                            width: 70px;
                                            height: 55px;
                                            object-fit: cover;
                                            border-radius: 8px;
                                        "
                                    >

                                </td>


                                {{-- Nama Produk --}}
                                <td>

                                    <span class="fw-semibold">
                                        {{ $item->nama }}
                                    </span>

                                    <small class="text-muted d-block">
                                        {{ $item->deskripsi }}
                                    </small>

                                </td>


                                {{-- Kategori --}}
                                <td>

                                    <span class="badge bg-secondary">
                                        {{ $item->kategori }}
                                    </span>

                                </td>


                                {{-- Ukuran & Harga --}}
                                <td>
                                    @forelse ($item->sizes as $ukuran)
                                        <div class="d-flex justify-content-between gap-3" style="max-width: 220px;">
                                            <span>{{ $ukuran->nama }}</span>
                                            <span class="fw-bold text-success">
                                                Rp {{ number_format($ukuran->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @empty
                                        <span class="fw-bold text-success">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </span>
                                    @endforelse

                                    @if ($item->portion)
                                        <small class="text-muted d-block mt-1">{{ $item->portion }}</small>
                                    @endif
                                </td>


                                {{-- Aksi --}}
                                <td class="text-center">

                                    {{-- KHUSUS ADMIN --}}
                                    @if (session('role') === 'admin')

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('products.edit', $item->id) }}"
                                                class="btn btn-outline-warning btn-sm"
                                                title="Edit"
                                                aria-label="Edit {{ $item->nama }}"
                                            >
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                                </svg>
                                            </a>


                                            {{-- Hapus --}}
                                            <form
                                                action="{{ route('products.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Hapus menu ini dari database?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Hapus"
                                                    aria-label="Hapus {{ $item->nama }}"
                                                >
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14M10 11v6M14 11v6" />
                                                    </svg>
                                                </button>

                                            </form>

                                        </div>

                                    {{-- KHUSUS PEMBELI --}}
                                    @elseif (session('role') === 'pembeli')

                                        <a
                                            href="{{ route('checkout.index') }}"
                                            class="btn btn-moza btn-sm"
                                        >
                                            Pesan
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-4 text-muted"
                                >
                                    Belum ada menu produk dalam database.
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