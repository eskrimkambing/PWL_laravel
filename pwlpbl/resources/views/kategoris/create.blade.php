<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kategori | Pizza Moza</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f5f7;
            color: #333;
        }

        .container {
            width: 92%;
            max-width: 650px;
            margin: 50px auto;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header p {
            margin: 7px 0 0;
            color: #777;
            font-size: 14px;
        }

        .form-card {
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d5d5d5;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #e85d04;
        }

        .form-group small {
            display: block;
            margin-top: 7px;
            color: #888;
            font-size: 12px;
        }

        .error {
            margin-top: 7px;
            color: #dc3545;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 10px;
            padding-top: 5px;
        }

        .btn {
            padding: 10px 17px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }

        .btn-save {
            background: #e85d04;
            color: white;
        }

        .btn-save:hover {
            background: #d45103;
        }

        .btn-cancel {
            background: white;
            color: #555;
            border: 1px solid #d5d5d5;
        }

        .btn-cancel:hover {
            background: #f1f1f1;
        }

        @media (max-width: 600px) {

            .container {
                width: 94%;
                margin: 30px auto;
            }

            .form-card {
                padding: 22px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="page-header">
        <h1>Tambah Kategori</h1>
        <p>Tambahkan kategori baru untuk menu Pizza Moza.</p>
    </div>


    <div class="form-card">

        <form action="{{ route('kategoris.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="nama_kategori">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="{{ old('nama_kategori') }}"
                    placeholder="Contoh: Pizza"
                    required
                >

                <small>
                    Masukkan nama kategori yang ingin ditambahkan.
                </small>

                @error('nama_kategori')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="actions">

                <button type="submit" class="btn btn-save">
                    Simpan Kategori
                </button>

                <a href="{{ route('kategoris.index') }}"
                   class="btn btn-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>