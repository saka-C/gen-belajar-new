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
        DB::statement("CREATE VIEW `vw_donasi_sukses` AS select `d`.`donation_id` AS `donation_id`,`u`.`username` AS `username`,`c`.`title` AS `title`,`d`.`amount` AS `amount` from ((`dbgenbelajar`.`donations` `d` join `dbgenbelajar`.`users` `u` on(`d`.`user_id` = `u`.`user_id`)) join `dbgenbelajar`.`campaigns` `c` on(`d`.`campaign_id` = `c`.`campaign_id`)) where `d`.`payment_status` = 'success'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_donasi_sukses`");
    }
};
