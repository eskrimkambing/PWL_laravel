@extends('layouts.pembeli')

@section('title', 'Profil')

@push('styles')
<style>
    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--moza-accent);
        color: var(--moza-accent-text);
        font-size: 34px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .profile-avatar-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid var(--moza-accent);
    }

    .info-box {
        background: var(--bs-tertiary-bg);
        border-radius: 12px;
        padding: 16px 18px;
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

    .danger-zone {
        border: 1px solid rgba(220, 53, 69, 0.4);
        background: rgba(220, 53, 69, 0.06);
        border-radius: 14px;
    }
</style>
@endpush

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Profil Saya</h2>
        <p class="text-secondary mb-0">Lihat dan kelola informasi akun kamu.</p>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('sukses'))
        <div class="alert alert-success" style="max-width: 850px;">{{ session('sukses') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="max-width: 850px;">{{ session('error') }}</div>
    @endif

    <div class="card mb-4" style="max-width: 850px;">
        <div class="card-body p-4">

            {{-- HEADER PROFIL --}}
            <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">

                @if ($pembeli->foto)
                    <img src="{{ $pembeli->foto }}" alt="Foto profil" class="profile-avatar-img">
                @else
                    <div class="profile-avatar d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($pembeli->nama ?? $pembeli->email ?? 'P', 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h4 class="mb-1">{{ $pembeli->nama ?? 'Pembeli' }}</h4>
                    <p class="text-secondary mb-0">{{ $pembeli->email ?? '-' }}</p>
                </div>
            </div>

            {{-- DATA PROFIL --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Nama Lengkap</div>
                        <div>{{ $pembeli->nama ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Email</div>
                        <div>{{ $pembeli->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Nomor Telepon</div>
                        <div>{{ $pembeli->no_telp ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">ID Pembeli</div>
                        <div>{{ $pembeli->id_pembeli }}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Alamat</div>
                        <div>{{ $pembeli->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('profil.edit') }}" class="btn btn-moza">✏️ Edit Profil</a>
                <a href="{{ route('dashboard.pembeli') }}" class="btn btn-outline-moza">Kembali</a>
            </div>

        </div>
    </div>

    {{-- ================= HAPUS AKUN ================= --}}
    <div class="danger-zone p-4" style="max-width: 850px;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="text-danger mb-1">Hapus Akun</h5>
                <p class="text-secondary small mb-0">
                    Akun dan data profil kamu akan dihapus permanen dan tidak bisa dikembalikan.
                </p>
            </div>

            <button type="button" class="btn btn-outline-danger"
                    data-bs-toggle="modal" data-bs-target="#modalHapusAkun">
                🗑️ Hapus Akun Saya
            </button>
        </div>
    </div>

    {{-- MODAL KONFIRMASI --}}
    <div class="modal fade" id="modalHapusAkun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Hapus akun?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('profil.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p>
                            Akun <strong>{{ $pembeli->email }}</strong> akan dihapus permanen
                            dan kamu akan langsung keluar. Tindakan ini tidak bisa dibatalkan.
                        </p>

                        <label class="form-label small" for="konfirmasiHapus">
                            Ketik <strong>HAPUS</strong> untuk melanjutkan
                        </label>
                        <input type="text" id="konfirmasiHapus" class="form-control"
                               autocomplete="off" placeholder="HAPUS">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" id="tombolHapus" class="btn btn-danger" disabled>
                            Ya, Hapus Akun
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Tombol hapus baru aktif setelah pengguna mengetik "HAPUS"
    document.getElementById('konfirmasiHapus').addEventListener('input', function () {
        document.getElementById('tombolHapus').disabled = this.value.trim() !== 'HAPUS';
    });
</script>
@endpush