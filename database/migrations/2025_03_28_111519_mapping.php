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
        Schema::create('classroom_mapping', function (Blueprint $table) {
            $table->bigIncrements('classroom_mapping_id');
            $table->string('student_id');
            $table->string('classroom_code');
            $table->foreign('student_id')->references('student_id')->on('ockted_students')->onDelete('cascade');
            $table->foreign('classroom_code')->references('classroom_code')->on('classrooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_mapping');
    }

};
