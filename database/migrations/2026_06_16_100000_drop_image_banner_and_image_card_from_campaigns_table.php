<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (Schema::hasColumn('campaigns', 'image_banner')) {
                $table->dropColumn('image_banner');
            }

            if (Schema::hasColumn('campaigns', 'image_card')) {
                $table->dropColumn('image_card');
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (! Schema::hasColumn('campaigns', 'image_banner')) {
                $table->string('image_banner')->nullable()->after('description');
            }

            if (! Schema::hasColumn('campaigns', 'image_card')) {
                $table->string('image_card')->nullable()->after('image_banner');
            }
        });
    }
};
