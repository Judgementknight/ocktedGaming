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
            $table->id('user_id');
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
