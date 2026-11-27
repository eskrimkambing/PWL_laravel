@extends('layouts.pembeli')

@section('title', 'Profil')

@push('styles')
    <style>
        .pv-wrap {
            max-width: 1500px;
            margin: 0 auto;
        }

        .pv-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 14px;
        }

        .pv-full {
            grid-column: 1 / -1;
        }


        .pv-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1100px) minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .pv-side-UNUSED {
            background: #FFFBF0;
            border: 1px solid rgba(139, 26, 16, 0.12);
            border-radius: 16px;
            padding: 24px 22px;
            color: #2B1B14;
            position: sticky;
            top: 20px;
        }

        .pv-side-title {
            font-size: 15px;
            font-weight: 700;
            color: #8B1A10;
            margin-bottom: 12px;
        }

        .pv-side-link {
            display: block;
            background: #FDF0C4;
            color: #8B1A10;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 10px;
            font-weight: 600;
            text-decoration: none;
        }

        .pv-side-link:hover {
            background: #FCE3B8;
            color: #8B1A10;
        }

        .pv-side-text {
            font-size: 14px;
            color: #6B4A3A;
            margin-bottom: 14px;
            line-height: 1.5;
        }


        .pv-deco {
            position: sticky;
            top: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 40px;
            opacity: 0.95;
        }

        @media (max-width: 991px) {
            .pv-layout {
                grid-template-columns: 1fr;
            }

            .pv-deco {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .pv-grid {
                grid-template-columns: 1fr;
            }
        }

        .pv-card {
            background: #FFFBF0;
            border: 1px solid rgba(139, 26, 16, 0.12);
            border-radius: 16px;
            padding: 48px 56px;
            color: #2B1B14;
        }

        .pv-head {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-bottom: 22px;
            margin-bottom: 22px;
            border-bottom: 1px solid rgba(139, 26, 16, 0.12);
        }

        .pv-avatar,
        .pv-avatar-img {
            width: 128px;
            height: 128px;
            border-radius: 50%;
            margin-bottom: 14px;
        }

        .pv-avatar {
            background: #E8751A;
            color: #fff;
            font-size: 36px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pv-avatar-img {
            object-fit: cover;
            border: 3px solid #FDF0C4;
        }

        .pv-name {
            font-size: 30px;
            font-weight: 700;
            color: #8B1A10;
            margin-bottom: 4px;
        }

        .pv-email {
            font-size: 14px;
            color: #6B4A3A;
        }

        .pv-row {
            background: #FDF0C4;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 12px;
        }

        .pv-label {
            font-size: 12px;
            color: #6B4A3A;
            margin-bottom: 2px;
        }

        .pv-value {
            font-size: 16px;
            color: #2B1B14;
            word-break: break-word;
        }

        .pv-actions {
            display: flex;
            gap: 12px;
            margin-top: 22px;
            max-width: 520px;
            margin-left: auto;
            margin-right: auto;
        }

        .pv-btn-edit {
            flex: 1;
            text-align: center;
            background: #E8751A;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .pv-btn-edit:hover {
            background: #8B1A10;
            color: #fff;
        }

        .pv-btn-back {
            flex: 1;
            text-align: center;
            background: transparent;
            color: #8B1A10;
            border: 1px solid rgba(139, 26, 16, 0.3);
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .pv-btn-back:hover {
            background: #FDF0C4;
            color: #8B1A10;
        }

        .pv-danger {
            margin-top: 20px;
            background: #FFF5F3;
            border: 1px solid rgba(210, 57, 43, 0.25);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .pv-danger-title {
            font-size: 15px;
            font-weight: 700;
            color: #A32D1F;
            margin-bottom: 2px;
        }

        .pv-danger-desc {
            font-size: 13px;
            color: #6B4A3A;
            margin-bottom: 12px;
        }

        .pv-btn-hapus {
            width: 100%;
            background: transparent;
            color: #D2392B;
            border: 1px solid #D2392B;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }

        .pv-btn-hapus:hover {
            background: #D2392B;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="pv-wrap">

        <div class="mb-3 text-center">
            <h2 class="fw-bold mb-1">Profil Saya</h2>
            <p class="mb-0" style="color: #6B4A3A;">Lihat dan kelola informasi akun kamu.</p>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('sukses'))
            <div class="alert alert-success">{{ session('sukses') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="pv-layout">
            <div class="pv-deco" aria-hidden="true">
                <img src="{{ asset('images/pizza/pizza-1.png') }}" alt="" width="190"
                    style="display:block; margin:0 auto 22px; transform: rotate(-6deg);">
                <img src="{{ asset('images/pizza/pizza-4.png') }}" alt="" width="160"
                    style="display:block; margin:0 auto 22px; transform: rotate(8deg);">
            </div>
            <div>
                <div class="pv-card">

                    {{-- HEADER PROFIL --}}
                    <div class="pv-head">
                        @if ($pembeli->foto)
                            <img src="{{ $pembeli->foto }}" alt="Foto profil" class="pv-avatar-img">
                        @else
                            <div class="pv-avatar">
                                {{ strtoupper(substr($pembeli->nama ?? ($pembeli->email ?? 'P'), 0, 1)) }}
                            </div>
                        @endif

                        <div class="pv-name">{{ $pembeli->nama ?? 'Pembeli' }}</div>
                        <div class="pv-email">{{ $pembeli->email ?? '-' }}</div>
                    </div>

                    {{-- DATA PROFIL --}}
                    <div class="pv-grid">
                        <div class="pv-row">
                            <div class="pv-label">Nama Lengkap</div>
                            <div class="pv-value">{{ $pembeli->nama ?? '-' }}</div>
                        </div>

                        <div class="pv-row">
                            <div class="pv-label">Email</div>
                            <div class="pv-value">{{ $pembeli->email ?? '-' }}</div>
                        </div>

                        <div class="pv-row">
                            <div class="pv-label">Nomor Telepon</div>
                            <div class="pv-value">{{ $pembeli->no_telp ?? '-' }}</div>
                        </div>

                        <div class="pv-row pv-full">
                            <div class="pv-label">Alamat</div>
                            <div class="pv-value">{{ $pembeli->alamat ?? '-' }}</div>
                        </div>

                        <div class="pv-row">
                            <div class="pv-label">ID Pembeli</div>
                            <div class="pv-value">{{ $pembeli->id_pembeli }}</div>
                        </div>

                    </div>

                    {{-- TOMBOL --}}
                    <div class="pv-actions">
                        <a href="{{ route('profil.edit') }}" class="pv-btn-edit">Edit Profil</a>
                        <a href="{{ route('dashboard.pembeli') }}" class="pv-btn-back">Kembali</a>
                    </div>

                </div>

                {{-- HAPUS AKUN --}}
                <div class="pv-danger">
                    <div class="pv-danger-title">Hapus Akun</div>
                    <div class="pv-danger-desc">
                        Akun dan data profil kamu akan dihapus permanen dan tidak bisa dikembalikan.
                    </div>

                    <button type="button" class="pv-btn-hapus" data-bs-toggle="modal" data-bs-target="#modalHapusAkun">
                        Hapus Akun Saya
                    </button>
                </div>
            </div>

            <div class="pv-deco" aria-hidden="true">
                <img src="{{ asset('images/pizza/pizza-2.png') }}" alt="" width="160"
                    style="display:block; margin:0 auto 22px; transform: rotate(10deg);">
                <img src="{{ asset('images/pizza/pizza-3.png') }}" alt="" width="140"
                    style="display:block; margin:0 auto 22px; transform: rotate(-8deg);">
            </div>
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
                        <input type="text" id="konfirmasiHapus" class="form-control" autocomplete="off"
                            placeholder="HAPUS">
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
        document.getElementById('konfirmasiHapus').addEventListener('input', function() {
            document.getElementById('tombolHapus').disabled = this.value.trim() !== 'HAPUS';
        });
    </script>
@endpush
