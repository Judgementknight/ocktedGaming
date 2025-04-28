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
        Schema::create('picture_game', function (Blueprint $table) {
            $table->bigIncrements('picture_game_id');
            $table->string('custom_game_assignment_code');
            $table->string('question');
            $table->string('image_url');
            $table->string('correct');
            $table->foreign('custom_game_assignment_code')->references('custom_game_assignment_code')->on('custom_game_assignments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
