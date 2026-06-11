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
        Schema::create('donations', function (Blueprint $table) {
            $table->integer('donation_id', true);
            $table->integer('user_id')->nullable();
            $table->integer('campaign_id')->index('campaign_id');
            $table->decimal('amount', 15);
            $table->boolean('is_anonymous')->nullable()->default(false);
            $table->string('guest_name', 100)->nullable();
            $table->string('payment_method', 20)->nullable()->default('qris');
            $table->string('transaction_id')->unique('transaction_id');
            $table->enum('payment_status', ['pending', 'success', 'failed'])->nullable()->default('pending')->index('idx_payment_status');

            $table->index(['user_id', 'campaign_id'], 'idx_user_campaign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
