<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        if (Testimonial::count() > 0) {
            return;
        }

        Testimonial::create([
            'name' => [
                'en' => 'Mickdad Abbas',
                'ar' => 'مكداد عباس',
            ],
            'role' => [
                'en' => 'Founder',
                'ar' => 'المؤسس',
            ],
            'text' => [
                'en' => 'The tournament was organized with such professionalism and excitement. Everything felt world-class.',
                'ar' => 'كان تنظيم البطولة احترافياً ومثيراً للغاية. كل شيء كان بمستوى عالمي.',
            ],
            'avatar_path' => 'content-images/testimonials/sample1.png',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Testimonial::create([
            'name' => [
                'en' => 'Wysten Night',
                'ar' => 'ويستن نايت',
            ],
            'role' => [
                'en' => 'CEO',
                'ar' => 'الرئيس التنفيذي',
            ],
            'text' => [
                'en' => 'They know how to bring the esports community together! An experience I will always remember.',
                'ar' => 'يعرفون كيف يجمعون مجتمع الرياضات الإلكترونية! كانت تجربة لا تُنسى.',
            ],
            'avatar_path' => 'content-images/testimonials/sample2.png',
            'is_published' => true,
            'sort_order' => 2,
        ]);

        Testimonial::create([
            'name' => [
                'en' => 'Amira Saeed',
                'ar' => 'أميرة سعيد',
            ],
            'role' => [
                'en' => 'Head of Events',
                'ar' => 'رئيسة الفعاليات',
            ],
            'text' => [
                'en' => 'Top-tier production and smooth scheduling—fans loved every moment.',
                'ar' => 'إنتاج على أعلى مستوى وجدولة سلسة—أحب الجمهور كل لحظة.',
            ],
            'avatar_path' => 'content-images/testimonials/sample3.png',
            'is_published' => true,
            'sort_order' => 3,
        ]);
    }
}
