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
      Schema::create('ockted_users', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing 'id'
            $table->string('user_id')->unique(); // This could be a UUID or string identifier
            $table->string('username');
            $table->string('school_code');
            $table->string('profile_picture')->nullable();
            $table->string('game_token')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_users');
    }
};
