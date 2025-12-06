<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ContentStarterSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ContentStarterSeeder::class,
            ContentAdditionsSeeder::class,
            ContentSeeder::class,
            InitialContentSeeder::class,
            TournamentCardSeeder::class,
            TestimonialSeeder::class,
            PartnerSeeder::class,
            NewsArticleSeeder::class,
        ]);
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@esport.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('admin123'),
            ]
        );
    }
}
