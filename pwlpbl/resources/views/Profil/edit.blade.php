@extends('layouts.pembeli')

@section('title', 'Edit Profil')

@push('styles')
    <style>
        .pe-wrap {
            max-width: 560px;
            margin: 0 auto;
        }

        .pe-card {
            background: var(--moza-cream-card, #FFFBF0);
            border: 1px solid rgba(139, 26, 16, 0.12);
            border-radius: 16px;
            padding: 24px;
            color: #2B1B14;
        }

        .pe-title {
            font-size: 18px;
            font-weight: 600;
            color: #8B1A10;
            padding-bottom: 12px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(139, 26, 16, 0.12);
        }

        .pe-label {
            display: block;
            font-size: 14px;
            color: #2B1B14;
            margin-bottom: 6px;
        }

        .pe-field {
            margin-bottom: 18px;
        }

        .pe-input {
            width: 100%;
            background: #FDF8EE;
            border: 1px solid rgba(139, 26, 16, 0.2);
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 15px;
            color: #2B1B14;
        }

        .pe-input:focus {
            outline: none;
            border-color: #E8751A;
            box-shadow: 0 0 0 3px rgba(232, 117, 26, 0.2);
        }

        .pe-input-muted {
            background: #FBE7A1;
            border-color: rgba(139, 26, 16, 0.12);
            color: #6B4A3A;
        }

        .pe-input-muted:focus {
            box-shadow: none;
            border-color: rgba(139, 26, 16, 0.12);
        }

        .pe-hint {
            font-size: 12px;
            color: #6B4A3A;
            margin-top: 4px;
        }

        /* Nomor HP dengan prefiks +62 */
        .pe-phone {
            display: flex;
            align-items: stretch;
        }

        .pe-phone-prefix {
            background: #E8751A;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 11px 14px;
            border-radius: 10px 0 0 10px;
            border: 1px solid #E8751A;
            border-right: none;
            display: flex;
            align-items: center;
        }

        .pe-phone .pe-input {
            border-radius: 0 10px 10px 0;
            background: #FBE7A1;
            border-color: rgba(139, 26, 16, 0.12);
        }

        .pe-btn {
            width: 100%;
            background: #E8751A;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 600;
            font-size: 15px;
        }

        .pe-btn:hover {
            background: #8B1A10;
        }

        .pe-btn-batal {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #6B4A3A;
            text-decoration: none;
        }

        .pe-foto {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #E8751A;
        }

        .pe-foto-placeholder {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: #E8751A;
            color: #fff;
            font-size: 32px;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div class="pe-wrap">

        <div class="mb-3 text-center">
            <h2 class="fw-bold mb-1">Edit Profil</h2>
            <p class="mb-0" style="color: #6B4A3A;">Perbarui informasi akun kamu di sini.</p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum benar.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pe-card">
            <div class="pe-title">Edit Profile</div>

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- FOTO PROFIL --}}
                <div class="pe-field text-center">
                    <img id="fotoPreview" src="{{ $pembeli->foto }}" alt="Foto profil"
                        class="pe-foto mb-2 {{ $pembeli->foto ? '' : 'd-none' }}">

                    <div id="fotoPlaceholder"
                        class="pe-foto-placeholder d-inline-flex align-items-center justify-content-center mb-2 {{ $pembeli->foto ? 'd-none' : '' }}">
                        {{ strtoupper(substr($pembeli->nama ?? ($pembeli->email ?? 'P'), 0, 1)) }}
                    </div>

                    <input type="file" name="foto" id="fotoInput" class="pe-input"
                        accept="image/png, image/jpeg, image/webp">
                    <div class="pe-hint">Format JPG, PNG, atau WEBP. Maksimal 5 MB.</div>

                    @if ($pembeli->foto)
                        <div class="form-check d-inline-block mt-2">
                            <input class="form-check-input" type="checkbox" name="hapus_foto" id="hapus_foto"
                                value="1">
                            <label class="form-check-label" for="hapus_foto">Hapus foto profil</label>
                        </div>
                    @endif
                </div>

                {{-- NAMA --}}
                <div class="pe-field">
                    <label class="pe-label" for="nama">Name</label>
                    <input type="text" id="nama" name="nama" class="pe-input"
                        value="{{ old('nama', $pembeli->nama) }}" placeholder="Masukkan nama lengkap" required>
                </div>

                {{-- EMAIL (tidak bisa diubah) --}}
                <div class="pe-field">
                    <label class="pe-label" for="email">Email</label>
                    <input type="email" id="email" class="pe-input pe-input-muted" value="{{ $pembeli->email }}"
                        readonly>
                    <div class="pe-hint">Email tidak bisa diubah karena dipakai untuk login.</div>
                </div>

                {{-- NOMOR HP --}}
                @php
                    $telpTampil = ltrim(old('no_telp', $pembeli->no_telp ?? ''), '0');
                    $telpTampil = preg_replace('/^62/', '', $telpTampil);
                @endphp
                <div class="pe-field">
                    <span class="pe-label">Nomor HP</span>
                    <div class="pe-phone">
                        <span class="pe-phone-prefix">+62</span>
                        <input type="text" name="no_telp" class="pe-input" inputmode="numeric"
                            value="{{ $telpTampil }}" placeholder="81234567890" required>
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="pe-field">
                    <label class="pe-label" for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="pe-input" rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $pembeli->alamat) }}</textarea>
                </div>

                <button type="submit" class="pe-btn">Simpan</button>
                <a href="{{ route('profil.show') }}" class="pe-btn-batal">Batal</a>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Pratinjau foto sebelum disimpan
        document.getElementById('fotoInput').addEventListener('change', function() {

            const file = this.files[0];

            if (!file) return;

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran foto maksimal 5 MB.');
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
