<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        if (NewsArticle::count() > 0) {
            return;
        }

        $articles = [
            [
                'title' => [
                    'en' => 'Community Spotlight: Rising Stars in E-Sports',
                    'ar' => 'أضواء المجتمع: نجوم صاعدة في الرياضات الإلكترونية',
                ],
                'description' => [
                    'en' => 'Our academy celebrates the incredible achievements of the latest squad to emerge from our training program. Discover how these players balanced strategy, teamwork, and relentless practice to secure their first championship title.',
                    'ar' => 'يحتفل أكاديميتنا بالإنجازات المذهلة لأحدث فريق ظهر من برنامجنا التدريبي. اكتشف كيف حافظ هؤلاء اللاعبون على التوازن بين الاستراتيجية والعمل الجماعي والممارسة المستمرة لتحقيق لقبهم الأول.',
                ],
                'date' => now()->subDays(5),
                'image_path' => 'content-images/news/sample1.jpg',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'en' => 'Behind the Scenes of the Winter Invitational',
                    'ar' => 'خلف الكواليس في بطولة الشتاء',
                ],
                'description' => [
                    'en' => 'Take a look behind the scenes of our Winter Invitational as we prep the arena, run scrimmages, and fine-tune the broadcast setup. This year’s event is set to be our biggest yet, with teams joining from across the region.',
                    'ar' => 'ألق نظرة خلف الكواليس في بطولة الشتاء لدينا حيث نجهز الساحة ونشرف على تدريبات الفرق ونضبط إعدادات البث. من المتوقع أن يكون هذا الحدث الأكبر حتى الآن مع مشاركة فرق من جميع أنحاء المنطقة.',
                ],
                'date' => now()->subDays(15),
                'image_path' => 'content-images/news/sample2.jpg',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'en' => 'Coach Insights: Building a Championship Mindset',
                    'ar' => 'رؤى المدربين: بناء عقلية الفوز بالبطولات',
                ],
                'description' => [
                    'en' => 'Head Coach Laila shares the mental frameworks she teaches every roster before tournament season kicks off. From managing pressure to sharpening communication, these insights power our competitive edge.',
                    'ar' => 'تشارك المدربة ليلى الأطر الذهنية التي تعلمها لكل تشكيلة قبل بداية موسم البطولات. من إدارة الضغط إلى تعزيز التواصل، تمنحنا هذه الرؤى ميزة تنافسية قوية.',
                ],
                'date' => now()->subDays(25),
                'image_path' => 'content-images/news/sample3.jpg',
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::create($article);
        }
    }
}
