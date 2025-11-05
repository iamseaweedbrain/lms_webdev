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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('creator_id');
            $table->string('classname');
            $table->text('description')->nullable();
            $table->string('code')->unique();
            $table->enum('color', ['pink', 'blue', 'purple', 'yellow'])->default('pink');
            $table->timestamps();

            // foreign key link to useraccounts table
            $table->foreign('creator_id')->references('user_id')->on('useraccount')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
