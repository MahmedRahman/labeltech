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
            // بيانات الورق
            $table->decimal('paper_width', 10, 2)->nullable()->after('has_design'); // عرض الورق
            $table->decimal('paper_weight', 10, 2)->nullable(); // الوزن (جرام/م²)
            $table->decimal('waste_percentage', 5, 2)->nullable(); // نسبة الهالك (%)
            
            // بيانات التشغيل - بكر
            $table->integer('number_of_rolls')->nullable(); // عدد البكر
            $table->decimal('core_size', 10, 2)->nullable(); // مقاس الكور
            
            // بيانات التشغيل - شيت
            $table->integer('pieces_per_sheet')->nullable(); // عدد التكت في الشيت
            $table->integer('sheets_per_stack')->nullable(); // عدد الشيت في الراكوة
            $table->integer('pieces_per_stack')->nullable(); // عدد التكت في الراكوة
            
            // للتحقق من وجود بيانات تشغيل
            $table->boolean('has_production')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'paper_width',
                'paper_weight',
                'waste_percentage',
                'number_of_rolls',
                'core_size',
                'pieces_per_sheet',
                'sheets_per_stack',
                'pieces_per_stack',
                'has_production',
            ]);
        });
    }
};
