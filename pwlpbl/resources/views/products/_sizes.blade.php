{{-- Ukuran & harga produk (bisa lebih dari satu). Dipakai di form tambah dan edit. --}}
@php
    $daftarUkuran = old('sizes');

    if ($daftarUkuran === null) {
        $daftarUkuran = isset($product)
            ? $product->sizes->map(fn ($s) => ['nama' => $s->nama, 'harga' => (int) $s->harga])->all()
            : [];
    }

    if (count($daftarUkuran) === 0) {
        $daftarUkuran = [['nama' => '', 'harga' => '']];
    }
@endphp

<div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <label class="form-label fw-semibold mb-0">Ukuran &amp; Harga</label>

        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnTambahUkuran">
            + Tambah Ukuran
        </button>
    </div>

    <small class="text-secondary d-block mb-2">
        Satu menu bisa punya beberapa ukuran, masing-masing dengan harga sendiri
        (contoh: Small 45000, Medium 55000, Large 70000). Menu tanpa pilihan ukuran cukup diisi satu baris.
    </small>

    @if ($errors->has('sizes') || $errors->has('sizes.*'))
        <div class="text-danger small mb-2">
            @foreach (collect($errors->get('sizes'))->merge(collect($errors->get('sizes.*'))->flatten())->unique() as $pesan)
                <div>{{ $pesan }}</div>
            @endforeach
        </div>
    @endif

    <div id="ukuranList">
        @foreach ($daftarUkuran as $i => $u)
            <div class="row g-2 align-items-center mb-2 ukuran-row">
                <div class="col-6">
                    <input type="text" name="sizes[{{ $i }}][nama]" class="form-control"
                        placeholder="Nama ukuran, mis. Large" maxlength="50"
                        value="{{ $u['nama'] ?? '' }}" required>
                </div>

                <div class="col-5">
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="sizes[{{ $i }}][harga]" class="form-control"
                            placeholder="Harga" min="0" step="1"
                            value="{{ $u['harga'] ?? '' }}" required>
                    </div>
                </div>

                <div class="col-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-hapus-ukuran"
                        title="Hapus ukuran" aria-label="Hapus ukuran">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14M10 11v6M14 11v6" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const list = document.getElementById('ukuranList');
        let next = list.querySelectorAll('.ukuran-row').length;

        function sisaBaris() { return list.querySelectorAll('.ukuran-row').length; }

        function toggleHapus() {
            const satu = sisaBaris() <= 1;
            list.querySelectorAll('.btn-hapus-ukuran').forEach(b => b.disabled = satu);
        }

        document.getElementById('btnTambahUkuran').addEventListener('click', function () {
            const first = list.querySelector('.ukuran-row');
            const row = first.cloneNode(true);

            row.querySelectorAll('input').forEach(inp => {
                inp.value = '';
                inp.name = inp.name.replace(/sizes\[\d+\]/, 'sizes[' + next + ']');
            });

            next++;
            list.appendChild(row);
            toggleHapus();
            row.querySelector('input').focus();
        });

        list.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-hapus-ukuran');
            if (!btn || sisaBaris() <= 1) return;
            btn.closest('.ukuran-row').remove();
            toggleHapus();
        });

        toggleHapus();
    })();
</script>
@endpush
