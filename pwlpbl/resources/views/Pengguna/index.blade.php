@extends('dashboard.admin')

@section('title', 'Kelola Pengguna')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Kelola Pengguna</h2>
        <p class="text-secondary mb-0">
            Kelola data admin dan pembeli.
        </p>
    </div>

    <a href="{{ route('pengguna.create') }}" class="btn btn-moza">
        + Tambah Pengguna
    </a>
</div>

@if (session('sukses'))
    <div class="alert alert-success">
        {{ session('sukses') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- ================= ADMIN ================= --}}
<div class="card p-4 mb-4">

    <h5 class="mb-3">Admin</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Email</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($admins as $admin)
                    <tr>
                        <td>{{ $admin->email }}</td>

                        <td>
                            <a href="{{ route('pengguna.edit', [
                                'role' => 'admin',
                                'id' => $admin->id_admin
                            ]) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('pengguna.destroy', [
                                'role' => 'admin',
                                'id' => $admin->id_admin
                            ]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus akun admin ini?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2"
                            class="text-center text-secondary">
                            Belum ada data admin
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


{{-- ================= PEMBELI ================= --}}
<div class="card p-4">

    <h5 class="mb-3">Pembeli</h5>

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pembelis as $pembeli)

                    <tr>
                        <td>{{ $pembeli->email }}</td>

                        <td>
                            {{ $pembeli->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $pembeli->no_telp ?? '-' }}
                        </td>

                        <td>
                            {{ $pembeli->alamat ?? '-' }}
                        </td>

                        <td>

                            <a href="{{ route('pengguna.edit', [
                                'role' => 'pembeli',
                                'id' => $pembeli->id_pembeli
                            ]) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('pengguna.destroy', [
                                'role' => 'pembeli',
                                'id' => $pembeli->id_pembeli
                            ]) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus akun pembeli ini?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger">
                                    Hapus
                                </button>

                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            class="text-center text-secondary">
                            Belum ada data pembeli
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

</div>


@endsection
