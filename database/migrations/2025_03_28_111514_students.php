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
      Schema::create('ockted_students', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing 'id'
            $table->string('student_id')->unique(); // This could be a UUID or string identifier
            $table->string('student_name');
            $table->string('school_code');
            $table->string('student_status')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('rank')->nullable();
            $table->string('game_token')->nullable()->unique();
            $table->dateTime('last_active_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ockted_students');
    }

};
