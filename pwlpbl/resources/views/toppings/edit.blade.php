@extends('dashboard.admin')

@section('title', 'Edit Topping')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">

            <div class="card-header py-3">
                <h5 class="mb-0 fw-bold">Edit Topping: {{ $topping->nama }}</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('toppings.update', $topping) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Topping</label>
                        <input type="text" name="nama" maxlength="100"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama', $topping->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Tambahan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" min="0" step="1"
                                class="form-control @error('harga') is-invalid @enderror"
                                value="{{ old('harga', (int) $topping->harga) }}" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" role="switch" name="sold_out"
                            id="sold_out" value="1" {{ old('sold_out', $topping->sold_out) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sold_out">
                            Tandai <strong>Sold Out</strong> (tidak bisa dipilih pembeli)
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('toppings.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning text-dark fw-semibold">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
