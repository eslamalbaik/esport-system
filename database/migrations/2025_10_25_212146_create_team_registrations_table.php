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
        Schema::create('team_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_card_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('team_name');
            $table->string('captain_name');
            $table->string('captain_email')->nullable();
            $table->string('captain_phone')->nullable();
            $table->string('team_logo_path')->nullable();
            $table->string('captain_logo_path')->nullable();
            $table->string('game_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('tournament_card_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_registrations');
    }
};
