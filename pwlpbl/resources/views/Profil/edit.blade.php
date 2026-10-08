@extends('layouts.pembeli')

@section('title', 'Edit Profil')

@push('styles')
<style>
    .form-control {
        background: var(--bs-tertiary-bg);
        border: 1px solid rgba(255, 255, 255, .1);
        color: var(--bs-body-color);
        border-radius: 9px;
        padding: 11px 13px;
    }

    .form-control:focus {
        background: var(--bs-tertiary-bg);
        color: #fff;
        border-color: var(--moza-accent);
        box-shadow: none;
    }

    .form-control::placeholder {
        color: #8f7e73;
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .btn-outline-moza {
        border: 1px solid var(--moza-accent);
        color: var(--moza-accent);
        font-weight: 600;
    }

    .btn-outline-moza:hover {
        background: var(--moza-accent);
        color: var(--moza-accent-text);
    }
</style>
@endpush

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Edit Profil</h2>
        <p class="text-secondary mb-0">Perbarui informasi akun kamu di sini.</p>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="max-width: 850px;">
            <strong>Data belum benar.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="max-width: 850px;">
        <div class="card-body p-4">

            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama', $pembeli->nama) }}"
                           placeholder="Masukkan nama lengkap" required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $pembeli->email) }}"
                           placeholder="Masukkan email" required>
                </div>

                {{-- NOMOR TELEPON --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="no_telp" class="form-control"
                           value="{{ old('no_telp', $pembeli->no_telp) }}"
                           placeholder="Masukkan nomor telepon">
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control"
                              placeholder="Masukkan alamat lengkap">{{ old('alamat', $pembeli->alamat) }}</textarea>
                </div>

                <hr class="my-4">

                {{-- PASSWORD --}}
                <h5 class="mb-3">Ubah Password</h5>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    <div class="text-secondary small mt-1">
                        Minimal 6 karakter. Kosongkan jika password tidak ingin diubah.
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Ulangi password baru">
                </div>

                {{-- TOMBOL --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-moza">💾 Simpan Perubahan</button>
                    <a href="{{ route('profil.show') }}" class="btn btn-outline-moza">Batal</a>
                </div>
            </form>

        </div>
    </div>
@endsection