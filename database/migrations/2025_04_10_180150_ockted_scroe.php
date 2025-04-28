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
        Schema::create('ockted_score', function (Blueprint $table) {
            $table->id('score_id');
            $table->string('student_id'); // Creates ockted_id and ockted_type
            $table->string('game_code');
            $table->integer('score');
            $table->foreign('student_id')->references('student_id')->on('ockted_students')->onDelete('cascade');
            $table->foreign('game_code')->references('game_code')->on('ockted_games')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_score');
    }
};
