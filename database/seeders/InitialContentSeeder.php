<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class InitialContentSeeder extends Seeder
{
    public function run()
    {
        $initialContent = [
            // Home Page Content
            ['key' => 'home.hero.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Welcome to Esports Championship', 'ar' => 'مرحبًا بكم في بطولة الرياضات الإلكترونية']],
            ['key' => 'home.hero.subtitle', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Championship', 'ar' => 'البطولة']],
            ['key' => 'home.hero.description', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Join the ultimate gaming experience and compete with the best players', 'ar' => 'انضم إلى تجربة الألعاب القصوى وتنافس مع أفضل اللاعبين']],
            ['key' => 'home.hero.image', 'type' => 'image', 'group' => 'home', 'value' => ['path' => 'home.hero.image.png']],
            
            ['key' => 'home.services.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Our Services', 'ar' => 'خدماتنا']],
            ['key' => 'home.services.card1.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Experienced Trainers', 'ar' => 'مدربون ذوو خبرة']],
            ['key' => 'home.services.card1.icon', 'type' => 'image', 'group' => 'home', 'value' => ['path' => 'Subtract(1).png']],
            
            ['key' => 'home.tournaments.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Popular Tournaments', 'ar' => 'البطولات الشهيرة']],
            ['key' => 'home.tournaments.subtitle', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Join the competition', 'ar' => 'انضم إلى المنافسة']],
            
            ['key' => 'home.partners.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Our Partners', 'ar' => 'شركاؤنا']],
            ['key' => 'home.testimonials.title', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Client', 'ar' => 'عميل']],
            ['key' => 'home.testimonials.subtitle', 'type' => 'text', 'group' => 'home', 'value' => ['en' => 'Testimonials', 'ar' => 'آراء العملاء']],
            
            // Services Page Content
            ['key' => 'services.header.title', 'type' => 'text', 'group' => 'services', 'value' => ['en' => 'Our Services', 'ar' => 'خدماتنا']],
            ['key' => 'services.card1.title', 'type' => 'text', 'group' => 'services', 'value' => ['en' => 'Technology & Platform Development', 'ar' => 'التكنولوجيا وتطوير المنصات']],
            ['key' => 'services.card1.item1', 'type' => 'text', 'group' => 'services', 'value' => ['en' => 'Custom tournament platforms and registration portals', 'ar' => 'منصات بطولات مخصصة وبوابات تسجيل']],
            
            // News Page Content
            ['key' => 'news.header.main_title', 'type' => 'text', 'group' => 'news', 'value' => ['en' => 'E-Sports', 'ar' => 'الرياضات الإلكترونية']],
            ['key' => 'news.header.section_title', 'type' => 'text', 'group' => 'news', 'value' => ['en' => 'Our News', 'ar' => 'أخبارنا']],
            ['key' => 'news.article1.title', 'type' => 'text', 'group' => 'news', 'value' => ['en' => 'Movie Night Under the Stars', 'ar' => 'ليلة سينمائية تحت النجوم']],
            ['key' => 'news.article1.date', 'type' => 'text', 'group' => 'news', 'value' => ['en' => 'July 10, 2024', 'ar' => '10 يوليو 2024']],
            ['key' => 'news.article1.image', 'type' => 'image', 'group' => 'news', 'value' => ['path' => 'our-news-page4.png']],
            
            // About Page Content
            ['key' => 'about.header.text', 'type' => 'text', 'group' => 'about', 'value' => ['en' => 'About Us', 'ar' => 'من نحن']],
            ['key' => 'about.story.title', 'type' => 'text', 'group' => 'about', 'value' => ['en' => 'Our Story', 'ar' => 'قصتنا']],
            ['key' => 'about.mission.title', 'type' => 'text', 'group' => 'about', 'value' => ['en' => 'Our Mission', 'ar' => 'مهمتنا']],
            ['key' => 'about.vision.title', 'type' => 'text', 'group' => 'about', 'value' => ['en' => 'Our Vision', 'ar' => 'رؤيتنا']],
            
            // Registration Pages Content
            ['key' => 'team_registration.header.title', 'type' => 'text', 'group' => 'team_registration', 'value' => ['en' => 'E-Sports', 'ar' => 'الرياضات الإلكترونية']],
            ['key' => 'team_registration.form.team_name', 'type' => 'text', 'group' => 'team_registration', 'value' => ['en' => 'Team Name', 'ar' => 'اسم الفريق']],
            ['key' => 'team_registration.form.captain_name', 'type' => 'text', 'group' => 'team_registration', 'value' => ['en' => 'Captain\'s Name', 'ar' => 'اسم القائد']],
            
            ['key' => 'single_registration.header.title', 'type' => 'text', 'group' => 'single_registration', 'value' => ['en' => 'E-Sports', 'ar' => 'الرياضات الإلكترونية']],
            ['key' => 'single_registration.form.player_name', 'type' => 'text', 'group' => 'single_registration', 'value' => ['en' => 'Player Name', 'ar' => 'اسم اللاعب']],
        ];

        foreach ($initialContent as $contentData) {
            Content::updateOrCreate(
                ['key' => $contentData['key']],
                $contentData
            );
        }
        
        $this->command->info('Initial content seeded successfully! Created ' . count($initialContent) . ' content records.');
    }
}
