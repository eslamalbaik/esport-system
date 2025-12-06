<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentStarterSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            // ---------------------------
            // HOME
            // ---------------------------
            [
                'key'        => 'home.hero.title',
                'group'      => 'home',
                'type'       => 'text',
                'value'      => json_encode(['en' => 'Welcome to Our Site', 'ar' => 'مرحباً بكم في موقعنا'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'home.hero.subtitle',
                'group'      => 'home',
                'type'       => 'text',
                'value'      => json_encode(['en' => 'Your gateway to competitive gaming.', 'ar' => 'طريقك إلى ألعاب تنافسية.'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'home.hero.image',
                'group'      => 'home',
                'type'       => 'image',
                // shared image path by key-filename rule
                'value'      => json_encode(['path' => 'home.hero.png'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ---------------------------
            // ABOUT
            // ---------------------------
            [
                'key'        => 'about.header.title',
                'group'      => 'about',
                'type'       => 'text',
                'value'      => json_encode(['en' => 'About Us', 'ar' => 'معلومات عنا'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ---------------------------
            // PARTNERS
            // ---------------------------
            [
                'key'        => 'partners.header.title',
                'group'      => 'partners',
                'type'       => 'text',
                'value'      => json_encode(['en' => 'Our Partners', 'ar' => 'شركاؤنا'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key'        => 'partners.banner.image',
                'group'      => 'partners',
                'type'       => 'image',
                'value'      => json_encode(['path' => 'partners.banner.png'], JSON_UNESCAPED_UNICODE),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // upsert by 'key' so re-running is safe
        DB::table('contents')->upsert($rows, ['key'], ['group', 'type', 'value', 'updated_at']);
    }
}
