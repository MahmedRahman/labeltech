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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            // Basic Information
            $table->string('order_number')->unique()->nullable(); // رقم أمر الشغل
            $table->string('job_name')->nullable(); // اسم الشغلانه
            $table->string('created_by')->nullable(); // الشخص المسؤول الذي قام بإضافة أمر الشغل
            
            // Product Information
            $table->integer('number_of_colors')->default(1); // عدد الألوان
            $table->integer('rows_count')->nullable(); // عدد الصفوف
            $table->string('material'); // الخامة
            $table->integer('quantity'); // الكمية
            $table->decimal('width', 10, 2)->nullable(); // العرض (بالسنتيمتر)
            $table->decimal('length', 10, 2)->nullable(); // الطول (بالسنتيمتر)
            $table->text('final_product_shape')->nullable(); // شكل المنتج النهائي
            $table->text('additions')->nullable(); // الإضافات المطلوبة
            $table->string('fingerprint')->nullable(); // البصمة (yes/no)
            $table->string('winding_direction')->nullable(); // اتجاه اللف (no/clockwise/counterclockwise)
            $table->string('knife_exists')->nullable(); // السكينة (yes/no)
            
            // Equipment
            $table->decimal('film_price', 10, 2)->nullable(); // سعر الفيلم الواحد
            $table->integer('film_count')->nullable(); // العدد
            $table->decimal('sales_percentage', 5, 2)->nullable(); // نسبة المبيعات
            
            // Design Information
            $table->string('design_shape')->nullable(); // الشكل
            $table->string('design_films')->nullable(); // أفلام
            $table->string('design_knives')->nullable(); // سكاكين
            $table->string('design_drills')->nullable(); // الدرافيل
            $table->string('design_breaking_gear')->nullable(); // ترس التكسير
            $table->string('design_gab')->nullable(); // الجاب
            $table->string('design_cliches')->nullable(); // الكلاشيهات المعده
            $table->string('design_file')->nullable(); // ملف التصميم
            $table->foreignId('design_knife_id')->nullable()->constrained('knives')->onDelete('set null');
            $table->integer('design_rows_count')->nullable();
            $table->boolean('has_design')->default(false); // للتحقق من وجود تصميم
            
            // Production Information
            $table->decimal('paper_width', 10, 2)->nullable(); // عرض الورق
            $table->decimal('paper_weight', 10, 2)->nullable(); // الوزن (جرام/م²)
            $table->decimal('waste_percentage', 5, 2)->nullable(); // نسبة الهالك (%)
            $table->integer('number_of_rolls')->nullable(); // عدد البكر
            $table->decimal('core_size', 10, 2)->nullable(); // مقاس الكور
            $table->integer('pieces_per_sheet')->nullable(); // عدد التكت في الشيت
            $table->integer('sheets_per_stack')->nullable(); // عدد الشيت في الراكوة
            $table->integer('pieces_per_stack')->nullable(); // عدد التكت في الراكوة
            $table->boolean('has_production')->default(false);
            $table->string('production_status')->nullable(); // حالة الإنتاج (طباعة/قص/تقفيل/أرشيف)
            
            // Status and Notes
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // حالة الأمر
            $table->text('notes')->nullable(); // الملاحظات
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};

