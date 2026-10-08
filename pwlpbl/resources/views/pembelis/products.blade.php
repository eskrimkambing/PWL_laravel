@extends('layouts.pembeli')

@section('title', 'Produk')

@push('styles')
<style>
    .product-image {
        width: 100%;
        height: 170px;
        object-fit: cover;
        background: var(--bs-tertiary-bg);
    }

    .product-description {
        font-size: 14px;
        line-height: 1.5;
        min-height: 42px;
    }
</style>
@endpush

@section('content')

    @php
        // FOTO PIZZA
        $fotoPizza = [
            'Extra Chicken' => 'extra-chicken.jpeg',
            'Cheese Volcano' => 'cheese-volcano.jpeg',
            'Ekstra Beef' => 'ekstra-beef.jpeg',
            'Original Mozza' => 'original-mozza.jpeg',
            'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
            'Long Pizza' => 'long-pizza.jpeg',
        ];

        // FOTO CEMILAN
        $fotoCemilan = [
            'Tape Bakar Original' => 'tape-bakar-original.jpeg',
            'Singkong Keju' => 'singkong-keju.jpeg',
            'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
        ];
    @endphp

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Produk Pizza Moza</h2>
        <p class="text-secondary mb-0">Pilih produk yang ingin kamu pesan.</p>
    </div>

    {{-- SEARCH --}}
    <input type="text" id="search" class="form-control mb-4"
           style="max-width: 450px;" placeholder="Cari produk..." onkeyup="cariProduk()">

    {{-- PRODUCTS --}}
    <div class="row g-3" id="productList">

        @forelse ($products as $product)

            @php
                if (isset($fotoPizza[$product->name])) {
                    $pathFoto = 'images/pizza/' . $fotoPizza[$product->name];
                } elseif (isset($fotoCemilan[$product->name])) {
                    $pathFoto = 'images/cemilan/' . $fotoCemilan[$product->name];
                } else {
                    $pathFoto = 'images/pizza.jpg';
                }
            @endphp

            <div class="col-sm-6 col-lg-4 col-xxl-3 product-item">
                <div class="card h-100 overflow-hidden">

                    <img src="{{ asset($pathFoto) }}"
                         alt="{{ $product->name }}"
                         class="product-image">

                    <div class="card-body d-flex flex-column">
                        <div class="product-name fs-5 fw-bold mb-1">{{ $product->name }}</div>
                        <small class="text-secondary mb-2">{{ $product->category }}</small>

                        <div class="product-description text-secondary">
                            {{ $product->description ?? 'Produk Pizza Moza' }}
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                            <div class="fw-bold">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <a href="{{ route('checkout.index') }}" class="btn btn-moza btn-sm">Pesan</a>
                        </div>
                    </div>

                </div>
            </div>

        @empty

            <div class="col-12 text-secondary py-4">
                Belum ada produk yang tersedia.
            </div>

        @endforelse

    </div>

@endsection

@push('scripts')
<script>
    function cariProduk() {
        const input = document.getElementById('search').value.toLowerCase();

        document.querySelectorAll('.product-item').forEach(function (item) {
            const nama = item.querySelector('.product-name').textContent.toLowerCase();
            item.style.display = nama.includes(input) ? '' : 'none';
        });
    }
</script>
@endpush