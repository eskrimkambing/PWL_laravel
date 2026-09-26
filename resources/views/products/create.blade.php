@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Tambah Menu Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Menu</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Pizza Super Cheese" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori Menu</label>
                            <select name="category" class="form-select" required>
                                <option value="Pizza">Pizza</option>
                                <option value="Tape Bakar">Tape Bakar</option>
                                <option value="Singkong Keju">Singkong Keju</option>
                                <option value="Minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Porsi / Ukuran</label>
                            <input type="text" name="portion" class="form-control" placeholder="Contoh: Large (4 Orang)" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" placeholder="Contoh: 35000" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Menu</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Keterangan bahan dan topping"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-dark">Simpan Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection