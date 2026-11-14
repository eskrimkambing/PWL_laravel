<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom "nama" sudah dibuat di migrasi create_admin_table,
        // jadi tiap kolom dicek dulu agar tidak terjadi duplikat.
        Schema::table('admin', function (Blueprint $table) {
            if (!Schema::hasColumn('admin', 'nama')) {
                $table->string('nama', 100)->nullable()->after('password');
            }

            if (!Schema::hasColumn('admin', 'no_telp')) {
                $table->string('no_telp', 20)->nullable()->after('nama');
            }

            if (!Schema::hasColumn('admin', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_telp');
            }
        });
    }

    public function down(): void
    {
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
};
