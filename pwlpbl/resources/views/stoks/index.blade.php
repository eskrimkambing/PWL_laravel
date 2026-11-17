@extends('dashboard.admin')

@section('title', 'Kelola Stok')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .stat-card .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: var(--moza-cream);
            font-size: 17px;
            flex-shrink: 0;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .stok-table thead th {
            background: #F9ECE8;
            color: var(--moza-maroon);
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
            padding: .85rem .75rem;
            border-bottom: 0;
        }

        .stok-table tbody td {
            vertical-align: middle;
            padding: .75rem;
            border-color: rgba(139, 26, 16, 0.08);
        }

        .stok-table tbody td+td {
            border-left: 1px solid rgba(139, 26, 16, 0.08);
        }

        .stok-table .col-aksi {
            width: 1%;
            white-space: nowrap;
            text-align: center;
        }

        .btn-aksi {
            font-size: 14px;
            font-weight: 600;
            border: 0;
            border-radius: 8px;
            padding: .35rem .85rem;
        }

        /* Tombol Edit dan Hapus hanya berisi ikon */
        .btn-aksi-icon {
            padding: .4rem .65rem;
            line-height: 1;
        }

        .btn-aksi-icon i {
            margin: 0;
            font-size: 15px;
        }

        .btn-aksi-stok {
            background: var(--moza-orange);
            color: #fff;
        }

        .btn-aksi-stok:hover {
            background: var(--moza-maroon);
            color: #fff;
        }

        .btn-aksi-edit {
            background: #F9ECE8;
            color: var(--moza-maroon);
        }

        .btn-aksi-edit:hover {
            background: var(--moza-cream);
            color: var(--moza-maroon);
        }

        .btn-aksi-edit i {
            color: var(--moza-red);
        }

        .btn-aksi-hapus {
            background: #E5575A;
            color: #fff;
        }

        .btn-aksi-hapus:hover {
            background: var(--moza-red);
            color: #fff;
        }

        .tanggal-wrap {
            width: 190px;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid">

        {{-- ===== HEADER ===== --}}
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

            <div>
                <h2 class="fw-bold mb-1">Kelola Stok Produk</h2>
                <p class="mb-0">Tambah stok harian dan kelola produk</p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-moza px-4 py-2">
                <i class="bi bi-plus-lg me-1"></i> Tambah Produk
            </a>

        </div>


        {{-- ===== PESAN ===== --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- ===== KARTU RINGKASAN ===== --}}
        <div class="row g-3 mb-3">

            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="stat-icon d-flex align-items-center justify-content-center">🍕</div>
                        <div>
                            <div>Total Produk</div>
                            <div class="stat-value">{{ $totalProduk }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="stat-icon d-flex align-items-center justify-content-center">📦</div>
                        <div>
                            <div>Total Stok Keseluruhan</div>
                            <div class="stat-value">{{ $totalStok }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- ===== DAFTAR PRODUK ===== --}}
        <div class="card overflow-hidden">

            <div class="card-header bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">

                <h5 class="fw-bold mb-0">Daftar Produk</h5>

                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-event"></i>
                    <label for="tanggalStok" class="small mb-0 text-body">Tambah Stok (Tanggal)</label>
                    <input type="date" id="tanggalStok" class="form-control form-control-sm tanggal-wrap"
                        value="{{ now()->format('Y-m-d') }}">
                </div>

            </div>

            <div class="table-responsive">

                <table class="table stok-table mb-0">

                    <thead>
                        <tr>
                            <th style="width: 7%">No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th style="width: 14%">Stok</th>
                            <th colspan="3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($products as $product)
                            <tr>

                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td class="fs-6">{{ $product->nama }}</td>

                                <td>{{ $product->kategori }}</td>

                                <td class="text-center fs-6">
                                    {{ max(0, (int) $product->total_stok) }}
                                </td>

                                {{-- + Stok --}}
                                <td class="col-aksi">
                                    <button type="button" class="btn btn-aksi btn-aksi-stok btn-tambah-stok"
                                        data-id="{{ $product->id }}" data-nama="{{ $product->nama }}">
                                        <i class="bi bi-plus-lg me-1"></i> Stok
                                    </button>
                                </td>

                                {{-- Edit (ikon saja) --}}
                                <td class="col-aksi">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-aksi btn-aksi-edit btn-aksi-icon" title="Edit"
                                        aria-label="Edit {{ $product->nama }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                </td>

                                {{-- Hapus (ikon saja) --}}
                                <td class="col-aksi">
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Hapus produk {{ addslashes($product->nama) }}? Seluruh data stoknya juga akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-aksi btn-aksi-hapus btn-aksi-icon"
                                            title="Hapus" aria-label="Hapus {{ $product->nama }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">
                                    Belum ada produk.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ===== MODAL TAMBAH STOK ===== --}}
    <div class="modal fade" id="modalTambahStok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('stoks.store') }}" method="POST" class="modal-content">

                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="tanggal_stok" id="modalTanggal">
                <input type="hidden" name="status_stok" value="Tersedia">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <div class="small text-secondary">Produk</div>
                        <div class="fw-semibold fs-5" id="modalNamaProduk"></div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-secondary">Tanggal stok</div>
                        <div class="fw-semibold" id="modalTanggalText"></div>
                    </div>

                    <div>
                        <label for="modalJumlah" class="form-label fw-semibold">Jumlah stok yang ditambah</label>
                        <input type="number" name="jumlah_stok" id="modalJumlah" class="form-control" min="1"
                            value="1" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-moza px-4">Simpan</button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function() {
            const modalEl = document.getElementById('modalTambahStok');
            const modal = new bootstrap.Modal(modalEl);
            const tanggalInput = document.getElementById('tanggalStok');

            document.querySelectorAll('.btn-tambah-stok').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    // Tanggal wajib diisi dulu
                    if (!tanggalInput.value) {
                        tanggalInput.classList.add('is-invalid');
                        tanggalInput.focus();
                        return;
                    }
                    tanggalInput.classList.remove('is-invalid');

                    const [y, m, d] = tanggalInput.value.split('-');

                    document.getElementById('modalProductId').value = btn.dataset.id;
                    document.getElementById('modalNamaProduk').textContent = btn.dataset.nama;
                    document.getElementById('modalTanggal').value = tanggalInput.value;
                    document.getElementById('modalTanggalText').textContent = d + '/' + m + '/' + y;
                    document.getElementById('modalJumlah').value = 1;

                    modal.show();
                });
            });

            tanggalInput.addEventListener('input', function() {
                tanggalInput.classList.remove('is-invalid');
            });

            modalEl.addEventListener('shown.bs.modal', function() {
                const jumlah = document.getElementById('modalJumlah');
                jumlah.focus();
                jumlah.select();
            });
        })();
    </script>
@endpush
