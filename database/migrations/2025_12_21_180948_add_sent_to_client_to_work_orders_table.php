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
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->enum('sent_to_client', ['yes', 'no'])->default('no')->after('status');
            });
        } else {
            // SQLite and other databases
            Schema::table('work_orders', function (Blueprint $table) {
                $table->string('sent_to_client')->default('no')->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('sent_to_client');
        });
    }
};
