@extends('dashboard.admin')

@section('title', 'Profil Admin')

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
</style>
@endpush

@section('content')

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Profil Admin</h2>
        <p class="text-secondary mb-0">Lihat informasi akun admin kamu.</p>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('sukses'))
        <div class="alert alert-success" style="max-width: 850px;">{{ session('sukses') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="max-width: 850px;">{{ session('error') }}</div>
    @endif

    <div class="card" style="max-width: 850px;">
        <div class="card-body p-4">

            {{-- HEADER PROFIL --}}
            <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">

                @if ($admin->foto)
                    <img src="{{ $admin->foto }}" alt="Foto profil" class="profile-avatar-img">
                @else
                    <div class="profile-avatar d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr($admin->email ?? 'A', 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h4 class="mb-1">Administrator</h4>
                    <p class="text-secondary mb-0">{{ $admin->email ?? '-' }}</p>
                </div>
            </div>

            {{-- DATA PROFIL --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Email</div>
                        <div>{{ $admin->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">ID Admin</div>
                        <div>{{ $admin->id_admin }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="text-secondary small mb-1">Peran</div>
                        <div>Admin</div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.profil.edit') }}" class="btn btn-moza">✏️ Ubah Foto</a>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-moza">Kembali</a>
            </div>

        </div>
    </div>

@endsection