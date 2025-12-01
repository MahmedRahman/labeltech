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
        Schema::create('knives', function (Blueprint $table) {
            $table->id();
            $table->string('knife_code')->unique()->comment('كود السكينة');
            $table->string('knife_name')->comment('اسم السكينة');
            $table->string('knife_type')->nullable()->comment('نوع السكينة');
            $table->string('size')->nullable()->comment('المقاس');
            $table->integer('rows_count')->nullable()->comment('عدد الصفوف');
            $table->integer('eyes_count')->nullable()->comment('عدد العيون');
            $table->string('flap_size')->nullable()->comment('حجم الجيب');
            $table->string('grain_direction')->nullable()->comment('اتجاه البحر');
            $table->decimal('knife_thickness', 8, 2)->nullable()->comment('سُمك السكينة');
            $table->integer('crease_lines')->nullable()->comment('خطوط التكسير');
            $table->integer('punch_holes')->nullable()->comment('عدد الثقوب');
            $table->string('drill_size')->nullable()->comment('مقاس البرّافات');
            $table->string('material_type')->nullable()->comment('نوع المعدن');
            $table->date('purchase_date')->nullable()->comment('تاريخ الشراء');
            $table->enum('knife_status', ['active', 'inactive', 'maintenance', 'retired'])->default('active')->comment('حالة السكينة');
            $table->integer('usage_count')->default(0)->comment('عدد الاستخدام');
            $table->string('storage_location')->nullable()->comment('مكان التخزين');
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knives');
    }
};
