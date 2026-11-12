<?php

use App\Models\Pesanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $pesanan = new Pesanan();

        $tabelPesanan = $pesanan->getTable();
        $tabelDetail  = $pesanan->detailPesanans()->getRelated()->getTable();

        // pembeli_id boleh kosong (pesanan dari tamu)
        $kolom = DB::selectOne(
            "SHOW COLUMNS FROM `{$tabelPesanan}` WHERE Field = 'pembeli_id'"
        );

        if ($kolom && $kolom->Null === 'NO') {
            DB::statement(
                "ALTER TABLE `{$tabelPesanan}` MODIFY `pembeli_id` {$kolom->Type} NULL"
            );
        }

        // email pada pesanan
        if (!Schema::hasColumn($tabelPesanan, 'email')) {
            Schema::table($tabelPesanan, function (Blueprint $table) {
                $table->string('email', 100)->nullable();
            });
        }

        // ukuran dan catatan pada detail pesanan
        if (!Schema::hasColumn($tabelDetail, 'ukuran')) {
            Schema::table($tabelDetail, function (Blueprint $table) {
                $table->string('ukuran', 20)->nullable();
            });
        }

        if (!Schema::hasColumn($tabelDetail, 'catatan')) {
            Schema::table($tabelDetail, function (Blueprint $table) {
                $table->string('catatan', 200)->nullable();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
