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
        Schema::create('ockted_gameroom', function (Blueprint $table) {
            $table->bigIncrements('gameroom_id');
            $table->string('teacher_id');
            $table->string('school_code')->nullable();
            $table->string('gameroom_code')->unique();
            $table->string('class_level_gameroom');
            $table->foreign('teacher_id')->references('teacher_id')->on('ockted_teachers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_gameroom');
    }
};
