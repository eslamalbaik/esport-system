<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tournament_cards', function (Blueprint $table) {
            if (!Schema::hasColumn('tournament_cards', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }

            if (!Schema::hasColumn('tournament_cards', 'status')) {
                $table->string('status')->default('open')->after('register_url');
            }
        });

        $existing = DB::table('tournament_cards')
            ->select('id', 'title', 'slug', 'status')
            ->get();

        foreach ($existing as $card) {
            $updates = [];

            if (is_null($card->slug)) {
                $titles = json_decode($card->title ?? '[]', true) ?: [];
                $base = isset($titles['en']) ? Str::slug($titles['en']) : null;

                if (!$base && $titles) {
                    $base = Str::slug(collect($titles)->first());
                }

                if (!$base) {
                    $base = 'tournament-' . $card->id;
                }

                $slug = $base;
                $i = 1;
                while (DB::table('tournament_cards')->where('slug', $slug)->where('id', '!=', $card->id)->exists()) {
                    $slug = $base . '-' . (++$i);
                }

                $updates['slug'] = $slug;
            }

            if (is_null($card->status)) {
                $updates['status'] = 'open';
            }

            if ($updates) {
                DB::table('tournament_cards')->where('id', $card->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_cards', function (Blueprint $table) {
            if (Schema::hasColumn('tournament_cards', 'slug')) {
                $table->dropUnique('tournament_cards_slug_unique');
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('tournament_cards', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
