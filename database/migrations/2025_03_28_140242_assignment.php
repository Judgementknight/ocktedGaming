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
        Schema::create('custom_game_assignments', function (Blueprint $table) {
            $table->bigIncrements('assignment_id');
            $table->string('custom_game_assignment_code')->unique();
            $table->string('gameroom_code');
            $table->string('assignment_title');
            $table->date('due_date');
            $table->foreign('gameroom_code')->references('gameroom_code')->on('gamerooms')->onDelelte('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_assignments');
    }
};
