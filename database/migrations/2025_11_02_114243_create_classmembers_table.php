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
        Schema::create('classmembers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('user_id');
            $table->enum('role', ['member', 'coadmin', 'admin'])->default('member');
            $table->timestamp('joined_at')->useCurrent();

            // foreign key links sa mga nakalink na table
            $table->foreign('code')->references('code')->on('classes')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('useraccount')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classmembers');
    }
};
