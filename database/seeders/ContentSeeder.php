<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Naming Convention: page.section.item
     * Groups: page name (home, about, team, tournaments, auth, etc.)
     * 
     * Text entries use bilingual format: ['en' => 'English', 'ar' => 'Arabic']
     * Image entries use path format: ['path' => 'filename.extension']
     */
    public function run(): void
    {
        $contents = [
            // Home Page Content
            [
                'key' => 'home.hero.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'EPIC ESPORTS',
                    'ar' => 'رياضة إلكترونية ملحمية'
                ]
            ],
            [
                'key' => 'home.hero.subtitle',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'TOURNAMENT',
                    'ar' => 'البطولة'
                ]
            ],
            [
                'key' => 'home.hero.description',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Experience the ultimate competitive gaming arena where champions are made and legends are born.',
                    'ar' => 'اختبر الساحة النهائية للألعاب التنافسية حيث يُصنع الأبطال وتولد الأساطير.'
                ]
            ],
            [
                'key' => 'home.cta.button',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Register Now',
                    'ar' => 'سجل الآن'
                ]
            ],
            [
                'key' => 'home.countdown.months',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Months',
                    'ar' => 'أشهر'
                ]
            ],
            [
                'key' => 'home.countdown.days',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Days',
                    'ar' => 'أيام'
                ]
            ],
            [
                'key' => 'home.countdown.minutes',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Minutes',
                    'ar' => 'دقائق'
                ]
            ],
            [
                'key' => 'home.countdown.target_datetime',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => '2025-12-31T18:00:00+00:00',
                    'ar' => '2025-12-31T18:00:00+00:00'
                ]
            ],
            [
                'key' => 'home.hero.tag.ready',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Ready For The',
                    'ar' => 'مستعد لـ'
                ]
            ],
            [
                'key' => 'home.hero.tag.suspension',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Suspension',
                    'ar' => 'التشويق'
                ]
            ],
            [
                'key' => 'home.hero.tag.esports',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Esports',
                    'ar' => 'الرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'home.services.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Our Services',
                    'ar' => 'خدماتنا'
                ]
            ],
            [
                'key' => 'home.services.card1.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Experienced Trainers',
                    'ar' => 'مدربون ذوو خبرة'
                ]
            ],
            [
                'key' => 'home.services.card1.description',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Endless action that keeps players coming back.',
                    'ar' => 'إثارة لا تنتهي تجعل اللاعبين يعودون مرارًا وتكرارًا.'
                ]
            ],
            [
                'key' => 'home.services.card2.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Every Console',
                    'ar' => 'جميع أجهزة الألعاب'
                ]
            ],
            [
                'key' => 'home.services.card2.description',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'We deliver the complete esports experience.',
                    'ar' => 'نقدم تجربة الرياضات الإلكترونية الكاملة.'
                ]
            ],
            [
                'key' => 'home.services.card3.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Live Streaming',
                    'ar' => 'البث المباشر'
                ]
            ],
            [
                'key' => 'home.services.card3.description',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'One destination for unforgettable events.',
                    'ar' => 'وجهة واحدة للأحداث التي لا تُنسى.'
                ]
            ],
            [
                'key' => 'home.tournaments.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Popular Tournament',
                    'ar' => 'البطولة الشائعة'
                ]
            ],
            [
                'key' => 'home.tournaments.subtitle',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Join the most exciting tournaments in the region',
                    'ar' => 'انضم إلى أكثر البطولات إثارة في المنطقة'
                ]
            ],
            [
                'key' => 'home.partners.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Our Partners',
                    'ar' => 'شركاؤنا'
                ]
            ],
            [
                'key' => 'home.testimonials.title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Client',
                    'ar' => 'عميل'
                ]
            ],
            [
                'key' => 'home.testimonials.subtitle',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Testimonial',
                    'ar' => 'شهادة'
                ]
            ],
            [
                'key' => 'home.testimonials.description',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Our Client feedback is overseas and Localy',
                    'ar' => 'تقييمات عملائنا من الخارج ومحلياً'
                ]
            ],

            // Testimonials Content
            [
                'key' => 'home.testimonial1.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Mickdad Abbas',
                    'ar' => 'مقداد عباس'
                ]
            ],
            [
                'key' => 'home.testimonial1.role',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Founder',
                    'ar' => 'المؤسس'
                ]
            ],
            [
                'key' => 'home.testimonial1.text',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'The tournament was organized with such professionalism and excitement. From the stage setup to the smooth coordination of matches, everything felt world-class. I truly enjoyed being part of it and can\'t wait to join their next esports event!',
                    'ar' => 'تم تنظيم البطولة بمهنية وإثارة فائقة. من إعداد المنصة إلى التنسيق السلس للمباريات، كل شيء بدا بمستوى عالمي. لقد استمتعت حقاً بكوني جزءاً منها ولا أستطيع الانتظار للانضمام إلى حدث الرياضات الإلكترونية التالي!'
                ]
            ],

            // Tournament Lists
            [
                'key' => 'home.tournament.dubai_police',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Dubai Police Esports Tournament',
                    'ar' => 'بطولة شرطة دبي للرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'home.tournament.que_club',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Que Club 1v1 League of Legends Showdown',
                    'ar' => 'مواجهة نادي كيو واحد ضد واحد في ليج أوف ليجندز'
                ]
            ],
            [
                'key' => 'home.tournament.emirates_festival',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'EMIRATES ESPORTS FESTIVAL 22',
                    'ar' => 'مهرجان الإمارات للرياضات الإلكترونية 22'
                ]
            ],
            [
                'key' => 'home.tournament.manchester_fifa',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Manchester City FIFA Cup powered by MIDEA',
                    'ar' => 'كأس مانشستر سيتي فيفا بدعم من ميديا'
                ]
            ],
            [
                'key' => 'home.tournament.dota_mena',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'DOTA 2 MENA TOURNAMENT',
                    'ar' => 'بطولة دوتا 2 للشرق الأوسط وشمال أفريقيا'
                ]
            ],

            // About Page Content
            [
                'key' => 'about.header.title',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'WHO WE ARE ?',
                    'ar' => 'من نحن؟'
                ]
            ],
            [
                'key' => 'about.header.text',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'About Us',
                    'ar' => 'عنا'
                ]
            ],
            [
                'key' => 'about.stats.games',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Games',
                    'ar' => 'ألعاب'
                ]
            ],
            [
                'key' => 'about.stats.locations',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Locations',
                    'ar' => 'مواقع'
                ]
            ],
            [
                'key' => 'about.stats.prizes',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Total Prizes',
                    'ar' => 'إجمالي الجوائز'
                ]
            ],
            [
                'key' => 'about.story.title',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Our Story',
                    'ar' => 'قصتنا'
                ]
            ],
            [
                'key' => 'about.story.text',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'In early winter 2020, amidst a raging pandemic, FOUR04 ESPORTS was born. Our goal is to reinvent the region\'s esports championship by bringing together diverse expert teams to execute events that serve the game community better.',
                    'ar' => 'في أوائل شتاء 2020، وسط جائحة مستعرة، وُلدت FOUR04 ESPORTS. هدفنا هو إعادة ابتكار بطولات الرياضات الإلكترونية في المنطقة من خلال جمع فرق الخبراء المتنوعة لتنفيذ أحداث تخدم مجتمع الألعاب بشكل أفضل.'
                ]
            ],
            [
                'key' => 'about.mission.title',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Our Mission',
                    'ar' => 'مهمتنا'
                ]
            ],
            [
                'key' => 'about.mission.text',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Establish a scalable esports platform in the Middle East, linking local and international communities with solutions for players and brands to get involved.',
                    'ar' => 'إنشاء منصة رياضات إلكترونية قابلة للتطوير في الشرق الأوسط، تربط المجتمعات المحلية والدولية بحلول للاعبين والعلامات التجارية للمشاركة.'
                ]
            ],
            [
                'key' => 'about.vision.title',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Our Vision',
                    'ar' => 'رؤيتنا'
                ]
            ],
            [
                'key' => 'about.vision.text',
                'type' => 'text',
                'group' => 'about',
                'value' => [
                    'en' => 'Build a community where players feel energized and supported, with events that value mental health and lasting happiness.',
                    'ar' => 'بناء مجتمع يشعر فيه اللاعبون بالنشاط والدعم، مع أحداث تقدر الصحة النفسية والسعادة الدائمة.'
                ]
            ],

            // Services Page Content
            [
                'key' => 'services.header.title',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Our Services',
                    'ar' => 'خدماتنا'
                ]
            ],
            [
                'key' => 'services.card1.title',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Technology & Platform Development',
                    'ar' => 'التكنولوجيا وتطوير المنصات'
                ]
            ],
            [
                'key' => 'services.card1.item1',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Custom tournament platforms and registration portals',
                    'ar' => 'منصات البطولات المخصصة وبوابات التسجيل'
                ]
            ],
            [
                'key' => 'services.card1.item2',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Score tracking dashboards and live updates',
                    'ar' => 'لوحات تتبع النتائج والتحديثات المباشرة'
                ]
            ],
            [
                'key' => 'services.card1.item3',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Integration with Discord, Twitch, and other gaming tools',
                    'ar' => 'التكامل مع ديسكورد وتوتش وأدوات الألعاب الأخرى'
                ]
            ],
            [
                'key' => 'services.card1.item4',
                'type' => 'text',
                'group' => 'services',
                'value' => [
                    'en' => 'Mobile-first responsive design',
                    'ar' => 'تصميم متجاوب يركز على الهاتف المحمول'
                ]
            ],

            // Tournaments Page Content
            [
                'key' => 'tournaments.header.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'E-Sports',
                    'ar' => 'الرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'tournaments.our_tournament',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'Our Tournament',
                    'ar' => 'بطولتنا'
                ]
            ],
            [
                'key' => 'tournaments.card.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'DESAFIO EM HOWLING ABYSS: ÀS CEGAS',
                    'ar' => 'تحدي في هاولينغ أبيس: أعمى'
                ]
            ],
            [
                'key' => 'tournaments.card.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '01/11/23',
                    'ar' => '01/11/23'
                ]
            ],
            [
                'key' => 'tournaments.card.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '20:00',
                    'ar' => '20:00'
                ]
            ],
            [
                'key' => 'tournaments.card.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$ 2.000,00',
                    'ar' => '2,000.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.card.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.card.image.png']
            ],
            [
                'key' => 'tournaments.card.register',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'REGISTER',
                    'ar' => 'تسجيل'
                ]
            ],

            // Tours Registration Page Content
            [
                'key' => 'tours-reg.header.title',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'E-Sports',
                    'ar' => 'الرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'tours-reg.section.title',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'Our News',
                    'ar' => 'أخبارنا'
                ]
            ],
            [
                'key' => 'tours-reg.card.register_button',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'Register - now',
                    'ar' => 'سجل الآن'
                ]
            ],
            [
                'key' => 'tours-reg.links.single',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'Single',
                    'ar' => 'فردي'
                ]
            ],
            [
                'key' => 'tours-reg.links.team',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'Team',
                    'ar' => 'فريق'
                ]
            ],
            [
                'key' => 'tours-reg.card1.name',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'PHOENIX',
                    'ar' => 'فينكس'
                ]
            ],
            [
                'key' => 'tours-reg.card1.country',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'United Kingdom',
                    'ar' => 'المملكة المتحدة'
                ]
            ],
            [
                'key' => 'tours-reg.card1.image',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card1.image.png']
            ],
            [
                'key' => 'tours-reg.card1.ability1',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card1.ability1.png']
            ],
            [
                'key' => 'tours-reg.card1.ability2',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card1.ability2.png']
            ],
            [
                'key' => 'tours-reg.card1.ability3',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card1.ability3.png']
            ],
            [
                'key' => 'tours-reg.card1.ability4',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card1.ability4.png']
            ],
            [
                'key' => 'tours-reg.card2.name',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'JETT',
                    'ar' => 'جيت'
                ]
            ],
            [
                'key' => 'tours-reg.card2.country',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'South Korea',
                    'ar' => 'كوريا الجنوبية'
                ]
            ],
            [
                'key' => 'tours-reg.card2.image',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card2.image.png']
            ],
            [
                'key' => 'tours-reg.card2.ability1',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card2.ability1.png']
            ],
            [
                'key' => 'tours-reg.card2.ability2',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card2.ability2.png']
            ],
            [
                'key' => 'tours-reg.card2.ability3',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card2.ability3.png']
            ],
            [
                'key' => 'tours-reg.card2.ability4',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card2.ability4.png']
            ],
            [
                'key' => 'tours-reg.card3.name',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'SOVA',
                    'ar' => 'سوفا'
                ]
            ],
            [
                'key' => 'tours-reg.card3.country',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'Russia',
                    'ar' => 'روسيا'
                ]
            ],
            [
                'key' => 'tours-reg.card3.image',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card3.image.png']
            ],
            [
                'key' => 'tours-reg.card3.ability1',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card3.ability1.png']
            ],
            [
                'key' => 'tours-reg.card3.ability2',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card3.ability2.png']
            ],
            [
                'key' => 'tours-reg.card3.ability3',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card3.ability3.png']
            ],
            [
                'key' => 'tours-reg.card3.ability4',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card3.ability4.png']
            ],
            [
                'key' => 'tours-reg.card4.name',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'SAGE',
                    'ar' => 'سيج'
                ]
            ],
            [
                'key' => 'tours-reg.card4.country',
                'type' => 'text',
                'group' => 'tours-reg',
                'value' => [
                    'en' => 'China',
                    'ar' => 'الصين'
                ]
            ],
            [
                'key' => 'tours-reg.card4.image',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card4.image.png']
            ],
            [
                'key' => 'tours-reg.card4.ability1',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card4.ability1.png']
            ],
            [
                'key' => 'tours-reg.card4.ability2',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card4.ability2.png']
            ],
            [
                'key' => 'tours-reg.card4.ability3',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card4.ability3.png']
            ],
            [
                'key' => 'tours-reg.card4.ability4',
                'type' => 'image',
                'group' => 'tours-reg',
                'value' => ['path' => 'tours-reg.card4.ability4.png']
            ],

            // Authentication Pages Content
            [
                'key' => 'auth.login.title',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Login',
                    'ar' => 'تسجيل الدخول'
                ]
            ],
            [
                'key' => 'auth.login.description',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Welcome back! Please login to your account to continue your esports journey.',
                    'ar' => 'أهلاً بعودتك! يرجى تسجيل الدخول إلى حسابك لمتابعة رحلتك في الرياضات الإلكترونية.'
                ]
            ],
            [
                'key' => 'auth.login.email_placeholder',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Enter your email address',
                    'ar' => 'أدخل عنوان بريدك الإلكتروني'
                ]
            ],
            [
                'key' => 'auth.login.password_placeholder',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Enter your Password',
                    'ar' => 'أدخل كلمة المرور'
                ]
            ],
            [
                'key' => 'auth.login.remember_me',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Remember me',
                    'ar' => 'تذكرني'
                ]
            ],
            [
                'key' => 'auth.login.forgot_password',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Forgot Password?',
                    'ar' => 'نسيت كلمة المرور؟'
                ]
            ],
            [
                'key' => 'auth.login.button',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Log in',
                    'ar' => 'تسجيل الدخول'
                ]
            ],

            // Register Page
            [
                'key' => 'auth.register.title',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Sign up',
                    'ar' => 'التسجيل'
                ]
            ],
            [
                'key' => 'auth.register.description',
                'type' => 'text',
                'group' => 'auth',
                'value' => [
                    'en' => 'Join our esports community and start your competitive gaming journey today.',
                    'ar' => 'انضم إلى مجتمع الرياضات الإلكترونية الخاص بنا وابدأ رحلة الألعاب التنافسية اليوم.'
                ]
            ],

            // Footer Content
            [
                'key' => 'footer.contact.title',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Our Contact',
                    'ar' => 'اتصل بنا'
                ]
            ],
            [
                'key' => 'footer.contact.who_we_are',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Who we are ?',
                    'ar' => 'من نحن؟'
                ]
            ],
            [
                'key' => 'footer.contact.terms',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Terms and Conditions',
                    'ar' => 'الشروط والأحكام'
                ]
            ],
            [
                'key' => 'footer.contact.pobox',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'POBOX:123456',
                    'ar' => 'صندوق بريد: 123456'
                ]
            ],
            [
                'key' => 'footer.event_management.title',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Event Management',
                    'ar' => 'إدارة الفعاليات'
                ]
            ],
            [
                'key' => 'footer.event_management.email',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'info@four04.com',
                    'ar' => 'info@four04.com'
                ]
            ],
            [
                'key' => 'footer.event_management.phone',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => '+971 50123456',
                    'ar' => '+971 50123456'
                ]
            ],
            [
                'key' => 'footer.esport.title',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'E-spost',
                    'ar' => 'الرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'footer.esport.location',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Bur Dubai',
                    'ar' => 'بر دبي'
                ]
            ],
            [
                'key' => 'footer.careers.title',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Careers',
                    'ar' => 'الوظائف'
                ]
            ],
            [
                'key' => 'footer.careers.blog',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Blog',
                    'ar' => 'المدونة'
                ]
            ],
            [
                'key' => 'footer.careers.press',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Press',
                    'ar' => 'الصحافة'
                ]
            ],
            [
                'key' => 'footer.careers.partnerships',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Partnerships',
                    'ar' => 'الشراكات'
                ]
            ],
            [
                'key' => 'footer.copyright',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => '©Copyright 2025',
                    'ar' => '©حقوق الطبع والنشر 2025'
                ]
            ],
            [
                'key' => 'footer.developed_by',
                'type' => 'text',
                'group' => 'footer',
                'value' => [
                    'en' => 'Designed & Developed by Four04',
                    'ar' => 'مصمم ومطور بواسطة Four04'
                ]
            ],

            // Header/Navigation Content
            [
                'key' => 'nav.home',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Home',
                    'ar' => 'الرئيسية'
                ]
            ],
            [
                'key' => 'nav.about',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'About Us',
                    'ar' => 'عنا'
                ]
            ],
            [
                'key' => 'nav.services',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Our Services',
                    'ar' => 'خدماتنا'
                ]
            ],
            [
                'key' => 'nav.esports',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Tournaments',
                    'ar' => 'البطولات'
                ]
            ],
            [
                'key' => 'nav.events',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Events Management',
                    'ar' => 'إدارة الفعاليات'
                ]
            ],
            [
                'key' => 'nav.team',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Our Team',
                    'ar' => 'فريقنا'
                ]
            ],
            [
                'key' => 'nav.login',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Login',
                    'ar' => 'تسجيل الدخول'
                ]
            ],
            [
                'key' => 'nav.signup',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Sign Up for free',
                    'ar' => 'سجل مجاناً'
                ]
            ],
            [
                'key' => 'nav.profile',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'My Profile',
                    'ar' => 'ملفي الشخصي'
                ]
            ],
            [
                'key' => 'nav.logout',
                'type' => 'text',
                'group' => 'navigation',
                'value' => [
                    'en' => 'Logout',
                    'ar' => 'تسجيل الخروج'
                ]
            ],

            // Image Content
            [
                'key' => 'home.hero.image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.hero.image.png']
            ],
            [
                'key' => 'home.services.card1.icon',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.services.card1.icon.png']
            ],
            [
                'key' => 'home.services.card2.icon',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.services.card2.icon.png']
            ],
            [
                'key' => 'home.services.card3.icon',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.services.card3.icon.png']
            ],
            [
                'key' => 'auth.hero.image',
                'type' => 'image',
                'group' => 'auth',
                'value' => ['path' => 'auth.hero.image.png']
            ],
            [
                'key' => 'about.header.image',
                'type' => 'image',
                'group' => 'about',
                'value' => ['path' => 'about.header.image.png']
            ],
            [
                'key' => 'logo.main',
                'type' => 'image',
                'group' => 'global',
                'value' => ['path' => 'logo.main.png']
            ],
            [
                'key' => 'logo.footer',
                'type' => 'image',
                'group' => 'global',
                'value' => ['path' => 'logo.footer.png']
            ],

            // ==============================================
            // TEAM PAGE CONTENT
            // ==============================================
            [
                'key' => 'team.title',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Our Team',
                    'ar' => 'فريقنا'
                ]
            ],
            [
                'key' => 'team.member1.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Mickdad Abbas',
                    'ar' => 'مقداد عباس'
                ]
            ],
            [
                'key' => 'team.member1.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Founder',
                    'ar' => 'المؤسس'
                ]
            ],
            [
                'key' => 'team.member2.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Wysten Night',
                    'ar' => 'ويستن نايت'
                ]
            ],
            [
                'key' => 'team.member2.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'CEO',
                    'ar' => 'الرئيس التنفيذي'
                ]
            ],
            [
                'key' => 'team.member3.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'David Lee',
                    'ar' => 'ديفيد لي'
                ]
            ],
            [
                'key' => 'team.member3.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'CTO',
                    'ar' => 'مدير التكنولوجيا'
                ]
            ],
            [
                'key' => 'team.member4.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Sarah Kim',
                    'ar' => 'سارة كيم'
                ]
            ],
            [
                'key' => 'team.member4.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'COO',
                    'ar' => 'مدير العمليات'
                ]
            ],
            [
                'key' => 'team.member5.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Pro Team',
                    'ar' => 'الفريق المحترف'
                ]
            ],
            [
                'key' => 'team.member5.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Lead Developer',
                    'ar' => 'مطور رئيسي'
                ]
            ],
            [
                'key' => 'team.member6.name',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Junior Squad',
                    'ar' => 'الفريق الناشئ'
                ]
            ],
            [
                'key' => 'team.member6.role',
                'type' => 'text',
                'group' => 'team',
                'value' => [
                    'en' => 'Junior Developer',
                    'ar' => 'مطور مبتدئ'
                ]
            ],
            // Team Images
            [
                'key' => 'team.member1.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member1.image.png']
            ],
            [
                'key' => 'team.member2.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member2.image.png']
            ],
            [
                'key' => 'team.member3.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member3.image.png']
            ],
            [
                'key' => 'team.member4.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member4.image.png']
            ],
            [
                'key' => 'team.member5.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member5.image.png']
            ],
            [
                'key' => 'team.member6.image',
                'type' => 'image',
                'group' => 'team',
                'value' => ['path' => 'team.member6.image.png']
            ],

            // ==============================================
            // TOURNAMENTS PAGE CONTENT (All 8 Tournaments)
            // ==============================================
            
            // Tournament 1: League of Legends World Championship
            [
                'key' => 'tournaments.tournament1.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'LEAGUE OF LEGENDS WORLD CHAMPIONSHIP',
                    'ar' => 'بطولة العالم للعبة ليج أوف ليجندز'
                ]
            ],
            [
                'key' => 'tournaments.tournament1.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '15/12/2024',
                    'ar' => '15/12/2024'
                ]
            ],
            [
                'key' => 'tournaments.tournament1.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '18:00',
                    'ar' => '18:00'
                ]
            ],
            [
                'key' => 'tournaments.tournament1.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$5,000.00',
                    'ar' => '5,000.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament1.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament1.image.png']
            ],

            // Tournament 2: FIFA Ultimate Team Challenge
            [
                'key' => 'tournaments.tournament2.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'FIFA ULTIMATE TEAM CHALLENGE',
                    'ar' => 'تحدي فيفا التيم النهائي'
                ]
            ],
            [
                'key' => 'tournaments.tournament2.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '20/12/2024',
                    'ar' => '20/12/2024'
                ]
            ],
            [
                'key' => 'tournaments.tournament2.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '16:30',
                    'ar' => '16:30'
                ]
            ],
            [
                'key' => 'tournaments.tournament2.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$3,500.00',
                    'ar' => '3,500.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament2.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament2.image.png']
            ],

            // Tournament 3: Call of Duty Warzone Battle
            [
                'key' => 'tournaments.tournament3.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'CALL OF DUTY WARZONE BATTLE',
                    'ar' => 'معركة كول أوف ديوتي وورزون'
                ]
            ],
            [
                'key' => 'tournaments.tournament3.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '25/12/2024',
                    'ar' => '25/12/2024'
                ]
            ],
            [
                'key' => 'tournaments.tournament3.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '14:00',
                    'ar' => '14:00'
                ]
            ],
            [
                'key' => 'tournaments.tournament3.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$4,200.00',
                    'ar' => '4,200.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament3.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament3.image.png']
            ],

            // Tournament 4: Counter-Strike Global Offensive
            [
                'key' => 'tournaments.tournament4.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'COUNTER-STRIKE GLOBAL OFFENSIVE',
                    'ar' => 'كاونتر سترايك الهجوم العالمي'
                ]
            ],
            [
                'key' => 'tournaments.tournament4.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '28/12/2024',
                    'ar' => '28/12/2024'
                ]
            ],
            [
                'key' => 'tournaments.tournament4.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '19:45',
                    'ar' => '19:45'
                ]
            ],
            [
                'key' => 'tournaments.tournament4.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$6,750.00',
                    'ar' => '6,750.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament4.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament4.image.png']
            ],

            // Tournament 5: Valorant Champions Series
            [
                'key' => 'tournaments.tournament5.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'VALORANT CHAMPIONS SERIES',
                    'ar' => 'سلسلة أبطال فالورانت'
                ]
            ],
            [
                'key' => 'tournaments.tournament5.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '02/01/2025',
                    'ar' => '02/01/2025'
                ]
            ],
            [
                'key' => 'tournaments.tournament5.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '17:15',
                    'ar' => '17:15'
                ]
            ],
            [
                'key' => 'tournaments.tournament5.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$8,000.00',
                    'ar' => '8,000.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament5.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament5.image.png']
            ],

            // Tournament 6: Apex Legends Arena Masters
            [
                'key' => 'tournaments.tournament6.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'APEX LEGENDS ARENA MASTERS',
                    'ar' => 'أساتذة ساحة أبيكس ليجندز'
                ]
            ],
            [
                'key' => 'tournaments.tournament6.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '05/01/2025',
                    'ar' => '05/01/2025'
                ]
            ],
            [
                'key' => 'tournaments.tournament6.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '15:30',
                    'ar' => '15:30'
                ]
            ],
            [
                'key' => 'tournaments.tournament6.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$3,800.00',
                    'ar' => '3,800.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament6.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament6.image.png']
            ],

            // Tournament 7: Rocket League Championship Series
            [
                'key' => 'tournaments.tournament7.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'ROCKET LEAGUE CHAMPIONSHIP SERIES',
                    'ar' => 'سلسلة بطولة روكيت ليج'
                ]
            ],
            [
                'key' => 'tournaments.tournament7.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '08/01/2025',
                    'ar' => '08/01/2025'
                ]
            ],
            [
                'key' => 'tournaments.tournament7.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '13:45',
                    'ar' => '13:45'
                ]
            ],
            [
                'key' => 'tournaments.tournament7.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$2,900.00',
                    'ar' => '2,900.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament7.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament7.image.png']
            ],

            // Tournament 8: Overwatch League Grand Finals
            [
                'key' => 'tournaments.tournament8.title',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => 'OVERWATCH LEAGUE GRAND FINALS',
                    'ar' => 'النهائيات الكبرى لدوري أوفرواتش'
                ]
            ],
            [
                'key' => 'tournaments.tournament8.date',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '12/01/2025',
                    'ar' => '12/01/2025'
                ]
            ],
            [
                'key' => 'tournaments.tournament8.time',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '21:00',
                    'ar' => '21:00'
                ]
            ],
            [
                'key' => 'tournaments.tournament8.prize',
                'type' => 'text',
                'group' => 'tournaments',
                'value' => [
                    'en' => '$10,500.00',
                    'ar' => '10,500.00 دولار'
                ]
            ],
            [
                'key' => 'tournaments.tournament8.image',
                'type' => 'image',
                'group' => 'tournaments',
                'value' => ['path' => 'tournaments.tournament8.image.png']
            ],

            // ==============================================
            // TEAM REGISTRATION PAGE CONTENT
            // ==============================================
            [
                'key' => 'team_registration.header.title',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'E-Sports',
                    'ar' => 'الرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'team_registration.tabs.tournament',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Tournament Registrations',
                    'ar' => 'تسجيل البطولات'
                ]
            ],
            [
                'key' => 'team_registration.tabs.register',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Register – now',
                    'ar' => 'سجل الآن'
                ]
            ],
            [
                'key' => 'team_registration.tabs.team',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Team',
                    'ar' => 'فريق'
                ]
            ],
            [
                'key' => 'team_registration.form.team_name',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Team Name',
                    'ar' => 'اسم الفريق'
                ]
            ],
            [
                'key' => 'team_registration.form.team_name_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter your team name',
                    'ar' => 'أدخل اسم فريقك'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_name',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Captain\'s Name',
                    'ar' => 'اسم القائد'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_name_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter captain\'s name',
                    'ar' => 'أدخل اسم القائد'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_logo',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Captain\'s Logo',
                    'ar' => 'شعار القائد'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_email',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Captain\'s Email',
                    'ar' => 'بريد القائد الإلكتروني'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_email_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter captain\'s email',
                    'ar' => 'أدخل بريد القائد الإلكتروني'
                ]
            ],
            [
                'key' => 'team_registration.form.team_logo',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Team Logo',
                    'ar' => 'شعار الفريق'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_phone',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Captain\'s Phone',
                    'ar' => 'هاتف القائد'
                ]
            ],
            [
                'key' => 'team_registration.form.captain_phone_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter captain\'s phone',
                    'ar' => 'أدخل هاتف القائد'
                ]
            ],
            [
                'key' => 'team_registration.form.game_id',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Game ID',
                    'ar' => 'معرف اللعبة'
                ]
            ],
            [
                'key' => 'team_registration.form.game_id_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter Game ID',
                    'ar' => 'أدخل معرف اللعبة'
                ]
            ],
            [
                'key' => 'team_registration.form.team_members',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Team Members',
                    'ar' => 'أعضاء الفريق'
                ]
            ],
            [
                'key' => 'team_registration.form.member1',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Member 1',
                    'ar' => 'العضو 1'
                ]
            ],
            [
                'key' => 'team_registration.form.member1_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter member 1\'s name',
                    'ar' => 'أدخل اسم العضو الأول'
                ]
            ],
            [
                'key' => 'team_registration.form.member2',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Member 2',
                    'ar' => 'العضو 2'
                ]
            ],
            [
                'key' => 'team_registration.form.member2_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter member 2\'s name',
                    'ar' => 'أدخل اسم العضو الثاني'
                ]
            ],
            [
                'key' => 'team_registration.form.member3',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Member 3',
                    'ar' => 'العضو 3'
                ]
            ],
            [
                'key' => 'team_registration.form.member3_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter member 3\'s name',
                    'ar' => 'أدخل اسم العضو الثالث'
                ]
            ],
            [
                'key' => 'team_registration.form.member4',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Member 4',
                    'ar' => 'العضو 4'
                ]
            ],
            [
                'key' => 'team_registration.form.member4_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Enter member 4\'s name',
                    'ar' => 'أدخل اسم العضو الرابع'
                ]
            ],
            [
                'key' => 'team_registration.form.upload_placeholder',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Click to upload',
                    'ar' => 'انقر للرفع'
                ]
            ],
            [
                'key' => 'team_registration.form.register_button',
                'type' => 'text',
                'group' => 'team_registration',
                'value' => [
                    'en' => 'Register Team',
                    'ar' => 'سجل الفريق'
                ]
            ],
            // Team Registration Images
            [
                'key' => 'team_registration.phoenix_image',
                'type' => 'image',
                'group' => 'team_registration',
                'value' => ['path' => 'team_registration.phoenix.png']
            ],
            [
                'key' => 'team_registration.avatar_image',
                'type' => 'image',
                'group' => 'team_registration',
                'value' => ['path' => 'team_registration.avatar.png']
            ],

            // ==============================================
            // TERMS AND CONDITIONS PAGE CONTENT
            // ==============================================
            [
                'key' => 'terms.header.title',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Terms and Conditions',
                    'ar' => 'الشروط والأحكام'
                ]
            ],
            [
                'key' => 'terms.section1.title',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'National Markets Orchestrator',
                    'ar' => 'منسق الأسواق الوطنية'
                ]
            ],
            [
                'key' => 'terms.section1.content1',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Vero quis est. Quos sint ut voluptate quo pariatur ut ut culpa. Et ullam quia quia optio maiores. Qui in ut repudiandae et et voluptatem. Ipsa ratione expedita sit provident voluptatem doloremque blanditiis temporibus ab. Corporis excepturi unde ipsam maxime qui sunt ipsam sunt eos.',
                    'ar' => 'هذا نص تجريبي للشروط والأحكام. يجب أن يتم استبدال هذا النص بالنص الفعلي للشروط والأحكام باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section1.content2',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Perspiciatis earum porro dolorum molestiae perspiciatis. Eos culpa consequatur et soluta cum. Non recusandae ratione voluptatem et id atque nesciunt. Maxime delectus rerum. Totam velit ipsum aut ut. Ea dolorum vero aspernatur assumenda asperiores vitae voluptatem.',
                    'ar' => 'هذا نص تجريبي إضافي للشروط والأحكام. يجب استبدال هذا النص بالنص الفعلي باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section1.content3',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Id dolor hic sint eum blanditiis. Et veritatis libero et doloremque et cumque architecto mollitia. Quia illum enim ipsam voluptatem vitae et sit recusandae.',
                    'ar' => 'نص تجريبي ثالث للشروط والأحكام باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section2.title',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'National Metrics Planner',
                    'ar' => 'مخطط المقاييس الوطنية'
                ]
            ],
            [
                'key' => 'terms.section2.content1',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Porro suscipit alias voluptatibus atque. Culpa possimus et corrupti ut rerum architecto dolorem beatae. Et et neque. Deserunt laborum vitae quia expedita earum dolorem. Quasi occaecati est et esse. Id ex sint sunt delectus vel facilis.',
                    'ar' => 'نص تجريبي للقسم الثاني من الشروط والأحكام باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section2.content2',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Voluptatem et molestias facere ex eum provident velit. At esse qui. Accusantium iste eius aut non.',
                    'ar' => 'نص تجريبي إضافي للقسم الثاني باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section2.content3',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Distinctio labore neque illo. Nostrum sapiente placeat repellat ducimus nemo eum maiores qui. Quaerat id ut iure omnis explicabo quis id debitis. Mollitia aut voluptatem et officia. Quod placeat quia minus consequuntur sint odit impedit architecto. Odit alias quaerat soluta labore vel corporis qui omnis.',
                    'ar' => 'نص تجريبي ثالث للقسم الثاني باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section3.title',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Dynamic Intranet Administrator',
                    'ar' => 'مدير الشبكة الداخلية الديناميكية'
                ]
            ],
            [
                'key' => 'terms.section3.content1',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Doloribus saepe et consectetur voluptatum nisi. Quibusdam vero aut quas odio qui consequatur cum eligendi sunt. Quis quia est perspiciatis vel praesentium. Et tempore ipsa possimus qui ea nemo. Ipsam dolores ut vel molestiae corrupti omnis sed dolores.',
                    'ar' => 'نص تجريبي للقسم الثالث من الشروط والأحكام باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section3.content2',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Ducimus voluptate ut libero rerum ut adipisci porro voluptatem. Molestiae praesentium illo nemo eligendi qui. Magni fuga eaque facilis voluptate ipsum molestias.',
                    'ar' => 'نص تجريبي إضافي للقسم الثالث باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.section3.content3',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Sapiente sit non rerum adipisci quia placeat id. Consequatur dolore eius ut. Omnis iste voluptatum qui dolor molestiae.',
                    'ar' => 'نص تجريبي ثالث للقسم الثالث باللغة العربية.'
                ]
            ],
            [
                'key' => 'terms.consent.checkbox_text',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Approve all Terms and conditions',
                    'ar' => 'الموافقة على جميع الشروط والأحكام'
                ]
            ],
            [
                'key' => 'terms.consent.button_text',
                'type' => 'text',
                'group' => 'terms',
                'value' => [
                    'en' => 'Approve all Terms and conditions',
                    'ar' => 'الموافقة على جميع الشروط والأحكام'
                ]
            ],

            // ==============================================
            // ADDITIONAL HOME PAGE CONTENT (Missing pieces)
            // ==============================================
            [
                'key' => 'home.partners.live_indicator',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => '● Live',
                    'ar' => '● مباشر'
                ]
            ],
            [
                'key' => 'home.partners.live_title',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'LIVE: Nemiga vs Fornite',
                    'ar' => 'مباشر: نيميجا ضد فورنايت'
                ]
            ],
            [
                'key' => 'home.partners.live_subtitle',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Agung Zero Dark Channel',
                    'ar' => 'قناة أجونغ زيرو دارك'
                ]
            ],
            [
                'key' => 'home.partners.partner1.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Dubai Police',
                    'ar' => 'شرطة دبي'
                ]
            ],
            [
                'key' => 'home.partners.partner2.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Que Club',
                    'ar' => 'نادي كيو'
                ]
            ],
            [
                'key' => 'home.partners.partner3.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'EMIRATES ESPORTS FESTIVAL',
                    'ar' => 'مهرجان الإمارات للرياضات الإلكترونية'
                ]
            ],
            [
                'key' => 'home.partners.partner4.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'DOTA 2 MENA TOURNAMENT',
                    'ar' => 'بطولة دوتا 2 للشرق الأوسط وشمال أفريقيا'
                ]
            ],
            [
                'key' => 'home.partners.partner5.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Partner Five',
                    'ar' => 'الشريك الخامس'
                ]
            ],
            [
                'key' => 'home.partners.partner6.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Partner Six',
                    'ar' => 'الشريك السادس'
                ]
            ],
            [
                'key' => 'home.partners.partner7.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Partner Seven',
                    'ar' => 'الشريك السابع'
                ]
            ],
            [
                'key' => 'home.partners.partner8.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Partner Eight',
                    'ar' => 'الشريك الثامن'
                ]
            ],
            
            // Additional testimonials content
            [
                'key' => 'home.testimonial2.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Wysten Night',
                    'ar' => 'ويستن نايت'
                ]
            ],
            [
                'key' => 'home.testimonial2.role',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'CEO',
                    'ar' => 'الرئيس التنفيذي'
                ]
            ],
            [
                'key' => 'home.testimonial2.text',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'We know how to bring the esports community together! The energy, the atmosphere, and the attention to detail made the event unforgettable. It was more than just a competition — it was an experience I\'ll always remember.',
                    'ar' => 'نحن نعرف كيف نجمع مجتمع الرياضات الإلكترونية معاً! الطاقة والأجواء والاهتمام بالتفاصيل جعلت الحدث لا يُنسى. لم يكن مجرد منافسة - بل كان تجربة سأتذكرها دائماً.'
                ]
            ],
            [
                'key' => 'home.testimonial3.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Amira Saeed',
                    'ar' => 'أميرة سعيد'
                ]
            ],
            [
                'key' => 'home.testimonial3.role',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Head of Events',
                    'ar' => 'رئيسة الفعاليات'
                ]
            ],
            [
                'key' => 'home.testimonial3.text',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Top-tier production and smooth scheduling—fans loved every moment.',
                    'ar' => 'إنتاج من الدرجة الأولى وجدولة سلسة - أحب المعجبون كل لحظة.'
                ]
            ],
            [
                'key' => 'home.testimonial4.name',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Rashid Al Nuaimi',
                    'ar' => 'راشد النعيمي'
                ]
            ],
            [
                'key' => 'home.testimonial4.role',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Operations Lead',
                    'ar' => 'قائد العمليات'
                ]
            ],
            [
                'key' => 'home.testimonial4.text',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Superb coordination and hospitality—easily the best esports crew we\'ve worked with.',
                    'ar' => 'تنسيق وضيافة رائعة - بسهولة أفضل طاقم رياضات إلكترونية عملنا معه.'
                ]
            ],
            [
                'key' => 'home.subscribe.placeholder',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Enter your email address',
                    'ar' => 'أدخل عنوان بريدك الإلكتروني'
                ]
            ],
            [
                'key' => 'home.subscribe.button',
                'type' => 'text',
                'group' => 'home',
                'value' => [
                    'en' => 'Subscribe',
                    'ar' => 'اشترك'
                ]
            ],

            // ==============================================
            // ADDITIONAL IMAGES CONTENT
            // ==============================================
            [
                'key' => 'home.star.icon',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.star.icon.png']
            ],
            [
                'key' => 'home.cta.button.image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.cta.button.image.png']
            ],
            [
                'key' => 'home.tournament.badge',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.tournament.badge.png']
            ],
            [
                'key' => 'home.testimonial1.avatar',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.testimonial1.avatar.png']
            ],
            [
                'key' => 'home.partners.dubai_police_image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.partners.dubai_police.png']
            ],
            [
                'key' => 'home.partners.que_club_image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.partners.que_club.png']
            ],
            [
                'key' => 'home.partners.emirates_image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.partners.emirates.png']
            ],
            [
                'key' => 'home.partners.dota_image',
                'type' => 'image',
                'group' => 'home',
                'value' => ['path' => 'home.partners.dota.png']
            ],
        ];

        foreach ($contents as $content) {
            Content::updateOrCreate(
                ['key' => $content['key']],
                [
                    'type' => $content['type'],
                    'group' => $content['group'],
                    'value' => $content['value'],
                ]
            );
        }
    }
}
