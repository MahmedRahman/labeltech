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
            $table->integer('designer_number_of_colors')->nullable()->after('number_of_colors');
            $table->string('designer_drills')->nullable()->after('design_drills');
            $table->string('designer_breaking_gear')->nullable()->after('design_breaking_gear');
            $table->decimal('designer_paper_width', 8, 2)->nullable()->after('paper_width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'designer_number_of_colors',
                'designer_drills',
                'designer_breaking_gear',
                'designer_paper_width'
            ]);
        });
    }
};
