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
        Schema::table('ockted_games', function (Blueprint $table) {
            $table->string('game_status')->nullable()->after('game_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ockted_games', function (Blueprint $table) {
            $table->dropColumn('game_status');
        });
    }
};
