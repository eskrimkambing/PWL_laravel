
@extends('dashboard.admin')

@section('title', 'Kategori')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="mb-1">Kategori Menu</h2>

            <p class="text-muted mb-0">
                Daftar kategori produk Pizza Moza
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ session('role') === 'admin'
                    ? route('dashboard.admin')
                    : route('dashboard.pembeli') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

            @if(session('role') === 'admin')
                <a
                    href="{{ route('kategoris.create') }}"
                    class="btn btn-primary"
                >
                    + Tambah Kategori
                </a>
            @endif

        </div>

    </div>


    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>
    @endif


    {{-- Toolbar --}}
    <div class="card shadow-sm border-0 mb-3">

        <div class="card-body">

            <div class="row align-items-center g-3">

                <div class="col-12 col-md-6">

                    <input
                        type="text"
                        id="searchKategori"
                        class="form-control"
                        placeholder="Cari kategori..."
                    >

                </div>

                <div class="col-12 col-md-6 text-md-end">

                    <span class="text-muted">
                        Total kategori:
                        <strong>{{ $kategoris->count() }}</strong>
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- Tabel Kategori --}}
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    id="tabelKategori"
                    class="table table-hover align-middle mb-0"
                >

                    <thead>
                        <tr>

                            <th
                                style="width: 80px;"
                                class="ps-4"
                            >
                                No
                            </th>

                            <th>
                                Nama Kategori
                            </th>

                            @if(session('role') === 'admin')
                                <th
                                    style="width: 180px;"
                                >
                                    Aksi
                                </th>
                            @endif

                        </tr>
                    </thead>


                    <tbody>

                        @forelse($kategoris as $index => $kategori)

                            <tr>

                                <td class="ps-4 text-muted">
                                    {{ $index + 1 }}
                                </td>

                                <td class="category-name fw-semibold">
                                    {{ $kategori->nama_kategori }}
                                </td>


                                @if(session('role') === 'admin')

                                    <td>

                                        <div class="d-flex gap-2">

                                            {{-- Edit --}}
                                            <a
                                                href="{{ route('kategoris.edit', $kategori->id_kategori) }}"
                                                class="btn btn-sm btn-outline-primary"
                                            >
                                                Edit
                                            </a>


                                            {{-- Hapus --}}
                                            <form
                                                action="{{ route('kategoris.destroy', $kategori->id_kategori) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
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
                                    class="text-center text-muted py-5"
                                >
                                    Belum ada kategori.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

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

@endpush

