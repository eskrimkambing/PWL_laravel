<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Kelola Pengguna</h2>
            <a href="{{ route('pengguna.create') }}" class="btn btn-primary">+ Tambah Pengguna</a>
        </div>

        @if (session('sukses'))
            <div class="alert alert-success">{{ session('sukses') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h5 class="mt-4">Admin</h5>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
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
                            <a href="{{ route('pengguna.edit', ['role' => 'admin', 'id' => $admin->id_admin]) }}"
                               class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pengguna.destroy', ['role' => 'admin', 'id' => $admin->id_admin]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus akun admin ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center text-muted">Belum ada data admin</td></tr>
                @endforelse
            </tbody>
        </table>

        <h5 class="mt-5">Pembeli</h5>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
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
                        <td>{{ $pembeli->nama ?? '-' }}</td>
                        <td>{{ $pembeli->no_telp ?? '-' }}</td>
                        <td>{{ $pembeli->alamat ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pengguna.edit', ['role' => 'pembeli', 'id' => $pembeli->id_pembeli]) }}"
                               class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pengguna.destroy', ['role' => 'pembeli', 'id' => $pembeli->id_pembeli]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus akun pembeli ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data pembeli</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
