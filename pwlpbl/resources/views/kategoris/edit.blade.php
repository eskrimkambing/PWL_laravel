@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        Edit Kategori
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('kategoris.update', $kategori->id_kategori) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label for="nama_kategori" class="form-label fw-semibold">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="nama_kategori"
                                id="nama_kategori"
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                placeholder="Masukkan nama kategori"
                                required
                            >

                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="d-flex gap-2">

                            <button type="submit" class="btn btn-dark">
                                Update
                            </button>

                            <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
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