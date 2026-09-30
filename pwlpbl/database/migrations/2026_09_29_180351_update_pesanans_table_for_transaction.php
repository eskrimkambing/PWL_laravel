<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'jumlah']);

            $table->string('jenis_pesanan', 50)
                ->after('total_harga');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->after('user_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->integer('jumlah')
                ->after('product_id');

            $table->dropColumn('jenis_pesanan');
        });
    }
};
