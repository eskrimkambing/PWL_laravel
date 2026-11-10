@extends('dashboard.admin')

@section('title', 'Beranda Admin')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">
            <h3 class="fw-bold mb-1">Dashboard Admin</h3>
            <p class="text-secondary mb-0">Selamat datang di halaman pengelolaan Pizza Moza.</p>
        </div>

        {{-- ===== Kartu total (tetap) ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-secondary mb-2">Total Produk</div>
                        <h3 class="fw-bold mb-0">{{ $totalProduk }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-secondary mb-2">Total Kategori</div>
                        <h3 class="fw-bold mb-0">{{ $totalKategori }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-secondary mb-2">Total Pembeli</div>
                        <h3 class="fw-bold mb-0">{{ $totalPembeli }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Pendapatan + Rekap Pesanan ===== --}}
        <div class="row g-3 mb-4">

            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Pendapatan</h5>
                                <small class="text-secondary" id="subPendapatan"></small>
                            </div>
                            <select id="rentangPendapatan" class="form-select form-select-sm" style="width:auto;">
                                <option value="hari" selected>Hari ini</option>
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6">6 Bulan</option>
                                <option value="12">1 Tahun</option>
                            </select>
                        </div>
                        <div style="position:relative; height:300px;">
                            <canvas id="chartPendapatan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Rekap Pesanan</h5>
                        <div style="position:relative; height:220px;">
                            <canvas id="chartPesanan"></canvas>
                        </div>
                        <div class="row text-center mt-3 g-2">
                            <div class="col-4">
                                <div class="fs-4 fw-bold" style="color:#DE7801;">{{ $pesananSelesai }}</div>
                                <small class="text-secondary">Selesai</small>
                            </div>
                            <div class="col-4">
                                <div class="fs-4 fw-bold" style="color:#F7D991;">{{ $pesananBelum }}</div>
                                <small class="text-secondary">Belum selesai</small>
                            </div>
                            <div class="col-4">
                                <div class="fs-4 fw-bold" style="color:#c0392b;">{{ $pesananBatal }}</div>
                                <small class="text-secondary">Dibatalkan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== Produk terlaris, kategori, pengguna ===== --}}
        <div class="row g-3 mb-4">

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">Produk Terlaris</h5>
                        <small class="text-secondary d-block mb-3">Jumlah terjual (kecuali pesanan batal)</small>
                        @if (count($dataTerlaris))
                            <div style="position:relative; height:240px;"><canvas id="chartTerlaris"></canvas></div>
                        @else
                            <div class="text-secondary text-center py-5">Belum ada penjualan.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">Produk per Kategori</h5>
                        <small class="text-secondary d-block mb-3">Sebaran menu berdasarkan kategori</small>
                        @if (count($dataKategori))
                            <div style="position:relative; height:240px;"><canvas id="chartKategori"></canvas></div>
                        @else
                            <div class="text-secondary text-center py-5">Belum ada produk.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">Pengguna</h5>
                        <small class="text-secondary d-block mb-3">Admin dan pembeli terdaftar</small>
                        <div style="position:relative; height:240px;"><canvas id="chartPengguna"></canvas></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== Stok + Transaksi terakhir ===== --}}
        <div class="row g-3 mb-4">

            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-1">Stok Produk</h5>
                        <small class="text-secondary d-block mb-3">8 produk dengan stok paling sedikit</small>
                        @if (count($dataStok))
                            <div style="position:relative; height:300px;"><canvas id="chartStok"></canvas></div>
                        @else
                            <div class="text-secondary text-center py-5">Belum ada data stok.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Transaksi Terakhir</h5>
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-sm btn-moza">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Pesanan</th>
                                        <th>Pembeli</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaksiTerakhir as $t)
                                        <tr>
                                            <td>
                                                #{{ $t['id'] }}
                                                <div class="small text-secondary">{{ $t['waktu'] }}</div>
                                            </td>
                                            <td>{{ $t['pembeli'] }}</td>
                                            <td>
                                                Rp {{ number_format($t['total'], 0, ',', '.') }}
                                                <div class="small text-secondary">{{ $t['metode'] }}</div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $t['status'] === 'Dibayar' ? 'bg-success' : ($t['status'] === 'Gagal' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                    {{ $t['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-secondary py-4">Belum ada
                                                transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            const rupiah = v => 'Rp ' + Number(v).toLocaleString('id-ID');
            const sum = arr => arr.reduce((a, b) => a + b, 0);
            const palet = ['#DE7801', '#F7D991', '#c0392b', '#8e5a2b', '#e9a35b', '#6A0801'];

            // Ikut warna teks tema (gelap/terang) dari layout
            Chart.defaults.color = getComputedStyle(document.body).color;
            Chart.defaults.borderColor = 'rgba(128,128,128,.2)';
            Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;

            const donat = (id, labels, data, warna) => new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: warna,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // ===== Pendapatan =====
            const labelHari = @json($labelHari);
            const dataHari = @json($dataHari);
            const labelBulan = @json($labelBulan);
            const dataBulan = @json($dataBulan);
            const sub = document.getElementById('subPendapatan');
            sub.innerHTML = 'Hari ini: <b>' + rupiah(sum(dataHari)) + '</b>';

            const chartPendapatan = new Chart(document.getElementById('chartPendapatan'), {
                type: 'bar',
                data: {
                    labels: labelHari,
                    datasets: [{
                        label: 'Pendapatan',
                        data: dataHari,
                        backgroundColor: '#DE7801',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: c => rupiah(c.parsed.y)
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => rupiah(v)
                            }
                        }
                    }
                }
            });

            document.getElementById('rentangPendapatan').addEventListener('change', function() {
                if (this.value === 'hari') {
                    chartPendapatan.data.labels = labelHari;
                    chartPendapatan.data.datasets[0].data = dataHari;
                    sub.innerHTML = 'Hari ini: <b>' + rupiah(sum(dataHari)) + '</b>';
                } else {
                    const n = parseInt(this.value);
                    const data = dataBulan.slice(-n);
                    chartPendapatan.data.labels = labelBulan.slice(-n);
                    chartPendapatan.data.datasets[0].data = data;
                    sub.innerHTML = this.options[this.selectedIndex].text + ' terakhir: <b>' + rupiah(sum(
                        data)) + '</b>';
                }
                chartPendapatan.update();
            });

            // ===== Rekap pesanan =====
            donat('chartPesanan',
                ['Selesai', 'Belum selesai', 'Dibatalkan'],
                [{{ $pesananSelesai }}, {{ $pesananBelum }}, {{ $pesananBatal }}],
                ['#DE7801', '#F7D991', '#c0392b']);

            // ===== Produk terlaris =====
            const elTerlaris = document.getElementById('chartTerlaris');
            if (elTerlaris) {
                new Chart(elTerlaris, {
                    type: 'bar',
                    data: {
                        labels: @json($labelTerlaris),
                        datasets: [{
                            label: 'Terjual',
                            data: @json($dataTerlaris),
                            backgroundColor: '#DE7801',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // ===== Produk per kategori =====
            if (document.getElementById('chartKategori')) {
                donat('chartKategori', @json($labelKategori), @json($dataKategori), palet);
            }

            // ===== Pengguna =====
            donat('chartPengguna', ['Admin', 'Pembeli'], [{{ $totalAdmin }}, {{ $totalPembeli }}], ['#DE7801',
                '#F7D991'
            ]);

            // ===== Stok =====
            const elStok = document.getElementById('chartStok');
            if (elStok) {
                new Chart(elStok, {
                    type: 'bar',
                    data: {
                        labels: @json($labelStok),
                        datasets: [{
                            label: 'Stok',
                            data: @json($dataStok),
                            backgroundColor: '#e9a35b',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        })();
    </script>
@endpush
