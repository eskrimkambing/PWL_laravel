@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Tambah Kategori Produk</h2>

        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('kategoris.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="nama_kategori"
                        id="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        placeholder="Contoh: Pizza"
                        value="{{ old('nama_kategori') }}"
                        required
                    >

                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </form>

        </div>
    </div>

</div>
@endsection