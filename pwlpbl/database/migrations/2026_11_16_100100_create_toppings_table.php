<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toppings', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->decimal('harga', 12, 2)->default(0);
            // true = ditandai "Sold Out" oleh admin
            $table->boolean('sold_out')->default(false);
            $table->timestamps();
        });

        if (!Schema::hasColumn('detail_pesanans', 'toppings')) {
            Schema::table('detail_pesanans', function (Blueprint $table) {
                // Salinan topping saat dipesan: [{"nama":"..","harga":..}]
                $table->text('toppings')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('detail_pesanans', 'toppings')) {
            Schema::table('detail_pesanans', function (Blueprint $table) {
                $table->dropColumn('toppings');
            });
        }

        Schema::dropIfExists('toppings');
    }
};
