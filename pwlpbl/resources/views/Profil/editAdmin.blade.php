@extends('dashboard.admin')

@section('title', 'Ubah Foto Profil')

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

    .btn-outline-moza {
        border: 1px solid var(--moza-accent);
        color: var(--moza-accent);
        font-weight: 600;
    }

    .btn-outline-moza:hover {
        background: var(--moza-accent);
        color: var(--moza-accent-text);
    }

    .foto-preview {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--moza-accent);
    }

    .foto-placeholder {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: var(--moza-accent);
        color: var(--moza-accent-text);
        font-size: 48px;
        font-weight: bold;
    }
</style>
@endpush

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Ubah Foto Profil</h2>
        <p class="text-secondary mb-0">Unggah foto baru untuk akun admin kamu.</p>
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

            <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-4">

                    <img id="fotoPreview"
                         src="{{ $admin->foto }}"
                         alt="Foto profil"
                         class="foto-preview mb-3 {{ $admin->foto ? '' : 'd-none' }}">

                    <div id="fotoPlaceholder"
                         class="foto-placeholder d-inline-flex align-items-center justify-content-center mb-3 {{ $admin->foto ? 'd-none' : '' }}">
                        {{ strtoupper(substr($admin->email ?? 'A', 0, 1)) }}
                    </div>

                    <div style="max-width: 360px; margin: 0 auto;">
                        <input type="file" name="foto" id="fotoInput" class="form-control"
                               accept="image/png, image/jpeg, image/webp">
                        <div class="text-secondary small mt-1">
                            Format JPG, PNG, atau WEBP. Maksimal 1 MB.
                        </div>
                    </div>

                    @if ($admin->foto)
                        <div class="form-check d-inline-block mt-2">
                            <input class="form-check-input" type="checkbox"
                                   name="hapus_foto" id="hapus_foto" value="1">
                            <label class="form-check-label" for="hapus_foto">Hapus foto profil</label>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <button type="submit" class="btn btn-moza">💾 Simpan Foto</button>
                    <a href="{{ route('admin.profil.show') }}" class="btn btn-outline-moza">Batal</a>
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