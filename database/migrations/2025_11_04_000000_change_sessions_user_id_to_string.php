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
        // Use raw statement to avoid requiring doctrine/dbal for column type change
        // This will convert the user_id column to varchar(191) and keep it nullable/indexed.
        // Adjust the SQL if your DB uses a different quoting style.
        DB::statement("ALTER TABLE `sessions` MODIFY `user_id` VARCHAR(191) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // revert back to unsignedBigInteger if you want the previous schema
        // Note: this will fail if you have non-numeric values in user_id.
        DB::statement("ALTER TABLE `sessions` MODIFY `user_id` BIGINT UNSIGNED NULL");
    }
};
