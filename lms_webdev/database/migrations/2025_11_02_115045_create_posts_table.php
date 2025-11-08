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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->string('code');
            $table->string('user_id');
            $table->string('post_title');
            $table->enum('post_type', ['material', 'assignment', 'announcement']);
            $table->text('content');
            $table->enum('color', ['pink', 'blue', 'purple', 'yellow'])->default('pink');
            $table->dateTime('due_date')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // foreign keys ulit sa mga tables
            $table->foreign('code')->references('code')->on('classes')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
