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
        Schema::create('gamerooms', function (Blueprint $table) {
            $table->bigIncrements('gameroom_id');
            $table->string('gameroom_code')->unique();
            $table->string('gameroom_type');
            $table->string('gameroom_color');
            $table->string('classroom_code');
            $table->foreign('classroom_code')->references('classroom_code')->on('classrooms')->onDelete('cascade');
            // $table->foreign('game_code')->references('game_code')->on('ockted_games')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
