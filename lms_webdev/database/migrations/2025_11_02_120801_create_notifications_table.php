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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notif_id');
            $table->string('user_id');
            $table->text('message'); 
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('is_read')->default(false); // 0 = unread, 1 = read
            $table->timestamp('created_at')->useCurrent();

            // Foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
