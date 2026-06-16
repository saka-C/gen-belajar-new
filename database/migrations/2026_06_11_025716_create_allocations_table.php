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
        Schema::create('allocations', function (Blueprint $table) {
            $table->integer('allocation_id', true);
            $table->integer('campaign_id')->index('campaign_id');
            $table->enum('metode', ['cash', 'transfer', 'lainnya'])->default('cash');
            $table->string('penerima');
            $table->decimal('amount_used', 15);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocations');
    }
};
