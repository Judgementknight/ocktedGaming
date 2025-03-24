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
            $table->string('user_id');
            $table->string('game_title');
            $table->integer('score');
            $table->foreign('user_id')->references('user_id')->on('ockted_users')->onDelete('cascade');
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
