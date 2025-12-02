<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the column
        // First, add a temporary column
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('production_status_temp')->nullable()->after('status');
        });

        // Copy data
        DB::statement('UPDATE work_orders SET production_status_temp = production_status');

        // Drop old column
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('production_status');
        });

        // Add new column with updated enum
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('production_status')->nullable()->after('status');
        });

        // Copy data back
        DB::statement('UPDATE work_orders SET production_status = production_status_temp');

        // Drop temporary column
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('production_status_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('production_status')->nullable()->change();
        });
    }
};
