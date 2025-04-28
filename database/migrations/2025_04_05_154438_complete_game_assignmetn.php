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
        Schema::create('game_assignment_complete', function (Blueprint $table) {
            $table->bigIncrements('assignment_id');
            $table->string('student_id');
            $table->string('game_assignment_code');
            $table->string('score')->nullable();
            $table->enum('assignment_status',['pending','completed','overdue'])->default('pending');
            $table->date('submitted_at')->nullable();
            $table->foreign('game_assignment_code')->references('game_assignment_code')->on('game_assignments')->onDelete('cascade');
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
