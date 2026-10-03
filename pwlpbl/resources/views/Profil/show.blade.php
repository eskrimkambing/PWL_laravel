<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 40px 16px; }
        .card { background: #fff; max-width: 480px; margin: 0 auto; padding: 32px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
        h2 { margin: 0 0 20px; }
        .baris { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; }
        .label { color: #6b7280; font-size: 14px; }
        .nilai { font-weight: 500; text-align: right; }
        .kosong { color: #9ca3af; font-style: italic; }
        .sukses { background: #dcfce7; color: #166534; padding: 10px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
        .tombol { display: inline-block; margin-top: 24px; padding: 10px 20px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .tombol:hover { background: #1d4ed8; }
        .tombol-hapus { width: 100%; padding: 10px 20px; background: #dc2626; color: #fff; border: 0; border-radius: 6px; font-size: 14px; cursor: pointer; }
        .tombol-hapus:hover { background: #b91c1c; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Profil Saya</h2>

        @if (session('sukses'))
            <div class="sukses">{{ session('sukses') }}</div>
        @endif

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <div class="baris">
            <span class="label">Email</span>
            <span class="nilai">{{ $pembeli->email }}</span>
        </div>
        <div class="baris">
            <span class="label">Password</span>
            <span class="nilai">{{ $passwordSamar }}</span>
        </div>
        <div class="baris">
            <span class="label">Nama</span>
            <span class="nilai {{ !$pembeli->nama ? 'kosong' : '' }}">
                {{ $pembeli->nama ?? 'Belum diisi' }}
            </span>
        </div>
        <div class="baris">
            <span class="label">No. Telepon</span>
            <span class="nilai {{ !$pembeli->no_telp ? 'kosong' : '' }}">
                {{ $pembeli->no_telp ?? 'Belum diisi' }}
            </span>
        </div>
        <div class="baris">
            <span class="label">Alamat</span>
            <span class="nilai {{ !$pembeli->alamat ? 'kosong' : '' }}">
                {{ $pembeli->alamat ?? 'Belum diisi' }}
            </span>
        </div>

        <a href="{{ route('profil.edit') }}" class="tombol">Edit</a>

        <form action="{{ route('profil.destroy') }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.');"
              style="margin-top: 10px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="tombol-hapus">Hapus Akun</button>
        </form>
    </div>
</body>
</html>