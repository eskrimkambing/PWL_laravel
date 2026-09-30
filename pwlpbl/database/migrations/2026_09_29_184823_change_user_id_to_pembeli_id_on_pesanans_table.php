<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'pembeli_id');
        });

        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreign('pembeli_id')
                ->references('id_pembeli')
                ->on('pembeli')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['pembeli_id']);
            $table->renameColumn('pembeli_id', 'user_id');
        });

        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
