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
                $table->enum('client_design_approval', ['موافق', 'لم يرد', 'رفض'])->nullable()->after('sent_to_designer');
            });
        } else {
            // SQLite and other databases
            Schema::table('work_orders', function (Blueprint $table) {
                $table->string('client_design_approval')->nullable()->after('sent_to_designer');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('client_design_approval');
        });
    }
};
