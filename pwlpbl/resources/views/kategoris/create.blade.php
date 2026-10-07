
@extends('dashboard.admin')

@section('title', 'Tambah Kategori')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">

            {{-- Header halaman --}}
            <div class="mb-4">
                <h2 class="mb-1">Tambah Kategori</h2>
                <p class="text-muted mb-0">
                    Tambahkan kategori baru untuk menu Pizza Moza.
                </p>
            </div>

            {{-- Form Card --}}
            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <form action="{{ route('kategoris.store') }}" method="POST">

                        @csrf

                        {{-- Nama Kategori --}}
                        <div class="mb-4">

                            <label
                                for="nama_kategori"
                                class="form-label"
                            >
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                id="nama_kategori"
                                name="nama_kategori"
                                value="{{ old('nama_kategori') }}"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                placeholder="Contoh: Pizza"
                                required
                            >

                            <div class="form-text">
                                Masukkan nama kategori yang ingin ditambahkan.
                            </div>

                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2 justify-content-end">

                            <a
                                href="{{ route('kategoris.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan Kategori
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection

