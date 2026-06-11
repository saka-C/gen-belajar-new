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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TotalAllocationCampaign`(IN `p_campaign_id` INT)
BEGIN
    SELECT
    campaign_id,
    SUM(amount_used)
    FROM ALLOCATIONS
    WHERE campaign_id=p_campaign_id
    GROUP BY campaign_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_TotalAllocationCampaign");
    }
};
