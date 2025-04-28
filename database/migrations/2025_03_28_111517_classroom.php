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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->bigIncrements('classroom_id');
            $table->string('classroom_title');
            $table->string('classroom_description');
            $table->string('teacher_id');
            $table->string('school_code')->nullable();
            $table->string('classroom_code')->unique();
            $table->string('class_level');
            $table->string('classroom_color');
            $table->foreign('teacher_id')->references('teacher_id')->on('ockted_teachers')->onDelete('cascade');
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
