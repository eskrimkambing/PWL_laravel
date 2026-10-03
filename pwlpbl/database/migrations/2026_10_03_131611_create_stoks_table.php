<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id('id_stok');

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->date('tanggal_stok');

            $table->integer('jumlah_stok');

            $table->string('status_stok');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};