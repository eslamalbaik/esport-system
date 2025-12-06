<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('group')->index();
            $table->string('type')->index();
            $table->json('value');
            $table->timestamps();
        });
        
        // Add check constraint for type if supported (MySQL 8+)
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE contents ADD CONSTRAINT chk_contents_type CHECK (type IN ("text", "image"))');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
