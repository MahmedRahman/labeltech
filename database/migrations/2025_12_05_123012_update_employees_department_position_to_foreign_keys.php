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
            // Drop old columns
            $table->dropColumn(['department', 'position']);
        });

        Schema::table('employees', function (Blueprint $table) {
            // Add new foreign key columns
            $table->foreignId('department_id')->nullable()->after('years_of_experience')->constrained('departments')->onDelete('set null');
            $table->foreignId('position_id')->nullable()->after('department_id')->constrained('positions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['department_id', 'position_id']);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('position')->nullable()->after('years_of_experience');
            $table->string('department')->nullable()->after('position');
        });
    }
};
