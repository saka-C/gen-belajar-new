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
        DB::statement("CREATE VIEW `vw_globalfinancialsummary` AS select count(`dbgenbelajar`.`donations`.`donation_id`) AS `total_transaksi_sukses`,sum(`dbgenbelajar`.`donations`.`amount`) AS `total_dana_masuk_global` from `dbgenbelajar`.`donations` where `dbgenbelajar`.`donations`.`payment_status` = 'success'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `vw_globalfinancialsummary`");
    }
};
