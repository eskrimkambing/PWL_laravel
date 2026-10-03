@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

            <h5 class="mb-0 fw-bold text-dark">
                Katalog Produk Pizza Moza
            </h5>

            {{-- Tombol khusus ADMIN --}}
            @if (session('role') === 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-dark btn-sm px-3">
                    + Tambah Menu Baru
                </a>
            @endif

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Ukuran / Porsi</th>
                            <th>Harga</th>
                            <th class="text-center" style="width: 18%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($products as $index => $item)

                            <tr>

                                <td class="text-center fw-bold">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <span class="fw-semibold text-dark">
                                        {{ $item->name }}
                                    </span>

                                    <small class="text-muted d-block">
                                        {{ $item->description }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $item->category }}
                                    </span>
                                </td>

                                <td>
                                    {{ $item->portion }}
                                </td>

                                <td class="fw-bold text-success">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="text-center">

                                    {{-- KHUSUS ADMIN --}}
                                    @if (session('role') === 'admin')

                                        <form
                                            action="{{ route('products.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus menu ini dari database?')"
                                        >

                                            <a
                                                href="{{ route('products.edit', $item->id) }}"
                                                class="btn btn-outline-warning btn-sm"
                                            >
                                                Edit
                                            </a>

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger btn-sm"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    {{-- KHUSUS PEMBELI --}}
                                    @elseif (session('role') === 'pembeli')

                                        <a
                                            href="{{ route('checkout.index') }}"
                                            class="btn btn-dark btn-sm"
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
@endsection