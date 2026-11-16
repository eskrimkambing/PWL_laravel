<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('nama', 50);
            $table->decimal('harga', 12, 2);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });

        // Pindahkan aturan lama (Small -10.000, Medium = harga dasar, Large +15.000)
        // ke data ukuran supaya harga pizza yang sudah ada tidak berubah.
        $pizzas = DB::table('products')->whereRaw('LOWER(TRIM(kategori)) = ?', ['pizza'])->get();

        foreach ($pizzas as $p) {
            $base = (float) $p->price;
            $now = now();

            foreach ([['Small', $base - 10000], ['Medium', $base], ['Large', $base + 15000]] as $i => [$nama, $harga]) {
                DB::table('product_sizes')->insert([
                    'product_id' => $p->id,
                    'nama' => $nama,
                    'harga' => max(0, $harga),
                    'urutan' => $i,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // Harga produk = harga terendah (dipakai untuk "Mulai dari ...").
            DB::table('products')->where('id', $p->id)->update(['price' => max(0, $base - 10000)]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
