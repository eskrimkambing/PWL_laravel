<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kategori | Pizza Moza</title>

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
            max-width: 1000px;
            margin: 35px auto;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .page-header p {
            margin: 6px 0 0;
            color: #777;
            font-size: 14px;
        }

        /* Tombol */
        .btn {
            display: inline-block;
            padding: 9px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-back {
            background: #fff;
            color: #555;
            border: 1px solid #ddd;
        }

        .btn-back:hover {
            background: #f0f0f0;
        }

        .btn-add {
            background: #e85d04;
            color: white;
        }

        .btn-add:hover {
            background: #d45103;
        }

        .btn-edit {
            background: #f1f3f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-edit:hover {
            background: #e2e6ea;
        }

        .btn-delete {
            background: #fff;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* Toolbar */
        .toolbar {
            background: white;
            padding: 15px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            gap: 15px;
        }

        .search {
            width: 280px;
            padding: 9px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            font-size: 14px;
        }

        .search:focus {
            border-color: #e85d04;
        }

        .total {
            font-size: 14px;
            color: #777;
        }

        .total strong {
            color: #333;
        }

        /* Alert */
        .alert {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
            padding: 11px 14px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        /* Table */
        .table-box {
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fafafa;
            color: #555;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            padding: 14px 16px;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #fafafa;
        }

        .number {
            width: 70px;
            color: #777;
        }

        .category-name {
            font-weight: 500;
        }

        .actions {
            display: flex;
            gap: 7px;
        }

        /* Kosong */
        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #888;
        }

        /* Responsive */
        @media (max-width: 650px) {

            .page-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .search {
                width: 100%;
            }

            .table-box {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Header --}}
    <div class="page-header">

        <div>
            <h1>Kategori Menu</h1>
            <p>Daftar kategori produk Pizza Moza</p>
        </div>

        <div>
            <a href="{{ session('role') === 'admin'
                ? route('dashboard.admin')
                : route('dashboard.pembeli') }}"
               class="btn btn-back">
                Kembali
            </a>

            @if(session('role') === 'admin')
                <a href="{{ route('kategoris.create') }}"
                   class="btn btn-add">
                    + Tambah Kategori
                </a>
            @endif
        </div>

    </div>


    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif


    {{-- Toolbar --}}
    <div class="toolbar">

        <input
            type="text"
            id="searchKategori"
            class="search"
            placeholder="Cari kategori..."
        >

        <div class="total">
            Total kategori:
            <strong>{{ $kategoris->count() }}</strong>
        </div>

    </div>


    {{-- Tabel --}}
    <div class="table-box">

        <table id="tabelKategori">

            <thead>
                <tr>
                    <th class="number">No</th>
                    <th>Nama Kategori</th>

                    @if(session('role') === 'admin')
                        <th width="180">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody>

                @forelse($kategoris as $index => $kategori)

                    <tr>

                        <td class="number">
                            {{ $index + 1 }}
                        </td>

                        <td class="category-name">
                            {{ $kategori->nama_kategori }}
                        </td>

                        @if(session('role') === 'admin')

                            <td>

                                <div class="actions">

                                    <a href="{{ route('kategoris.edit', $kategori->id_kategori) }}"
                                       class="btn btn-edit">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('kategoris.destroy', $kategori->id_kategori) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-delete">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        @endif

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="{{ session('role') === 'admin' ? 3 : 2 }}"
                            class="empty"
                        >
                            Belum ada kategori.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<script>

    document
        .getElementById('searchKategori')
        .addEventListener('keyup', function () {

            const keyword = this.value.toLowerCase();

            const rows = document.querySelectorAll(
                '#tabelKategori tbody tr'
            );

            rows.forEach(function (row) {

                const nama = row.querySelector('.category-name');

                if (nama) {

                    const text =
                        nama.textContent.toLowerCase();

                    row.style.display =
                        text.includes(keyword) ? '' : 'none';

                }

            });

        });

</script>

</body>
</html>