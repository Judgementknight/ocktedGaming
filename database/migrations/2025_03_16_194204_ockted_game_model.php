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
        Schema::create('ockted_games', function (Blueprint $table) {
            $table->id('game_id');
            $table->string('game_title');
            $table->string('game_description')->nullable();
            $table->string('game_banner')->nullable();
            $table->string('game_code')->unique();
            $table->string('game_url');
            $table->string('game_source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_games');
    }
};
