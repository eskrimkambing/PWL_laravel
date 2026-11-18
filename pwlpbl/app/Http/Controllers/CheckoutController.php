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
     */
    private function pembeliLogin(): ?Pembeli
    {
        if (!session()->has('user_id')) {
            return null;
        }

        if (session('role') !== 'pembeli') {
            return null;
        }

        return Pembeli::find(session('user_id'));
    }

    /**
     * Menampilkan halaman checkout.
     */
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

    /**
     * Menyimpan pesanan dan memproses pembayaran.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',

            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'items.*.qty' => 'required|integer|min:1|max:99',

            'items.*.size' => 'nullable|string|max:50',

            'items.*.size_id' => 'nullable|integer',

            'items.*.toppings' => 'nullable|array',

            'items.*.toppings.*' => 'required|integer',

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

        $pembeli = $this->pembeliLogin();

        /*
         * SIMPAN PESANAN DAN KURANGI STOK.
         */
        $pesanan = DB::transaction(function () use ($request, $pembeli) {

            /*
             * HITUNG KEBUTUHAN STOK.
             */
            $kebutuhan = [];

            foreach ($request->items as $item) {
                $idProduk = (int) $item['product_id'];

                $kebutuhan[$idProduk] =
                    ($kebutuhan[$idProduk] ?? 0)
                    + (int) $item['qty'];
            }

            ksort($kebutuhan);

            /*
             * KUNCI PRODUK AGAR STOK TIDAK DIPESAN BERSAMAAN.
             */
            $produkTerkunci = Product::with('sizes')
                ->whereIn('id', array_keys($kebutuhan))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            /*
             * PERIKSA KETERSEDIAAN STOK.
             */
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
                    (int) Stok::where('product_id', $idProduk)
                        ->sum('jumlah_stok')
                );

                if ($stokTersisa <= 0) {

                    $pesanError['stok_' . $idProduk] =
                        $produk->nama . ' sedang kehabisan stok.';

                } elseif ($jumlahDipesan > $stokTersisa) {

                    $pesanError['stok_' . $idProduk] =
                        'Jumlah pesanan ' . $produk->nama
                        . ' melebihi stok yang tersedia ('
                        . $stokTersisa . ').';
                }
            }

            if (!empty($pesanError)) {
                throw ValidationException::withMessages($pesanError);
            }

            /*
             * HITUNG HARGA PESANAN.
             */
            $totalHarga = 0;

            $daftarProduk = [];

            $semuaTopping = Topping::all()->keyBy('id');

            foreach ($request->items as $item) {

                $product = $produkTerkunci->get(
                    (int) $item['product_id']
                );

                if (!$product) {
                    throw ValidationException::withMessages([
                        'produk' => 'Produk tidak ditemukan.',
                    ]);
                }

                $jumlah = (int) $item['qty'];

                $hargaSatuan = (float) $product->price;

                $ukuran = null;

                /*
                 * HARGA UKURAN PIZZA.
                 * Cari berdasarkan nama atau ID ukuran.
                 */
                if ($product->sizes->isNotEmpty()) {

                    $namaUkuran = trim(
                        (string) ($item['size'] ?? '')
                    );

                    $idUkuran = $item['size_id'] ?? null;

                    $dipilih = null;

                    if ($namaUkuran !== '') {
                        $dipilih = $product->sizes->firstWhere(
                            'nama',
                            $namaUkuran
                        );
                    }

                    if (!$dipilih && !empty($idUkuran)) {
                        $dipilih = $product->sizes->firstWhere(
                            'id',
                            (int) $idUkuran
                        );
                    }

                    if (!$dipilih) {
                        throw ValidationException::withMessages([
                            'ukuran_' . $product->id =>
                                'Silakan pilih ukuran untuk '
                                . $product->nama . '.',
                        ]);
                    }

                    $ukuran = $dipilih->nama;

                    $hargaSatuan = (float) $dipilih->harga;
                }

                /*
                 * HITUNG TOPPING JIKA ADA.
                 */
                $toppingDipilih = [];

                $kategoriProduk = strtolower(
                    trim((string) $product->kategori)
                );

                if ($kategoriProduk === 'pizza') {

                    $idTopping = array_unique(
                        array_map(
                            'intval',
                            $item['toppings'] ?? []
                        )
                    );

                    foreach ($idTopping as $idT) {

                        $topping = $semuaTopping->get($idT);

                        if (!$topping) {
                            throw ValidationException::withMessages([
                                'topping_' . $idT =>
                                    'Topping yang dipilih tidak ditemukan.',
                            ]);
                        }

                        if ($topping->sold_out) {
                            throw ValidationException::withMessages([
                                'topping_' . $idT =>
                                    'Topping ' . $topping->nama
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
                    'catatan' => trim(
                        (string) ($item['notes'] ?? '')
                    ) ?: null,
                    'harga' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ];
            }

            /*
             * BUAT PESANAN UTAMA.
             */
            $pesanan = Pesanan::forceCreate([

                'pembeli_id' => $pembeli
                    ? $pembeli->id_pembeli
                    : null,

                'nama_penerima' => $request->nama_penerima,

                'no_telp' => $request->no_telp,

                'email' => $request->email,

                'alamat' => $request->jenis_pesanan === 'Delivery'
                    ? $request->alamat
                    : null,

                'catatan' => $request->catatan,

                'total_harga' => $totalHarga,

                'jenis_pesanan' => $request->jenis_pesanan,

                'status' => 'Menunggu',

                'metode_pembayaran' => $request->metode_pembayaran,

                'status_pembayaran' =>
                    $request->metode_pembayaran === 'Cash'
                        ? 'Belum Dibayar'
                        : 'Menunggu Pembayaran',

                'dibayar_pada' => null,

                'snap_token' => null,
            ]);

            /*
             * SIMPAN DETAIL PESANAN.
             */
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

            /*
             * CATAT PENGURANGAN STOK.
             */
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

        /*
         * PEMBAYARAN CASH.
         */
        if ($pesanan->metode_pembayaran === 'Cash') {

            return $this->redirectPesanan(
                $pesanan,
                $pembeli,
                'Pesanan berhasil dibuat!'
            );
        }

        /*
         * PEMBAYARAN MIDTRANS.
         */
        try {

            \Midtrans\Config::$serverKey = env(
                'MIDTRANS_SERVER_KEY'
            );

            \Midtrans\Config::$isProduction = filter_var(
                env('MIDTRANS_IS_PRODUCTION', false),
                FILTER_VALIDATE_BOOLEAN
            );

            \Midtrans\Config::$isSanitized = true;

            \Midtrans\Config::$is3ds = true;

            if (empty(\Midtrans\Config::$serverKey)) {
                throw new \Exception(
                    'MIDTRANS_SERVER_KEY belum diatur di file .env.'
                );
            }

            $orderId = 'PZM-' . $pesanan->id_pesanan;

            $params = [

                'transaction_details' => [

                    'order_id' => $orderId,

                    'gross_amount' => (int) round(
                        $pesanan->total_harga
                    ),
                ],

                'customer_details' => [

                    'first_name' => $pesanan->nama_penerima,

                    'email' => $pesanan->email,

                    'phone' => $pesanan->no_telp,
                ],

                /*
                 * METODE PEMBAYARAN.
                 * GoPay dapat menyediakan QRIS pada Snap desktop.
                 */
                'enabled_payments' => [
                    'gopay',
                ],
            ];

            $transaction = \Midtrans\Snap::createTransaction(
                $params
            );

            /*
             * SIMPAN SNAP TOKEN.
             */
            $pesanan->update([
                'snap_token' => $transaction->token,
            ]);

            /*
             * ARAHKAN KE HALAMAN MIDTRANS.
             */
            return redirect()->away(
                $transaction->redirect_url
            );

        } catch (\Throwable $e) {

            report($e);

            return $this->redirectPesanan(
                $pesanan,
                $pembeli,
                'Pesanan berhasil dibuat, tetapi pembayaran Midtrans belum dapat diproses. Silakan hubungi admin sebelum mencoba checkout kembali.'
            );
        }
    }

    /**
     * Mengarahkan pembeli ke halaman detail pesanan.
     */
    private function redirectPesanan(
        Pesanan $pesanan,
        ?Pembeli $pembeli,
        string $pesan
    ) {

        if ($pembeli) {

            return redirect()
                ->route(
                    'pesanans.show',
                    $pesanan->id_pesanan
                )
                ->with('success', $pesan);
        }

        session([
            'pesanan_tamu' => $pesanan->id_pesanan,
        ]);

        return redirect()
            ->route(
                'checkout.selesai',
                $pesanan->id_pesanan
            )
            ->with('success', $pesan);
    }

    /**
     * Halaman pesanan selesai untuk tamu.
     */
    public function selesai($id)
    {
        abort_unless(
            (string) session('pesanan_tamu') === (string) $id,
            403
        );

        $pesanan = Pesanan::with('detailPesanans')
            ->findOrFail($id);

        $items = $pesanan->detailPesanans->map(function ($detail) {

            $product = Product::find($detail->product_id);

            return [

                'nama' => $product->nama ?? 'Produk',

                'ukuran' => $detail->ukuran ?? null,

                'toppings' => collect($detail->toppings ?? [])
                    ->pluck('nama')
                    ->all(),

                'catatan' => $detail->catatan ?? null,

                'jumlah' => $detail->jumlah,

                'subtotal' => $detail->subtotal,
            ];
        });

        return view('checkout.selesai', compact(
            'pesanan',
            'items'
        ));
    }
}

