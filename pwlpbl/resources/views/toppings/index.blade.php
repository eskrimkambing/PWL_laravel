@extends('dashboard.admin')

@section('title', 'Kelola Topping')

@section('content')

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tambah topping --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-1 fw-bold">Topping Tambahan Pizza</h5>
                <small class="text-muted">
                    Topping di bawah ini bisa dipilih pembeli saat memesan pizza.
                    Tandai "Sold Out" bila topping sedang habis.
                </small>
            </div>

            <div class="card-body">
                <form action="{{ route('toppings.store') }}" method="POST" class="row g-2 align-items-end">
                    @csrf

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Topping</label>
                        <input type="text" name="nama" class="form-control" maxlength="100"
                            placeholder="Contoh: Extra Keju" value="{{ old('nama') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Harga Tambahan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" class="form-control" min="0" step="1"
                                placeholder="5000" value="{{ old('harga') }}" required>
                        </div>
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-moza">+ Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Daftar topping --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th>Nama Topping</th>
                                <th>Harga</th>
                                <th>Ketersediaan</th>
                                <th class="text-center" style="width: 18%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($toppings as $i => $t)
                                <tr>
                                    <td class="text-center fw-bold">{{ $i + 1 }}</td>

                                    <td class="fw-semibold {{ $t->sold_out ? 'text-muted' : '' }}">
                                        {{ $t->nama }}
                                    </td>

                                    <td class="fw-bold text-success">
                                        + Rp {{ number_format($t->harga, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @if ($t->sold_out)
                                            <span class="badge bg-danger">Sold Out</span>
                                        @else
                                            <span class="badge bg-success">Tersedia</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="aksi-group">

                                            {{-- Sold Out / tersedia kembali --}}
                                            <form action="{{ route('toppings.sold-out', $t) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-aksi btn-aksi-icon {{ $t->sold_out ? 'btn-aksi-stok' : 'btn-aksi-edit' }}"
                                                    title="{{ $t->sold_out ? 'Tandai tersedia' : 'Tandai Sold Out' }}"
                                                    aria-label="{{ $t->sold_out ? 'Tandai tersedia' : 'Tandai Sold Out' }}">
                                                    <i
                                                        class="bi {{ $t->sold_out ? 'bi-check-lg' : 'bi-slash-circle' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Edit --}}
                                            <a href="{{ route('toppings.edit', $t) }}"
                                                class="btn btn-aksi btn-aksi-edit btn-aksi-icon" title="Edit"
                                                aria-label="Edit {{ $t->nama }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('toppings.destroy', $t) }}" method="POST"
                                                onsubmit="return confirm('Hapus topping ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-aksi btn-aksi-hapus btn-aksi-icon"
                                                    title="Hapus" aria-label="Hapus {{ $t->nama }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada topping. Tambahkan topping pertama di atas.
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
