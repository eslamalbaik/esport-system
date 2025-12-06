<?php

namespace Database\Seeders;

use App\Models\TournamentCard;
use Illuminate\Database\Seeder;

class TournamentCardSeeder extends Seeder
{
    public function run(): void
    {
        if (TournamentCard::count() > 0) {
            return;
        }

        TournamentCard::create([
            'title' => [
                'en' => 'LEAGUE OF LEGENDS WORLD CHAMPIONSHIP',
                'ar' => 'بطولة العالم للـ LoL',
            ],
            'date' => now()->addDays(30),
            'time' => '18:00',
            'prize' => '$5,000.00',
            'image_path' => 'content-images/tournaments/sample1.png',
            'register_url' => null,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        TournamentCard::create([
            'title' => [
                'en' => 'VALORANT CHAMPIONS SERIES',
                'ar' => 'سلسلة أبطال فالورانت',
            ],
            'date' => now()->addDays(45),
            'time' => '17:30',
            'prize' => '$3,500.00',
            'image_path' => 'content-images/tournaments/sample2.png',
            'register_url' => null,
            'is_published' => true,
            'sort_order' => 2,
        ]);
    }
}
