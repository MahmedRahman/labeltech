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
            $table->integer('gap_count')->nullable()->after('paper_width')->comment('عدد الجاب');
            $table->decimal('increase', 10, 2)->nullable()->after('gap_count')->comment('الزيادة (سم)');
            $table->decimal('linear_meter', 10, 2)->nullable()->after('increase')->comment('المتر الطولي');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['gap_count', 'increase', 'linear_meter']);
        });
    }
};
