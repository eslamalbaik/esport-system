<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $payloads = [
            'Dubai Police' => [
                'description' => [
                    'en' => <<<TEXT
Organized by Dubai Police in collaboration with f0ur04, the Dubai Police Esports Tournament empowers UAE talent through inclusive competitive play.
- Tournament Name: Dubai Police Esports Challenge
- Edition: 4th Edition
- Game Titles: FIFA, Valorant, Call of Duty, Fortnite
- Participants: Open to UAE students, professionals, and esports enthusiasts
- Format: Online qualifiers leading to live finals at Dubai Police Officers Club
- Prizes: Trophies, gaming gear, and cash prizes for top winners
- Theme: #Be_Responsible — discipline, teamwork, healthy gaming habits
TEXT,
                    'ar' => <<<TEXT
تنظم شرطة دبي بالتعاون مع f0ur04 تحدي شرطة دبي للرياضات الإلكترونية لتمكين المواهب المحلية عبر منافسات شاملة.
- اسم البطولة: تحدي شرطة دبي للرياضات الإلكترونية
- النسخة: الرابعة
- الألعاب: فيفا، فالورانت، كول أوف ديوتي، فورتنايت
- المشاركون: طلاب، محترفون، ومجتمع الرياضات الإلكترونية في الإمارات
- التنسيق: تصفيات عبر الإنترنت ونهائيات مباشرة في نادي ضباط شرطة دبي
- الجوائز: كؤوس، معدات ألعاب، وجوائز نقدية للفائزين
- الشعار: #كن_مسؤولاً — الانضباط، العمل الجماعي، وعادات اللعب الصحية
TEXT,
                ],
                'history' => [
                    'en' => <<<TEXT
Support youth talent in digital sports
Encourage responsible gaming habits
Promote respect, collaboration, and strategic thinking
Bridge the gap between traditional sports and esports communities
2022 - FIFA, Valorant, Call of Duty, Fortnite — 3 days — 150K AED prizes — 10,000 players
2023 - FIFA, Valorant, Call of Duty, Fortnite — 4 days — 150K AED prizes — 10,000 players
2024 - FIFA, Valorant, Call of Duty, Fortnite — 5 days — 150K AED prizes — 10,000 players
2025 - FIFA, Valorant, Call of Duty, Fortnite — 4 days — 150K AED prizes — 10,000 players
TEXT,
                    'ar' => <<<TEXT
دعم المواهب الشابة في الرياضات الرقمية
تشجيع عادات اللعب المسؤولة
تعزيز قيم الاحترام والتعاون والتفكير الاستراتيجي
ردم الفجوة بين الرياضات التقليدية ومجتمع الرياضات الإلكترونية
2022 - فيفا، فالورانت، كول أوف ديوتي، فورتنايت — 3 أيام — جوائز 150 ألف درهم — 10,000 لاعب
2023 - فيفا، فالورانت، كول أوف ديوتي، فورتنايت — 4 أيام — جوائز 150 ألف درهم — 10,000 لاعب
2024 - فيفا، فالورانت، كول أوف ديوتي، فورتنايت — 5 أيام — جوائز 150 ألف درهم — 10,000 لاعب
2025 - فيفا، فالورانت، كول أوف ديوتي، فورتنايت — 4 أيام — جوائز 150 ألف درهم — 10,000 لاعب
TEXT,
                ],
            ],
            'Que Club' => [
                'description' => [
                    'en' => <<<TEXT
Que Club is Dubai’s flagship esports hub delivering daily LAN events, pro scrims, and collegiate tournaments with premium production quality.
- Venue: Que Club Dubai — hybrid esports cafe and broadcast studio
- Disciplines: PUBG, Valorant, CS2, EA FC, Tekken, community arcade nights
- Services: Team bootcamps, shoutcasting rooms, tournament operations
- Audience: Regional orgs, university leagues, grassroots creators
- Partners: Logitech G, NVIDIA, regional telecom sponsors
TEXT,
                    'ar' => <<<TEXT
يعد كيو كلوب مركز الرياضات الإلكترونية الأبرز في دبي مع فعاليات LAN يومية وسباقات احترافية وبطولات جامعية بإنتاج احترافي.
- الموقع: كيو كلوب دبي — مقهى ألعاب ومساحة بث هجينة
- الألعاب: ببجي، فالورانت، كاونتر سترايك 2، إي إيه إف سي، تيكن، وليالي أركيد مجتمعية
- الخدمات: معسكرات تدريب للفرق، غرف تعليق صوتي، إدارة بطولات
- الجمهور: الأندية الإقليمية، دوريات الجامعات، صناع المحتوى الناشئون
- الشركاء: لوجيتك جي، إنفيديا، ورعاة اتصالات إقليميون
TEXT,
                ],
                'history' => [
                    'en' => <<<TEXT
Cultivate a safe, high-performance gaming venue for MENA
Mentor young talents through certified coaching staff
Operate inclusive tournaments that spotlight mixed-gender rosters
2021 - Venue expansion with 200-seat arena and fiber upgrade
2022 - Hosted UAE Collegiate Esports League finals with 40 universities
2023 - Produced Valorant Spike Nations MENA qualifier
2024 - Launched Que Club Creator Series with monthly LAN showcases
TEXT,
                    'ar' => <<<TEXT
توفير مساحة لعب آمنة عالية الأداء لمنطقة الشرق الأوسط وشمال أفريقيا
رعاية المواهب الشابة عبر مدربين معتمدين
تنظيم بطولات شاملة تسلط الضوء على قوائم مختلطة
2021 - توسيع الصالة إلى 200 مقعد وترقية الألياف الضوئية
2022 - استضافة نهائيات دوري الجامعات الإماراتي بمشاركة 40 جامعة
2023 - إنتاج تصفيات فالورانت سبايك نيشنز لمنطقة الشرق الأوسط
2024 - إطلاق سلسلة صناع المحتوى في كيو كلوب مع عروض LAN شهرية
TEXT,
                ],
            ],
        ];

        $partners = DB::table('partners')->select('id', 'name')->get();

        foreach ($partners as $partner) {
            $names = $partner->name;
            if (is_string($names)) {
                $names = json_decode($names, true) ?: [];
            } elseif (!is_array($names)) {
                $names = (array) $names;
            }

            $englishName = $names['en'] ?? null;
            if (!$englishName || !isset($payloads[$englishName])) {
                continue;
            }

            $payload = $payloads[$englishName];

            DB::table('partners')
                ->where('id', $partner->id)
                ->update([
                    'description' => json_encode($payload['description'], JSON_UNESCAPED_UNICODE),
                    'history' => json_encode($payload['history'], JSON_UNESCAPED_UNICODE),
                ]);
        }
    }

    public function down(): void
    {
        $partners = ['Dubai Police', 'Que Club'];

        $records = DB::table('partners')->select('id', 'name')->get();

        foreach ($records as $record) {
            $names = $record->name;
            if (is_string($names)) {
                $names = json_decode($names, true) ?: [];
            } elseif (!is_array($names)) {
                $names = (array) $names;
            }

            $englishName = $names['en'] ?? null;
            if (!$englishName || !in_array($englishName, $partners, true)) {
                continue;
            }

            DB::table('partners')
                ->where('id', $record->id)
                ->update([
                    'description' => null,
                    'history' => null,
                ]);
        }
    }
};
