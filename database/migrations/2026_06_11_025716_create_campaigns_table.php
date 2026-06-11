<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->integer('campaign_id', true);
            $table->string('title');
            $table->decimal('target_amount', 15);
            $table->decimal('current_amount', 15)->nullable()->default(0);
            $table->enum('status', ['draft', 'active', 'completed'])->nullable()->default('draft')->index('idx_campaign_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
