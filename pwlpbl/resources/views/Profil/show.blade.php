@extends('layouts.pembeli')

@section('title', 'Profil')

@push('styles')
<style>
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--moza-accent);
        color: var(--moza-accent-text);
        font-size: 30px;
        font-weight: bold;
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
        <h2 class="fw-bold mb-1">Profil Saya</h2>
        <p class="text-secondary mb-0">Lihat dan kelola informasi akun kamu.</p>
    </div>

    <div class="card" style="max-width: 850px;">
        <div class="card-body p-4">

            {{-- HEADER PROFIL --}}
            <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">
                <div class="profile-avatar d-flex align-items-center justify-content-center">
                    {{ strtoupper(substr($pembeli->nama ?? 'P', 0, 1)) }}
                </div>
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
@endsection