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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->string('username', 50);
            $table->string('email', 100)->unique('email');
            $table->string('password_hash')->nullable();
            $table->string('google_id')->nullable()->unique('google_id');
            $table->enum('auth_provider', ['local', 'google'])->nullable()->default('local');
            $table->enum('role', ['donatur', 'admin', 'volunteer'])->nullable()->default('donatur')->index('idx_user_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
