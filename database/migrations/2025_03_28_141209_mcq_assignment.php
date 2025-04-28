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
        Schema::create('mcq_questions', function (Blueprint $table) {
            $table->bigIncrements('mcq_id');
            $table->string('custom_game_assignment_code');
            $table->string('mcq_question');
            $table->string('mcq_correct');
            $table->foreign('custom_game_assignment_code')->references('custom_game_assignment_code')->on('custom_game_assignments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcq_questions');
    }
};
