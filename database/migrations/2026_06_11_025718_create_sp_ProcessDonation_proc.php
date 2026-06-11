<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ProcessDonation`(IN `p_user_id` INT, IN `p_campaign_id` INT, IN `p_amount` DECIMAL(15,2), IN `p_is_anonymous` BOOLEAN, IN `p_guest_name` VARCHAR(100), IN `p_transaction_id` VARCHAR(255))
BEGIN

    INSERT INTO DONATIONS(
        user_id,
        campaign_id,
        amount,
        is_anonymous,
        guest_name,
        payment_method,
        transaction_id,
        payment_status
    )
    VALUES(
        p_user_id,
        p_campaign_id,
        p_amount,
        p_is_anonymous,
        p_guest_name,
        'qris',
        p_transaction_id,
        'pending'
    );
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_ProcessDonation");
    }
};
