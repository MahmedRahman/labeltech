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
            $table->string('knife_code')->unique()->comment('الرقم الكود');
            $table->string('type')->nullable()->comment('النوع');
            $table->string('gear')->nullable()->comment('تُرس');
            $table->string('dragile_drive')->nullable()->comment('دراغيل');
            $table->integer('rows_count')->nullable()->comment('عدد الصفوف');
            $table->integer('eyes_count')->nullable()->comment('عدد العيون');
            $table->string('flap_size')->nullable()->comment('الجيب');
            $table->decimal('length', 10, 2)->nullable()->comment('الطول');
            $table->decimal('width', 10, 2)->nullable()->comment('العرض');
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

