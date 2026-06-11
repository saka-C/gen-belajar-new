<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. BUAT VIEWS
        DB::unprepared("
            CREATE OR REPLACE VIEW vw_donasi_sukses AS 
            SELECT d.donation_id, u.username, c.title, d.amount 
            FROM donations d 
            JOIN users u ON d.user_id = u.user_id 
            JOIN campaigns c ON d.campaign_id = c.campaign_id 
            WHERE d.payment_status = 'success'
        ");

        DB::unprepared("
            CREATE OR REPLACE VIEW vw_progress_campaign AS 
            SELECT campaign_id, title, target_amount, current_amount, 
            ROUND(current_amount / target_amount * 100, 2) AS progress_percentage 
            FROM campaigns
        ");

        // 2. BUAT TRIGGERS
        DB::unprepared("
            CREATE TRIGGER trg_AfterPaymentSuccess AFTER UPDATE ON donations FOR EACH ROW BEGIN
                IF OLD.payment_status = 'pending' AND NEW.payment_status = 'success' THEN
                    UPDATE campaigns 
                    SET current_amount = current_amount + NEW.amount
                    WHERE campaign_id = NEW.campaign_id;
                END IF;
            END
        ");

        // 3. BUAT STORED PROCEDURE
        DB::unprepared("
            CREATE PROCEDURE sp_GetCampaignActive ()   
            BEGIN
                SELECT * FROM campaigns WHERE status='active';
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS vw_donasi_sukses");
        DB::unprepared("DROP VIEW IF EXISTS vw_progress_campaign");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_AfterPaymentSuccess");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_GetCampaignActive");
    }
};