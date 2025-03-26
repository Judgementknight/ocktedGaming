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
        Schema::create('ockted_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('teacher_id')->unique();
            $table->string('ocktedgaming_id')->unique();
            $table->string('teacher_name');
            $table->string('ocktedgaming_teacher_username')->nullable();
            $table->string('school_code');
            $table->string('game_token')->unique()->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_teachers');
    }

};
