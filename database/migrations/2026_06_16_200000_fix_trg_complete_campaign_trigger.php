<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix trigger trg_CompleteCampaign agar tidak override status 'telah_disalurkan'.
     * Trigger asli memaksa status = 'completed' setiap kali current_amount >= target_amount,
     * bahkan ketika admin sengaja mengubah status ke 'telah_disalurkan'.
     */
    public function up(): void
    {
        // Drop trigger lama
        DB::unprepared("DROP TRIGGER IF EXISTS trg_CompleteCampaign");

        // Buat ulang trigger dengan perbaikan:
        // Hanya set 'completed' jika status baru BUKAN 'telah_disalurkan'
        DB::unprepared("
            CREATE TRIGGER trg_CompleteCampaign BEFORE UPDATE ON campaigns FOR EACH ROW BEGIN
                IF NEW.current_amount >= NEW.target_amount AND NEW.status NOT IN ('telah_disalurkan') THEN
                    SET NEW.status = 'completed';
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_CompleteCampaign");

        // Kembalikan ke trigger asli
        DB::unprepared("
            CREATE TRIGGER trg_CompleteCampaign BEFORE UPDATE ON campaigns FOR EACH ROW BEGIN
                IF NEW.current_amount >= NEW.target_amount THEN
                    SET NEW.status = 'completed';
                END IF;
            END
        ");
    }
};
