
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign('pesanans_pembeli_id_foreign');
        });

        Schema::table('pesanans', function (Blueprint $table) {
            $table->unsignedBigInteger('pembeli_id')
                ->nullable()
                ->change();

            $table->foreign('pembeli_id', 'pesanans_pembeli_id_foreign')
                ->references('id_pembeli')
                ->on('pembeli')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign('pesanans_pembeli_id_foreign');
        });

        Schema::table('pesanans', function (Blueprint $table) {
            $table->unsignedBigInteger('pembeli_id')
                ->nullable(false)
                ->change();

            $table->foreign('pembeli_id', 'pesanans_pembeli_id_foreign')
                ->references('id_pembeli')
                ->on('pembeli')
                ->cascadeOnDelete();
        });
    }
};
