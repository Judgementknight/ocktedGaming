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
        Schema::create('custom_assignment_complete', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id');
            $table->string('custom_game_assignment_code');
            $table->string('score')->nullable();
            $table->enum('assignment_status',['pending','completed','overdue'])->default('pending');
            $table->date('submitted_at')->nullable();
            $table->foreign('custom_game_assignment_code')->references('custom_game_assignment_code')->on('custom_game_assignments')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
