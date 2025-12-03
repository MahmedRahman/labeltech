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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('national_id')->nullable()->after('phone');
            $table->integer('years_of_experience')->nullable()->after('national_id');
            $table->date('insurance_date')->nullable()->after('hire_date');
            $table->string('insurance_number')->nullable()->after('insurance_date');
            $table->string('employee_code')->unique()->nullable()->after('insurance_number');
            $table->date('birth_date')->nullable()->after('employee_code');
            $table->string('company_name')->nullable()->after('birth_date');
            $table->date('resignation_date')->nullable()->after('company_name');
            $table->string('status')->default('نشط')->after('resignation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'national_id',
                'years_of_experience',
                'insurance_date',
                'insurance_number',
                'employee_code',
                'birth_date',
                'company_name',
                'resignation_date',
                'status',
            ]);
        });
    }
};
