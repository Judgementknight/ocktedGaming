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
        Schema::create('gameroom_assignment', function (Blueprint $table) {
            $table->bigIncrements('gameroom_assignment_id');
            $table->string('student_id');
            $table->string('gameroom_code');
            $table->foreign('student_id')->references('student_id')->on('ockted_students')->onDelete('cascade');
            $table->foreign('gameroom_code')->references('gameroom_code')->on('ockted_gameroom')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gameroom_assignment');
    }

};
