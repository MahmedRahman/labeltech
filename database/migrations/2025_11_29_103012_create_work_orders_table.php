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
            $table->string('order_number')->unique()->nullable(); // رقم أمر الشغل
            $table->integer('number_of_colors')->default(1); // عدد الألوان
            $table->string('material'); // الخامة
            $table->integer('quantity'); // الكمية
            $table->decimal('width', 10, 2)->nullable(); // العرض (بالسنتيمتر)
            $table->decimal('length', 10, 2)->nullable(); // الطول (بالسنتيمتر)
            $table->text('final_product_shape')->nullable(); // شكل المنتج النهائي
            $table->text('additions')->nullable(); // الإضافات المطلوبة
            $table->text('notes')->nullable(); // الملاحظات
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // حالة الأمر
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
