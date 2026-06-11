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
        DB::statement("CREATE VIEW `vw_progress_campaign` AS select `dbgenbelajar`.`campaigns`.`campaign_id` AS `campaign_id`,`dbgenbelajar`.`campaigns`.`title` AS `title`,`dbgenbelajar`.`campaigns`.`target_amount` AS `target_amount`,`dbgenbelajar`.`campaigns`.`current_amount` AS `current_amount`,round(`dbgenbelajar`.`campaigns`.`current_amount` / `dbgenbelajar`.`campaigns`.`target_amount` * 100,2) AS `progress_percentage` from `dbgenbelajar`.`campaigns`");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_progress_campaign`");
    }
};
