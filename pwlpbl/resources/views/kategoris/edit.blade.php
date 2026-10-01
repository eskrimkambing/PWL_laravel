<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
</head>
<body>

    <h1>Edit Kategori</h1>

    @if($errors->any())
        <div>
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form
        action="{{ route('kategoris.update', $kategori->id_kategori) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <label>Nama Kategori</label>
        <br>

        <input
            type="text"
            name="nama_kategori"
            value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
            required
        >

        <br><br>

        <button type="submit">Update</button>

        <a href="{{ route('kategoris.index') }}">
            Batal
        </a>
    </form>

</body>
</html>