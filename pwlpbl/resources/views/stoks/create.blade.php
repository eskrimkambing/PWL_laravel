@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        Tambah Stok Produk
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('stoks.store') }}" method="POST">

                        @csrf

                        {{-- Produk --}}
                        <div class="mb-3">

                            <label for="product_id" class="form-label fw-semibold">
                                Produk
                            </label>

                            <select
                                name="product_id"
                                id="product_id"
                                class="form-select @error('product_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    -- Pilih Produk --
                                </option>

                                @foreach ($products as $product)

                                    <option
                                        value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}
                                    >
                                        {{ $product->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('product_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">

                            <label for="tanggal_stok" class="form-label fw-semibold">
                                Tanggal Stok
                            </label>

                            <input
                                type="date"
                                name="tanggal_stok"
                                id="tanggal_stok"
                                class="form-control @error('tanggal_stok') is-invalid @enderror"
                                value="{{ old('tanggal_stok', date('Y-m-d')) }}"
                                required
                            >

                            @error('tanggal_stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">

                            <label for="jumlah_stok" class="form-label fw-semibold">
                                Jumlah Stok
                            </label>

                            <input
                                type="number"
                                name="jumlah_stok"
                                id="jumlah_stok"
                                class="form-control @error('jumlah_stok') is-invalid @enderror"
                                value="{{ old('jumlah_stok') }}"
                                min="0"
                                placeholder="Masukkan jumlah stok"
                                required
                            >

                            @error('jumlah_stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Status --}}
                        <div class="mb-4">

                            <label for="status_stok" class="form-label fw-semibold">
                                Status Stok
                            </label>

                            <select
                                name="status_stok"
                                id="status_stok"
                                class="form-select @error('status_stok') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option
                                    value="Tersedia"
                                    {{ old('status_stok') == 'Tersedia' ? 'selected' : '' }}
                                >
                                    Tersedia
                                </option>

                                <option
                                    value="Habis"
                                    {{ old('status_stok') == 'Habis' ? 'selected' : '' }}
                                >
                                    Habis
                                </option>

                            </select>

                            @error('status_stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-dark"
                            >
                                Simpan Stok
                            </button>

                            <a
                                href="{{ route('stoks.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection