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
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_colors')->comment('عدد الألوان');
            $table->decimal('waste_percentage', 5, 2)->comment('نسبة الهالك');
            $table->decimal('waste_per_roll', 10, 2)->default(0)->comment('عدد الهالك للبكرة الواحدة');
            $table->decimal('price', 10, 2)->nullable()->comment('السعر');
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};



