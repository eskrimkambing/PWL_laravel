<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 40px 16px; }
        .card { background: #fff; max-width: 480px; margin: 0 auto; padding: 32px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
        h2 { margin: 0 0 20px; }
        label { display: block; margin-bottom: 6px; font-size: 14px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; font-family: inherit; }
        textarea { min-height: 90px; resize: vertical; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .error ul { margin: 0; padding-left: 18px; }
        .tombol-grup { display: flex; gap: 10px; }
        button { flex: 1; padding: 11px; background: #2563eb; color: #fff; border: 0; border-radius: 6px; font-size: 15px; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        .batal { flex: 1; padding: 11px; text-align: center; background: #e5e7eb; color: #111827; text-decoration: none; border-radius: 6px; font-size: 15px; }
        .batal:hover { background: #d1d5db; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Profil</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $pembeli->nama) }}">

            <label for="no_telp">No. Telepon</label>
            <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $pembeli->no_telp) }}">

            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat">{{ old('alamat', $pembeli->alamat) }}</textarea>

            <div class="tombol-grup">
                <a href="{{ route('profil.show') }}" class="batal">Batal</a>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>