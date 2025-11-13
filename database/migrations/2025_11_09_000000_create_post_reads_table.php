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
        Schema::create('post_reads', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamp('read_at')->useCurrent();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');

            // Ensure a user can only mark a post as read once
            $table->unique(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reads');
    }
};
