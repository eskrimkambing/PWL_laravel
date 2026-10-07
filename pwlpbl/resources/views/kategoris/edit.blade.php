
@extends('dashboard.admin')

@section('title', 'Edit Kategori')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-transparent py-3">
                    <h5 class="mb-0">
                        Edit Kategori
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form
                        action="{{ route('kategoris.update', $kategori->id_kategori) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')

                        {{-- Nama Kategori --}}
                        <div class="mb-4">

                            <label
                                for="nama_kategori"
                                class="form-label fw-semibold"
                            >
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
                                Update
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

