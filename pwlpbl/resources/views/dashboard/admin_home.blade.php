@extends('dashboard.admin')

@section('title', 'Beranda Admin')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            Dashboard Admin
        </h3>

        <p class="text-secondary mb-0">
            Selamat datang di halaman pengelolaan Pizza Moza.
        </p>
    </div>


    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">

                    <div class="text-secondary mb-2">
                        Total Produk
                    </div>

                    <h3 class="fw-bold mb-0">
                        {{ $totalProduk }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">

                    <div class="text-secondary mb-2">
                        Total Kategori
                    </div>

                    <h3 class="fw-bold mb-0">
                        {{ $totalKategori }}
                    </h3>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">

                    <div class="text-secondary mb-2">
                        Total Pembeli
                    </div>

                    <h3 class="fw-bold mb-0">
                        {{ $totalPembeli }}
                    </h3>

                </div>
            </div>
        </div>

    </div>


    <div class="card">

        <div class="card-header bg-transparent py-3">

            <h5 class="fw-bold mb-1">
                Produk Pizza Moza
            </h5>

            <small class="text-secondary">
                Daftar menu produk Pizza Moza
            </small>

        </div>


        <div class="card-body">

            <div class="row g-3">

                @forelse ($products as $item)

                    @php

                        $fotoPizza = [
                            'Extra Chicken' => 'extra-chicken.jpeg',
                            'Cheese Volcano' => 'cheese-volcano.jpeg',
                            'Ekstra Beef' => 'ekstra-beef.jpeg',
                            'Original Mozza' => 'original-mozza.jpeg',
                            'Original Cheese Volcano' => 'original-cheese-volcano.jpeg',
                            'Long Pizza' => 'long-pizza.jpeg',
                        ];

                        $fotoCemilan = [
                            'Tape Bakar Original' => 'tape-bakar-original.jpeg',
                            'Singkong Keju' => 'singkong-keju.jpeg',
                            'Tape Bakar Topping Keju' => 'tape-bakar-topping-keju.jpeg',
                        ];

                        if (isset($fotoPizza[$item->name])) {

                            $pathFoto = 'images/pizza/' . $fotoPizza[$item->name];

                        } elseif (isset($fotoCemilan[$item->name])) {

                            $pathFoto = 'images/cemilan/' . $fotoCemilan[$item->name];

                        } else {

                            $pathFoto = 'images/pizza.jpg';

                        }

                    @endphp


                    <div class="col-md-6 col-lg-4 col-xl-3">

                        <div class="card h-100 overflow-hidden">

                            <img
                                src="{{ asset($pathFoto) }}"
                                alt="{{ $item->name }}"
                                style="
                                    width: 100%;
                                    height: 180px;
                                    object-fit: cover;
                                "
                            >

                            <div class="card-body">

                                <h6 class="fw-bold mb-1">
                                    {{ $item->name }}
                                </h6>

                                <small class="text-secondary d-block mb-2">
                                    {{ $item->category }}
                                </small>

                                @if ($item->description)

                                    <p class="text-secondary small mb-3">
                                        {{ $item->description }}
                                    </p>

                                @endif

                                <div class="fw-bold">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center text-secondary py-4">
                        Belum ada produk.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection
