<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom "nama" TIDAK dihapus karena dipakai aplikasi
        // (login, topbar admin, kelola pengguna) dan dibuat di create_admin_table.
        Schema::table('admin', function (Blueprint $table) {
            $kolom = array_filter(
                ['no_telp', 'alamat'],
                fn($k) => Schema::hasColumn('admin', $k)
            );

            if ($kolom) {
                $table->dropColumn(array_values($kolom));
            }
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            if (!Schema::hasColumn('admin', 'no_telp')) {
                $table->string('no_telp', 20)->nullable();
            }

            if (!Schema::hasColumn('admin', 'alamat')) {
                $table->text('alamat')->nullable();
            }
        });
    }
};
