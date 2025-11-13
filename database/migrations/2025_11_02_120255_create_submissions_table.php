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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id('submission_id');
            $table->unsignedBigInteger('post_id');
            $table->string('user_id');
            $table->enum('file_type', ['image', 'link', 'file']);
            $table->string('file_path');
            $table->timestamp('submitted_at')->useCurrent();
            $table->decimal('score', 5, 2)->nullable(); 
            $table->integer('max_score')->nullable();
            $table->text('feedback')->nullable();
            $table->string('graded_by')->nullable();
            $table->dateTime('graded_at')->nullable();

            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
            $table->foreign('graded_by')->references('user_id')->on('useraccount')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
