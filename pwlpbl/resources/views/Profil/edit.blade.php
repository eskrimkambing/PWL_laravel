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

    /* Foto profil */
    .foto-preview {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--moza-accent);
    }

    .foto-placeholder {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--moza-accent);
        color: var(--moza-accent-text);
        font-size: 42px;
        font-weight: bold;
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

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- FOTO PROFIL --}}
                <div class="text-center mb-4">

                    <img id="fotoPreview"
                         src="{{ $pembeli->foto }}"
                         alt="Foto profil"
                         class="foto-preview mb-3 {{ $pembeli->foto ? '' : 'd-none' }}">

                    <div id="fotoPlaceholder"
                         class="foto-placeholder d-inline-flex align-items-center justify-content-center mb-3 {{ $pembeli->foto ? 'd-none' : '' }}">
                        {{ strtoupper(substr($pembeli->nama ?? $pembeli->email ?? 'P', 0, 1)) }}
                    </div>

                    <div style="max-width: 360px; margin: 0 auto;">
                        <input type="file" name="foto" id="fotoInput" class="form-control"
                               accept="image/png, image/jpeg, image/webp">
                        <div class="text-secondary small mt-1">
                            Format JPG, PNG, atau WEBP. Maksimal 1 MB.
                        </div>
                    </div>

                    @if ($pembeli->foto)
                        <div class="form-check d-inline-block mt-2">
                            <input class="form-check-input" type="checkbox"
                                   name="hapus_foto" id="hapus_foto" value="1">
                            <label class="form-check-label" for="hapus_foto">Hapus foto profil</label>
                        </div>
                    @endif
                </div>

                <hr class="mb-4">

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama', $pembeli->nama) }}"
                           placeholder="Masukkan nama lengkap" required>
                </div>

                {{-- NOMOR TELEPON --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="no_telp" class="form-control"
                           value="{{ old('no_telp', $pembeli->no_telp) }}"
                           placeholder="Masukkan nomor telepon" required>
                </div>

                {{-- ALAMAT --}}
                <div class="mb-4">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control"
                              placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $pembeli->alamat) }}</textarea>
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

@push('scripts')
<script>
    // Pratinjau foto sebelum disimpan
    document.getElementById('fotoInput').addEventListener('change', function () {

        const file = this.files[0];

        if (!file) return;

        if (file.size > 1024 * 1024) {
            alert('Ukuran foto maksimal 1 MB.');
            this.value = '';
            return;
        }

        const preview = document.getElementById('fotoPreview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');

        document.getElementById('fotoPlaceholder').classList.add('d-none');

        const hapus = document.getElementById('hapus_foto');
        if (hapus) hapus.checked = false;
    });
</script>
@endpush