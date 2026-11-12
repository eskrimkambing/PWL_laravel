<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pesanan;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Tambahan harga berdasarkan ukuran pizza.
    // Harga Medium merupakan harga dasar dari database.
    private const TAMBAHAN_UKURAN = [
        'Small'  => -10000,
        'Medium' => 0,
        'Large'  => 15000,
    ];

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
        $products = Product::latest()->get();

        $pembeli = $this->pembeliLogin();

        return view('checkout.index', compact(
            'products',
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
            'items.*.size' => 'nullable|in:Small,Medium,Large',
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

            $totalHarga = 0;
            $daftarProduk = [];

            foreach ($request->items as $item) {

                $product = Product::findOrFail($item['product_id']);

                $jumlah = (int) $item['qty'];

                $hargaSatuan = (float) $product->price;

                $ukuran = null;

                // Ukuran hanya berlaku untuk produk kategori Pizza.
                if (strtolower(trim((string) $product->kategori)) === 'pizza') {

                    $ukuran = $item['size'] ?? 'Medium';

                    $hargaSatuan += self::TAMBAHAN_UKURAN[$ukuran] ?? 0;
                }

                $subtotal = $hargaSatuan * $jumlah;

                $totalHarga += $subtotal;

                $daftarProduk[] = [
                    'product' => $product,
                    'jumlah' => $jumlah,
                    'ukuran' => $ukuran,
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

                    'catatan' => $item['catatan'],

                    'harga' => $item['harga'],

                    'subtotal' => $item['subtotal'],

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

