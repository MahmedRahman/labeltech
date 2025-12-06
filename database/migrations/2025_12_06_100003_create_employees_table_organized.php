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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->string('account_type')->nullable(); // Changed from json to string
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('employee_code')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->string('company_name')->nullable();
            $table->date('resignation_date')->nullable();
            $table->string('status')->default('نشط');
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

