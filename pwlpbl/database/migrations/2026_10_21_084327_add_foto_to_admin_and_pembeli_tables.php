<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Daftar tabel yang butuh kolom foto (yang tidak ada akan dilewati)
    private array $tabel = ['admin', 'pembeli', 'pembelis'];

    public function up(): void
    {
        foreach ($this->tabel as $nama) {
            if (Schema::hasTable($nama) && !Schema::hasColumn($nama, 'foto')) {
                Schema::table($nama, function (Blueprint $table) {
                    $table->longText('foto')->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tabel as $nama) {
            if (Schema::hasTable($nama) && Schema::hasColumn($nama, 'foto')) {
                Schema::table($nama, function (Blueprint $table) {
                    $table->dropColumn('foto');
                });
            }
        }
    }
};
