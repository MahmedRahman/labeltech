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
            $table->string('design_shape')->nullable()->after('notes'); // الشكل
            $table->string('design_films')->nullable(); // أفلام
            $table->string('design_knives')->nullable(); // سكاكين
            $table->string('design_drills')->nullable(); // الدرافيل
            $table->string('design_breaking_gear')->nullable(); // ترس التكسير
            $table->string('design_gab')->nullable(); // الجاب
            $table->string('design_cliches')->nullable(); // الكلاشيهات المعده
            $table->string('design_file')->nullable(); // ملف التصميم
            $table->boolean('has_design')->default(false); // للتحقق من وجود تصميم
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'design_shape',
                'design_films',
                'design_knives',
                'design_drills',
                'design_breaking_gear',
                'design_gab',
                'design_cliches',
                'design_file',
                'has_design',
            ]);
        });
    }
};
