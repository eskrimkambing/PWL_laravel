
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('snap_token')->nullable();
            $table->string('status_pembayaran')->default('Belum Dibayar');
            $table->string('metode_pembayaran')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'status_pembayaran',
                'metode_pembayaran',
                'dibayar_pada',
            ]);
        });
    }
};