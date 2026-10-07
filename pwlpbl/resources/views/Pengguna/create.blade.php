
@extends('dashboard.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-transparent py-3">
                    <h4 class="mb-1">Tambah Pengguna</h4>
                    <p class="text-muted mb-0">
                        Tambahkan akun admin atau pembeli baru.
                    </p>
                </div>

                <div class="card-body p-4">

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi kesalahan:</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.store') }}" method="POST">
                        @csrf

                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                Role
                            </label>

                            <select
                                name="role"
                                id="role"
                                class="form-select"
                                required
                                onchange="toggleFieldPembeli()"
                            >
                                <option value="">-- Pilih Role --</option>

                                <option
                                    value="admin"
                                    {{ old('role') == 'admin' ? 'selected' : '' }}
                                >
                                    Admin
                                </option>

                                <option
                                    value="pembeli"
                                    {{ old('role') == 'pembeli' ? 'selected' : '' }}
                                >
                                    Pembeli
                                </option>
                            </select>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                Password <span class="text-danger">*</span>
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                required
                            >
                        </div>

                        {{-- Field khusus pembeli --}}
                        <div id="field-pembeli" style="display: none;">

                            <hr>

                            <p class="text-muted small">
                                Field di bawah ini opsional (khusus akun pembeli).
                            </p>

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama
                                </label>

                                <input
                                    type="text"
                                    name="nama"
                                    id="nama"
                                    class="form-control"
                                    value="{{ old('nama') }}"
                                >
                            </div>

                            {{-- No Telepon --}}
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">
                                    No. Telepon
                                </label>

                                <input
                                    type="text"
                                    name="no_telp"
                                    id="no_telp"
                                    class="form-control"
                                    value="{{ old('no_telp') }}"
                                >
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label for="alamat" class="form-label">
                                    Alamat
                                </label>

                                <textarea
                                    name="alamat"
                                    id="alamat"
                                    class="form-control"
                                    rows="3"
                                >{{ old('alamat') }}</textarea>
                            </div>

                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">

                            <a
                                href="{{ route('pengguna.index') }}"
                                class="btn btn-secondary"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Simpan
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function toggleFieldPembeli() {
        const role = document.getElementById('role').value;
        const fieldPembeli = document.getElementById('field-pembeli');

        if (role === 'pembeli') {
            fieldPembeli.style.display = 'block';
        } else {
            fieldPembeli.style.display = 'none';
        }
    }

    // Jalankan saat halaman pertama kali dibuka
    toggleFieldPembeli();
</script>
@endpush

