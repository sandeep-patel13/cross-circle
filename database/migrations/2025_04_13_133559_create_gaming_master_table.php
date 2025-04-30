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
        Schema::create('gamingMaster', function (Blueprint $table) {
            $table->id();
            $table->enum('gameStatus', ['PENDING', 'COMPLETED'])->default('PENDING');
            $table->foreignId('winningUserId')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamingMaster');
    }
};
