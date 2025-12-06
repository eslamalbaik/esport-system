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
        Schema::table('partners', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->json('description')->nullable()->after('slug');
            $table->json('history')->nullable()->after('description');
        });

        $partners = DB::table('partners')->select('id', 'name', 'slug')->get();
        foreach ($partners as $partner) {
            if ($partner->slug) {
                continue;
            }

            $names = $partner->name;
            if (is_string($names)) {
                $names = json_decode($names, true) ?: [];
            } elseif (!is_array($names)) {
                $names = (array) $names;
            }

            $base = '';
            if (!empty($names['en'])) {
                $base = Str::slug($names['en']);
            }

            if (!$base) {
                $base = 'partner-' . $partner->id;
            }

            $slug = $base;
            $suffix = 1;
            while (
                DB::table('partners')
                    ->where('slug', $slug)
                    ->where('id', '<>', $partner->id)
                    ->exists()
            ) {
                $slug = $base . '-' . $suffix++;
            }

            DB::table('partners')->where('id', $partner->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['description', 'history', 'slug']);
        });
    }
};
