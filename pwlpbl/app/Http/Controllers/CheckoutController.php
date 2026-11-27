<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pesanan;
use App\Models\Pembeli;
use App\Models\Stok;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Mengambil data pembeli yang sedang login.
     * Route checkout sudah dilindungi middleware role:pembeli.
     */
    private function pembeliLogin(): ?Pembeli
    {
        if (!session()->has('user_id')) {
            return null;
        }

        $role = session('role');

        if ($role !== null && $role !== 'pembeli') {
            return null;
        }

        return Pembeli::find(session('user_id'));
    }

    /** Menampilkan halaman checkout (khusus pembeli yang sudah login). */
    public function index()
    {
        $products = Product::with('sizes')
            ->latest()
            ->get();

        $toppings = Topping::orderBy('nama')->get();
        $pembeli = $this->pembeliLogin();

        return view('checkout.index', compact(
            'products',
            'toppings',
            'pembeli'
        ));
    }

    /** Menyimpan pesanan, mengurangi stok, dan memproses pembayaran. */
    public function store(Request $request)
    {
        $pembeli = $this->pembeliLogin();

        if (!$pembeli) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memesan.');
        }

        // Email selalu memakai email akun yang sedang login.
        $request->merge(['email' => $pembeli->email]);

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1|max:99',
            'items.*.size' => 'nullable|string|max:50',
            'items.*.size_id' => 'nullable|integer',
            'items.*.toppings' => 'nullable|array',
            'items.*.toppings.*' => 'integer|exists:toppings,id',
            'items.*.notes' => 'nullable|string|max:200',

            'nama_penerima' => 'required|string|max:100',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'alamat' => 'required_if:jenis_pesanan,Delivery|nullable|string|max:500',
            'catatan' => 'nullable|string|max:500',
            'jenis_pesanan' => 'required|in:Makan di tempat,Dibungkus,Delivery',
            'metode_pembayaran' => 'required|in:Cash,Midtrans',
        ], [
            'alamat.required_if' => 'Alamat wajib diisi untuk pesanan Delivery.',
            'items.required' => 'Keranjang pesanan masih kosong.',
            'metode_pembayaran.required' => 'Silakan pilih metode pembayaran.',
        ]);

        // Pesanan, detail, dan pengurangan stok diproses dalam satu transaksi.
        $pesanan = DB::transaction(function () use ($validated, $pembeli) {
            // Hitung kebutuhan stok total per produk.
            $kebutuhan = [];

            foreach ($validated['items'] as $item) {
                $idProduk = (int) $item['product_id'];
                $kebutuhan[$idProduk] = ($kebutuhan[$idProduk] ?? 0)
                    + (int) $item['qty'];
            }

            ksort($kebutuhan);

            // Kunci produk agar pesanan bersamaan tidak memakai stok yang sama.
            $produkTerkunci = Product::with('sizes')
                ->whereIn('id', array_keys($kebutuhan))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Ambil dan kunci topping yang dipilih.
            $idToppingSemua = collect($validated['items'])
                ->flatMap(fn($item) => $item['toppings'] ?? [])
                ->map(fn($id) => (int) $id)
                ->unique()
                ->values();

            $semuaTopping = Topping::whereIn('id', $idToppingSemua)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Periksa ketersediaan stok sebelum membuat pesanan.
            $pesanError = [];

            foreach ($kebutuhan as $idProduk => $jumlahDipesan) {
                $produk = $produkTerkunci->get($idProduk);

                if (!$produk) {
                    throw ValidationException::withMessages([
                        'produk' => 'Produk tidak ditemukan.',
                    ]);
                }

                $stokTersisa = max(
                    0,
                    (int) Stok::where('product_id', $idProduk)->sum('jumlah_stok')
                );

                if ($stokTersisa <= 0) {
                    $pesanError['stok_' . $idProduk] = $produk->nama
                        . ' sedang kehabisan stok dan tidak dapat dipesan.';
                } elseif ($jumlahDipesan > $stokTersisa) {
                    $pesanError['stok_' . $idProduk] = 'Jumlah pesanan '
                        . $produk->nama . ' (' . $jumlahDipesan
                        . ') melebihi stok yang tersedia (' . $stokTersisa . ').';
                }
            }

            if (!empty($pesanError)) {
                throw ValidationException::withMessages($pesanError);
            }

            // Hitung harga produk, ukuran dari tabel sizes, dan topping.
            $totalHarga = 0;
            $daftarProduk = [];

            foreach ($validated['items'] as $item) {
                $product = $produkTerkunci->get((int) $item['product_id']);

                if (!$product) {
                    throw ValidationException::withMessages([
                        'produk' => 'Produk tidak ditemukan.',
                    ]);
                }

                $jumlah = (int) $item['qty'];
                $hargaSatuan = (float) $product->price;
                $ukuran = null;
                $toppingDipilih = [];

                // Harga ukuran diambil dari relasi/tabel sizes, bukan konstanta harga.
                if ($product->sizes->isNotEmpty()) {
                    $namaUkuran = trim((string) ($item['size'] ?? ''));
                    $idUkuran = $item['size_id'] ?? null;
                    $dipilih = null;

                    if ($namaUkuran !== '') {
                        $dipilih = $product->sizes->firstWhere('nama', $namaUkuran);
                    }

                    if (!$dipilih && !empty($idUkuran)) {
                        $dipilih = $product->sizes->firstWhere('id', (int) $idUkuran);
                    }

                    if (!$dipilih) {
                        throw ValidationException::withMessages([
                            'ukuran_' . $product->id => 'Silakan pilih ukuran untuk '
                                . $product->nama . '.',
                        ]);
                    }

                    $ukuran = $dipilih->nama;
                    $hargaSatuan = (float) $dipilih->harga;
                }

                // Topping hanya dikenakan pada produk kategori Pizza.
                $kategoriProduk = strtolower(trim((string) $product->kategori));

                if ($kategoriProduk === 'pizza') {
                    $idTopping = array_unique(array_map(
                        'intval',
                        $item['toppings'] ?? []
                    ));

                    foreach ($idTopping as $idT) {
                        $topping = $semuaTopping->get($idT);

                        if (!$topping) {
                            throw ValidationException::withMessages([
                                'topping_' . $idT => 'Topping yang dipilih tidak ditemukan.',
                            ]);
                        }

                        if ($topping->sold_out) {
                            throw ValidationException::withMessages([
                                'topping_' . $idT => 'Topping ' . $topping->nama
                                    . ' sedang Sold Out.',
                            ]);
                        }

                        $toppingDipilih[] = [
                            'nama' => $topping->nama,
                            'harga' => (float) $topping->harga,
                        ];

                        $hargaSatuan += (float) $topping->harga;
                    }
                }

                $subtotal = $hargaSatuan * $jumlah;
                $totalHarga += $subtotal;

                $daftarProduk[] = [
                    'product' => $product,
                    'jumlah' => $jumlah,
                    'ukuran' => $ukuran,
                    'toppings' => $toppingDipilih ?: null,
                    'catatan' => trim((string) ($item['notes'] ?? '')) ?: null,
                    'harga' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ];
            }

            // Buat pesanan utama milik pembeli yang login.
            $pesanan = Pesanan::forceCreate([
                'pembeli_id' => $pembeli->id_pembeli,
                'nama_penerima' => $validated['nama_penerima'],
                'no_telp' => $validated['no_telp'],
                'email' => $validated['email'],
                'alamat' => $validated['jenis_pesanan'] === 'Delivery'
                    ? ($validated['alamat'] ?? null)
                    : null,
                'catatan' => $validated['catatan'] ?? null,
                'total_harga' => $totalHarga,
                'jenis_pesanan' => $validated['jenis_pesanan'],
                'status' => 'Menunggu',
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status_pembayaran' => $validated['metode_pembayaran'] === 'Cash'
                    ? 'Belum Dibayar'
                    : 'Menunggu Pembayaran',
                'dibayar_pada' => null,
                'snap_token' => null,
            ]);

            // Simpan setiap detail pesanan, termasuk data topping.
            foreach ($daftarProduk as $item) {
                $pesanan->detailPesanans()->forceCreate([
                    'product_id' => $item['product']->getKey(),
                    'jumlah' => $item['jumlah'],
                    'ukuran' => $item['ukuran'],
                    'toppings' => $item['toppings'],
                    'catatan' => $item['catatan'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Catat pengurangan stok sebagai jumlah negatif.
            foreach ($kebutuhan as $idProduk => $jumlahDipesan) {
                Stok::create([
                    'product_id' => $idProduk,
                    'tanggal_stok' => now()->toDateString(),
                    'jumlah_stok' => -$jumlahDipesan,
                    'status_stok' => 'Terjual',
                ]);
            }

            return $pesanan;
        });

        // Simpan nama, nomor HP, dan alamat ke akun pembeli supaya
        // pesanan berikutnya (login dengan email yang sama) terisi otomatis.
        $dataProfil = [
            'nama' => $validated['nama_penerima'],
            'no_telp' => $validated['no_telp'],
        ];

        if (
            $validated['jenis_pesanan'] === 'Delivery'
            && !empty($validated['alamat'])
        ) {
            $dataProfil['alamat'] = $validated['alamat'];
        }

        $pembeli->update($dataProfil);

        // Pembayaran tunai.
        if ($pesanan->metode_pembayaran === 'Cash') {
            return $this->redirectPesanan(
                $pesanan,
                $pembeli,
                'Pesanan berhasil dibuat!'
            );
        }

        // Pembayaran Midtrans.
        try {
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = filter_var(
                env('MIDTRANS_IS_PRODUCTION', false),
                FILTER_VALIDATE_BOOLEAN
            );
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            if (empty(\Midtrans\Config::$serverKey)) {
                throw new \Exception('MIDTRANS_SERVER_KEY belum diatur di file .env.');
            }

            $params = [
                'transaction_details' => [
                    'order_id' => 'PZM-' . $pesanan->id_pesanan,
                    'gross_amount' => (int) round($pesanan->total_harga),
                ],
                'customer_details' => [
                    'first_name' => $pesanan->nama_penerima,
                    'email' => $pesanan->email,
                    'phone' => $pesanan->no_telp,
                ],
                'enabled_payments' => ['gopay'],
            ];

            $transaction = \Midtrans\Snap::createTransaction($params);

            $pesanan->update([
                'snap_token' => $transaction->token,
            ]);

            return redirect()->away($transaction->redirect_url);
        } catch (\Throwable $e) {
            report($e);

            return $this->redirectPesanan(
                $pesanan,
                $pembeli,
                'Pesanan berhasil dibuat!',
                'Pembayaran Midtrans belum dapat diproses. '
                    . 'Silakan hubungi admin sebelum mencoba checkout kembali.'
            );
        }
    }

    /** Mengarahkan pembeli ke halaman pesanan berhasil. */
    private function redirectPesanan(
        Pesanan $pesanan,
        Pembeli $pembeli,
        string $pesan,
        ?string $peringatan = null
    ) {
        $redirect = redirect()
            ->route('checkout.selesai', $pesanan->id_pesanan)
            ->with('success', $pesan);

        if ($peringatan) {
            $redirect->with('warning', $peringatan);
        }

        return $redirect;
    }

    /** Halaman "Pesanan Berhasil Dibuat!" untuk pembeli yang login. */
    public function selesai($id)
    {
        $pesanan = Pesanan::with('detailPesanans')->findOrFail($id);

        // Pembeli hanya boleh melihat pesanannya sendiri.
        abort_unless(
            (int) $pesanan->pembeli_id === (int) session('user_id'),
            403
        );

        $items = $pesanan->detailPesanans->map(function ($detail) {
            $product = Product::find($detail->product_id);
            $dataTopping = $detail->toppings ?? [];

            // Mendukung kolom toppings berupa JSON maupun array cast.
            if (is_string($dataTopping)) {
                $dataTopping = json_decode($dataTopping, true) ?: [];
            }

            return [
                'nama' => $product->nama ?? 'Produk',
                'ukuran' => $detail->ukuran ?? null,
                'toppings' => collect($dataTopping)->pluck('nama')->all(),
                'catatan' => $detail->catatan ?? null,
                'jumlah' => $detail->jumlah,
                'subtotal' => $detail->subtotal,
            ];
        });

        return view('checkout.selesai', compact('pesanan', 'items'));
    }
}
