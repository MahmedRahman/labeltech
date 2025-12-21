<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            // MySQL: Add work_order status to enum
            DB::statement("ALTER TABLE work_orders MODIFY COLUMN status ENUM('draft', 'pending', 'in_progress', 'completed', 'cancelled', 'client_approved', 'client_rejected', 'client_no_response', 'work_order') DEFAULT 'draft'");
        } elseif ($driver === 'sqlite') {
            // SQLite: We'll handle this in the application layer
            Schema::table('work_orders', function (Blueprint $table) {
                // SQLite doesn't support modifying enum columns directly
            });
        } else {
            // For other databases, try MySQL syntax
            try {
                DB::statement("ALTER TABLE work_orders MODIFY COLUMN status ENUM('draft', 'pending', 'in_progress', 'completed', 'cancelled', 'client_approved', 'client_rejected', 'client_no_response', 'work_order') DEFAULT 'draft'");
            } catch (\Exception $e) {
                // If it fails, we'll handle it in the application layer
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE work_orders MODIFY COLUMN status ENUM('draft', 'pending', 'in_progress', 'completed', 'cancelled', 'client_approved', 'client_rejected', 'client_no_response') DEFAULT 'draft'");
        }
        // SQLite and others: no need to revert as we didn't change the schema
    }
};
