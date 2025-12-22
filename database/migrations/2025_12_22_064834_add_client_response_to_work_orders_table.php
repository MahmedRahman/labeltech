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
                $table->enum('client_response', ['موافق', 'لم يرد', 'رفض'])->nullable()->after('sent_to_client');
            });
        } else {
            // SQLite and other databases
            Schema::table('work_orders', function (Blueprint $table) {
                $table->string('client_response')->nullable()->after('sent_to_client');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('client_response');
        });
    }
};
