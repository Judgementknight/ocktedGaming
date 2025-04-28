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
        Schema::create('math_game', function (Blueprint $table) {
            $table->bigIncrements('math_game_id');
            $table->string('custom_game_assignment_code');
            $table->foreign('custom_game_assignment_code')->references('custom_game_assignment_code')->on('custom_game_assignments')->onDelete('cascade');
            $table->string('question')->nullable();
            $table->string('img')->nullable();
            $table->string('correct');
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
