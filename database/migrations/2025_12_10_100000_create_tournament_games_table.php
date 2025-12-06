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
        Schema::create('tournament_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_card_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->enum('status', ['open', 'closed', 'finished'])->default('open');
            $table->boolean('allow_single')->default(true);
            $table->boolean('allow_team')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['tournament_card_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_games');
    }
};
