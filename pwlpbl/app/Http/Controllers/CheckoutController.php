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
     * Jika pengunjung belum login, hasilnya null.
     */
    private function pembeliLogin(): ?Pembeli
    {
        if (!session()->has('user_id')) {
            return null;
        }

        // Admin tidak dianggap sebagai pembeli.
        $role = session('role');

        if ($role !== null && $role !== 'pembeli') {
            return null;
        }

        return Pembeli::find(session('user_id'));
    }

    /**
     * Menampilkan halaman checkout.
     * Bisa diakses oleh pengunjung tanpa login.
     */
    public function index()
    {
        $products = Product::with('sizes')->latest()->get();

        $toppings = Topping::orderBy('nama')->get();

        $pembeli = $this->pembeliLogin();

        return view('checkout.index', compact(
            'products',
            'toppings',
            'pembeli'
        ));
    }

    /**
     * Menyimpan pesanan.
     * Bisa dilakukan oleh pembeli login maupun tamu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',

            'items.*.product_id' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1|max:99',
            'items.*.size_id' => 'nullable|integer',
            'items.*.toppings' => 'nullable|array',
            'items.*.toppings.*' => 'integer',
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

        // Simpan pesanan dan detail pesanan dalam satu transaksi database.
        $pesanan = DB::transaction(function () use ($request, $pembeli) {

            // ------------------------------------------------------
            // VALIDASI STOK
            // Jumlah per produk dijumlahkan dulu (produk yang sama bisa
            // muncul di beberapa baris dengan ukuran/catatan berbeda).
            // ------------------------------------------------------
            $kebutuhan = [];

            foreach ($request->items as $item) {
                $idProduk = (int) $item['product_id'];

                $kebutuhan[$idProduk] = ($kebutuhan[$idProduk] ?? 0)
                    + (int) $item['qty'];
            }

            ksort($kebutuhan);

            // Kunci baris produk (urut ID) supaya dua pembeli yang memesan
            // stok terakhir secara bersamaan tidak sama-sama lolos.
            $produkTerkunci = Product::whereIn('id', array_keys($kebutuhan))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $pesanError = [];

            foreach ($kebutuhan as $idProduk => $jumlahDipesan) {

                $produk = $produkTerkunci->get($idProduk);

                abort_if($produk === null, 404);

                $stokTersisa = max(
                    0,
                    (int) Stok::where('product_id', $idProduk)->sum('jumlah_stok')
                );

                if ($stokTersisa <= 0) {
                    $pesanError['stok_' . $idProduk] = $produk->nama
                        . ' sedang Stok Habis dan tidak dapat dipesan. '
                        . 'Hapus dari pesanan atau tunggu stok tersedia kembali.';
                } elseif ($jumlahDipesan > $stokTersisa) {
                    $pesanError['stok_' . $idProduk] = 'Jumlah pesanan ' . $produk->nama
                        . ' (' . $jumlahDipesan . ') melebihi stok yang tersisa ('
                        . $stokTersisa . '). Kurangi jumlah pesanan.';
                }
            }

            // Ada yang bermasalah: batalkan semua, pesanan tidak dibuat
            // dan stok tidak berkurang.
            if (!empty($pesanError)) {
                throw ValidationException::withMessages($pesanError);
            }

            $totalHarga = 0;
            $daftarProduk = [];

            $semuaTopping = Topping::all()->keyBy('id');

            foreach ($request->items as $item) {

                $product = Product::with('sizes')->findOrFail($item['product_id']);

                $jumlah = (int) $item['qty'];

                // Harga dasar: dari ukuran yang dipilih bila produk punya ukuran,
                // selain itu memakai harga produk.
                $hargaSatuan = (float) $product->price;

                $ukuran = null;

                if ($product->sizes->isNotEmpty()) {

                    $dipilih = $product->sizes->firstWhere('id', (int) ($item['size_id'] ?? 0));

                    if (!$dipilih) {
                        throw ValidationException::withMessages([
                            'ukuran_' . $product->id => 'Pilih ukuran untuk ' . $product->nama . '.',
                        ]);
                    }

                    $ukuran = $dipilih->nama;
                    $hargaSatuan = (float) $dipilih->harga;
                }

                // Topping tambahan hanya berlaku untuk pizza.
                $toppingDipilih = [];

                if ($product->isPizza()) {

                    $idTopping = array_unique(array_map('intval', $item['toppings'] ?? []));

                    foreach ($idTopping as $idT) {

                        $topping = $semuaTopping->get($idT);

                        if (!$topping) {
                            continue;
                        }

                        if ($topping->sold_out) {
                            throw ValidationException::withMessages([
                                'topping_' . $idT => 'Topping ' . $topping->nama
                                    . ' sedang Sold Out. Hapus topping tersebut dari pesanan.',
                            ]);
                        }

                        $toppingDipilih[] = [
                            'nama'  => $topping->nama,
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

            // Membuat pesanan utama.
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

                'status_pembayaran' => $request->metode_pembayaran === 'Cash'
                    ? 'Belum Dibayar'
                    : 'Menunggu Pembayaran',

                'dibayar_pada' => null,
            ]);

            // Menyimpan detail produk yang dipesan.
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

            // ------------------------------------------------------
            // KURANGI STOK sesuai jumlah yang berhasil dipesan.
            // Dicatat sebagai baris stok bernilai minus (status "Terjual"),
            // sehingga total stok di halaman admin ikut berkurang.
            // ------------------------------------------------------
            foreach ($kebutuhan as $idProduk => $jumlahDipesan) {
                Stok::create([
                    'product_id'   => $idProduk,
                    'tanggal_stok' => now()->toDateString(),
                    'jumlah_stok'  => -$jumlahDipesan,
                    'status_stok'  => 'Terjual',
                ]);
            }

            return $pesanan;
        });

        // Jika pembeli sudah login, arahkan ke detail pesanan.
        if ($pembeli) {

            return redirect()
                ->route('pesanans.show', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat!');
        }

        // Jika tamu, simpan ID pesanan ke session.
        session([
            'pesanan_tamu' => $pesanan->id_pesanan
        ]);

        return redirect()
            ->route('checkout.selesai', $pesanan->id_pesanan);
    }

    /**
     * Menampilkan halaman pesanan berhasil untuk tamu.
     */
    public function selesai($id)
    {
        // Pastikan pesanan sesuai dengan session tamu.
        abort_unless(
            (string) session('pesanan_tamu') === (string) $id,
            403
        );

        $pesanan = Pesanan::findOrFail($id);

        $items = $pesanan->detailPesanans->map(function ($detail) {

            $product = Product::find($detail->product_id);

            return [
                'nama' => $product->nama ?? 'Produk',

                'ukuran' => $detail->ukuran ?? null,

                'toppings' => collect($detail->toppings ?? [])->pluck('nama')->all(),

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
