@extends('dashboard.admin')

@section('title', 'Edit Menu')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">

                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold">
                        Edit Menu: {{ $product->nama }}
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Menu --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Menu
                            </label>

                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $product->nama) }}" required>

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

                                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror"
                                    required>
                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>

                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->nama_kategori }}"
                                            {{ old('kategori', $product->kategori) == $kategori->nama_kategori ? 'selected' : '' }}>
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
                                    Porsi / Ukuran
                                </label>

                                <input type="text" name="portion"
                                    class="form-control @error('portion') is-invalid @enderror"
                                    value="{{ old('portion', $product->portion) }}" required>

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

                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', (int) $product->price) }}" required>

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

                            <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $product->deskripsi) }}</textarea>

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

                            {{-- Gambar saat ini --}}
                            @if ($product->image)
                                <div class="mb-2">
                                    <small class="text-secondary d-block mb-1">Gambar saat ini:</small>
                                    <img src="{{ $product->image }}"
                                         alt="{{ $product->nama }}"
                                         style="width:120px; height:120px; object-fit:cover; border-radius:10px;">
                                </div>
                            @endif

                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/*"
                            >

                            <small class="text-secondary">
                                Kosongkan jika tidak ingin mengganti gambar. Format JPG, PNG, atau WEBP, maksimal 1 MB.
                            </small>

                            @error('image')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Preview gambar baru sebelum disimpan --}}
                            <div class="mt-2">
                                <small id="preview-label" class="text-secondary d-none mb-1">Gambar baru:</small>
                                <img id="preview"
                                     src=""
                                     alt="Preview"
                                     style="display:none; width:120px; height:120px; object-fit:cover; border-radius:10px;">
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-warning text-dark fw-semibold">
                                Simpan Perubahan
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
    // Tampilkan preview gambar baru saat file dipilih
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const label = document.getElementById('preview-label');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            label.classList.remove('d-none');
        } else {
            preview.style.display = 'none';
            label.classList.add('d-none');
        }
    });
</script>
@endpush