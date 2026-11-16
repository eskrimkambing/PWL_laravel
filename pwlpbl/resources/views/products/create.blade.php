@extends('dashboard.admin')

@section('title', 'Tambah Menu')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">

                <div class="card-header">
                    <h5 class="mb-0 fw-bold">
                        Tambah Menu Baru
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Menu --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Menu
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Pizza Super Cheese"
                                required
                            >

                            @error('nama')
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
                                    name="kategori"
                                    class="form-select @error('kategori') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>

                                    @foreach ($kategoris as $kategori)
                                        <option
                                            value="{{ $kategori->nama_kategori }}"
                                            {{ old('kategori') == $kategori->nama_kategori ? 'selected' : '' }}
                                        >
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Keterangan Porsi
                                </label>

                                <input
                                    type="text"
                                    name="portion"
                                    class="form-control @error('portion') is-invalid @enderror"
                                    value="{{ old('portion') }}"
                                    placeholder="Opsional, mis. 4 Orang"
                                >

                                @error('portion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>

                        {{-- Ukuran & Harga --}}
                        @include('products._sizes')

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Deskripsi Menu
                            </label>

                            <textarea
                                name="deskripsi"
                                rows="3"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Keterangan bahan dan topping"
                            >{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Gambar Menu
                            </label>

                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/*"
                            >

                            <small class="text-secondary">
                                Opsional. Format JPG, PNG, atau WEBP. Maksimal 5 MB.
                            </small>

                            @error('image')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Preview gambar sebelum disimpan --}}
                            <div class="mt-2">
                                <img id="preview"
                                     src=""
                                     alt="Preview"
                                     style="display:none; width:120px; height:120px; object-fit:cover; border-radius:10px;">
                            </div>
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
                                class="btn btn-moza"
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

@push('scripts')
<script>
    // Tampilkan preview gambar saat file dipilih
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endpush