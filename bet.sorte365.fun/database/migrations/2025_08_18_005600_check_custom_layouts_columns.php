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
        Schema::table('custom_layouts', function (Blueprint $table) {
            if (!Schema::hasColumn('custom_layouts', 'vip_descriçao')) {
                $table->text('vip_descriçao')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_layouts', function (Blueprint $table) {
            if (Schema::hasColumn('custom_layouts', 'vip_descriçao')) {
                $table->dropColumn('vip_descriçao');
            }
        });
    }
};
