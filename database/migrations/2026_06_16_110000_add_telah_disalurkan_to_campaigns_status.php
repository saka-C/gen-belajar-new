<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambahkan nilai 'telah_disalurkan' ke kolom status pada tabel campaigns.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE campaigns MODIFY COLUMN status ENUM('draft', 'active', 'completed', 'telah_disalurkan') NULL DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan enum ke nilai semula (pastikan tidak ada data 'telah_disalurkan' sebelum rollback)
        DB::statement("ALTER TABLE campaigns MODIFY COLUMN status ENUM('draft', 'active', 'completed') NULL DEFAULT 'draft'");
    }
};
