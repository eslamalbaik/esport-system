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
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_card_id')
                ->constrained()
                ->cascadeOnDelete()
                ->unique();
            $table->string('kind');
            $table->foreignId('single_registration_id')
                ->nullable()
                ->constrained('single_registrations')
                ->nullOnDelete();
            $table->foreignId('team_registration_id')
                ->nullable()
                ->constrained('team_registrations')
                ->nullOnDelete();
            $table->json('snapshot')->nullable();
            $table->timestamps();

            $table->index('kind');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
