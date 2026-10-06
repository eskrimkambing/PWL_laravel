<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pembeli - Pizza Moza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Data Pembeli</h3>
            <p class="text-muted mb-0">
                Daftar pembeli Pizza Moza
            </p>
        </div>

        <a href="{{ route('pembelis.create') }}" class="btn btn-dark">
            + Tambah Pembeli
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pembelis as $pembeli)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $pembeli->nama }}</td>

                                <td>{{ $pembeli->email }}</td>

                                <td>{{ $pembeli->no_telp ?? '-' }}</td>

                                <td>{{ $pembeli->alamat ?? '-' }}</td>

                                <td>
                                    <a href="{{ route('pembelis.show', $pembeli->id_pembeli) }}"
                                       class="btn btn-sm btn-secondary">
                                        Detail
                                    </a>

                                    <a href="{{ route('pembelis.edit', $pembeli->id_pembeli) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('pembelis.destroy', $pembeli->id_pembeli) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data pembeli.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
