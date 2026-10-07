@extends('dashboard.admin')

@section('title', 'Edit Stok')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            Edit Stok Produk
        </h3>

        <p class="text-secondary mb-0">
            Perbarui data stok produk Pizza Moza
        </p>
    </div>


    <div class="row justify-content-center">

        <div class="col-lg-7 col-xl-6">

            <div class="card">

                <div class="card-body p-4">

                    <form
                        action="{{ route('stoks.update', $stok->id_stok) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Produk --}}
                        <div class="mb-3">

                            <label
                                for="product_id"
                                class="form-label fw-semibold"
                            >
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
                                        {{ old('product_id', $stok->product_id) == $product->id ? 'selected' : '' }}
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

                            <label
                                for="tanggal_stok"
                                class="form-label fw-semibold"
                            >
                                Tanggal Stok
                            </label>

                            <input
                                type="date"
                                name="tanggal_stok"
                                id="tanggal_stok"
                                class="form-control @error('tanggal_stok') is-invalid @enderror"
                                value="{{ old('tanggal_stok', $stok->tanggal_stok) }}"
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

                            <label
                                for="jumlah_stok"
                                class="form-label fw-semibold"
                            >
                                Jumlah Stok
                            </label>

                            <input
                                type="number"
                                name="jumlah_stok"
                                id="jumlah_stok"
                                class="form-control @error('jumlah_stok') is-invalid @enderror"
                                value="{{ old('jumlah_stok', $stok->jumlah_stok) }}"
                                min="0"
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

                            <label
                                for="status_stok"
                                class="form-label fw-semibold"
                            >
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
                                    {{ old('status_stok', $stok->status_stok) == 'Tersedia' ? 'selected' : '' }}
                                >
                                    Tersedia
                                </option>

                                <option
                                    value="Habis"
                                    {{ old('status_stok', $stok->status_stok) == 'Habis' ? 'selected' : '' }}
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
                                class="btn btn-moza px-4"
                            >
                                Update Stok
                            </button>

                            <a
                                href="{{ route('stoks.index') }}"
                                class="btn btn-outline-secondary px-4"
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
