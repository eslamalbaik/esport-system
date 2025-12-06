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
        Schema::create('single_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_card_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('player_name');
            $table->string('ingame_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
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
        Schema::dropIfExists('single_registrations');
    }
};
