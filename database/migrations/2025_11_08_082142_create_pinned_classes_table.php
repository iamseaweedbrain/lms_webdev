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
        Schema::create('pinned_classes', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('code');
            $table->timestamps();

            $table->foreign('code')->references('code')->on('classes')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinned_classes');
    }
};
