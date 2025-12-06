<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournament_cards', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('prize')->nullable();
            $table->string('image_path')->nullable();
            $table->string('register_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_cards');
    }
};
