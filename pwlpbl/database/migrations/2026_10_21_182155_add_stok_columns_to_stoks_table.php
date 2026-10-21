<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stoks', function (Blueprint $table) {
            if (!Schema::hasColumn('stoks', 'tanggal_stok')) {
                $table->date('tanggal_stok')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('stoks', 'jumlah_stok')) {
                $table->integer('jumlah_stok')->default(0)->after('tanggal_stok');
            }
            if (!Schema::hasColumn('stoks', 'status_stok')) {
                $table->string('status_stok', 50)->default('Tersedia')->after('jumlah_stok');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stoks', function (Blueprint $table) {
            $table->dropColumn(['tanggal_stok', 'jumlah_stok', 'status_stok']);
        });
    }
};