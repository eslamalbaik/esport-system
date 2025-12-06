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
        Schema::table('single_registrations', function (Blueprint $table) {
            $table->foreignId('tournament_game_id')
                ->nullable()
                ->after('tournament_card_id')
                ->constrained('tournament_games')
                ->nullOnDelete();
        });

        Schema::table('team_registrations', function (Blueprint $table) {
            $table->foreignId('tournament_game_id')
                ->nullable()
                ->after('tournament_card_id')
                ->constrained('tournament_games')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('single_registrations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tournament_game_id');
        });

        Schema::table('team_registrations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tournament_game_id');
        });
    }
};
