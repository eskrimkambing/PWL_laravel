
@extends('dashboard.admin')

@section('title', 'Tambah Menu')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">

                <div class=>
                    <h5 class="mb-0 fw-bold">
                        Tambah Menu Baru
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        {{-- Nama Menu --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Menu
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Pizza Super Cheese"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Kategori dan Porsi --}}
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Kategori Menu
                                </label>

                                <select
                                    name="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>

                                    @foreach ($kategoris as $kategori)
                                        <option
                                            value="{{ $kategori->nama_kategori }}"
                                            {{ old('category') == $kategori->nama_kategori ? 'selected' : '' }}
                                        >
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Porsi / Ukuran
                                </label>

                                <input
                                    type="text"
                                    name="portion"
                                    class="form-control @error('portion') is-invalid @enderror"
                                    value="{{ old('portion') }}"
                                    placeholder="Contoh: Large (4 Orang)"
                                    required
                                >

                                @error('portion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Harga (Rp)
                            </label>

                            <input
                                type="number"
                                name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}"
                                placeholder="Contoh: 35000"
                                required
                            >

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Deskripsi Menu
                            </label>

                            <textarea
                                name="description"
                                rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Keterangan bahan dan topping"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('products.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-dark"
                            >
                                Simpan Menu
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection
