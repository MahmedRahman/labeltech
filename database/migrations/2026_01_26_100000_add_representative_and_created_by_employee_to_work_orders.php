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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->foreignId('representative_id')->nullable()->after('created_by')->constrained('representatives')->onDelete('set null');
            $table->unsignedBigInteger('created_by_employee_id')->nullable()->after('representative_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['representative_id']);
            $table->dropColumn('created_by_employee_id');
        });
    }
};
