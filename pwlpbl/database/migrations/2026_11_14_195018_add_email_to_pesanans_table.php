<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom email sudah tersedia di tabel pesanans.
    }

    public function down(): void
    {
        // Tidak menghapus kolom email.
    }
};
