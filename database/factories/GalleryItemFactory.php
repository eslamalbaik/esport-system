<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleEn = $this->faker->sentence(3);
        $titleAr = 'العنوان ' . $this->faker->randomNumber(3);
        $descriptionEn = $this->faker->paragraphs(3, true);
        $descriptionAr = 'وصف ' . $this->faker->paragraph;

        $videoTypes = ['youtube', 'vimeo', 'file'];
        $videoType = $this->faker->randomElement($videoTypes);

        $videoUrl = null;
        $videoPath = null;

        if ($videoType === 'youtube') {
            $videoUrl = 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[A-Za-z0-9_-]{11}');
        } elseif ($videoType === 'vimeo') {
            $videoUrl = 'https://vimeo.com/' . $this->faker->numberBetween(1000000, 999999999);
        } else {
            $videoPath = 'content-images/gallery/' . $this->faker->unique()->lexify('upload-????') . '.jpg';
        }

        return [
            'title' => [
                'en' => $titleEn,
                'ar' => $titleAr,
            ],
            'description' => [
                'en' => $descriptionEn,
                'ar' => $descriptionAr,
            ],
            'slug' => \Illuminate\Support\Str::slug($titleEn) . '-' . $this->faker->unique()->numberBetween(10, 999),
            'video_type' => $videoType,
            'video_url' => $videoUrl,
            'video_path' => $videoPath,
            'thumb_path' => 'content-images/gallery/' . $this->faker->unique()->lexify('thumb-????') . '.jpg',
            'is_published' => true,
            'sort_order' => $this->faker->numberBetween(0, 50),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
