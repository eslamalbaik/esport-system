<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryItemFactory> */
    use HasFactory;

    public const VIDEO_TYPE_YOUTUBE = 'youtube';
    public const VIDEO_TYPE_VIMEO = 'vimeo';
    public const VIDEO_TYPE_FILE = 'file';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'video_type',
        'video_url',
        'video_path',
        'thumb_path',
        'is_published',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'published_at' => 'datetime',
        'is_published' => 'bool',
        'sort_order' => 'int',
    ];

    protected $attributes = [
        'is_published' => true,
        'sort_order' => 0,
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function t(string $field, ?string $locale = null, string $fallback = 'en'): string
    {
        $locale = $locale ?: app()->getLocale();

        if (!in_array($field, ['title', 'description'], true)) {
            return '';
        }

        $translations = $this->{$field} ?? [];

        if (is_array($translations) && array_key_exists($locale, $translations) && filled($translations[$locale])) {
            return $translations[$locale];
        }

        if ($fallback && is_array($translations) && array_key_exists($fallback, $translations) && filled($translations[$fallback])) {
            return $translations[$fallback];
        }

        return '';
    }

    public function excerpt(?string $locale, int $words = 40): string
    {
        return Str::words($this->t('description', $locale), $words);
    }

    public function embedHtml(bool $autoplay = false): HtmlString
    {
        $class = 'w-full aspect-video rounded-lg overflow-hidden';

        if ($this->video_type === self::VIDEO_TYPE_YOUTUBE && $this->video_url) {
            $src = $this->transformYoutubeUrl($this->video_url);
            $src .= $autoplay ? (str_contains($src, '?') ? '&' : '?') . 'autoplay=1&mute=1&playsinline=1' : '';
            $html = sprintf(
                '<iframe src="%s" class="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                e($src),
                $class
            );

            return new HtmlString($html);
        }

        if ($this->video_type === self::VIDEO_TYPE_VIMEO && $this->video_url) {
            $src = $this->transformVimeoUrl($this->video_url);
            $src .= $autoplay ? (str_contains($src, '?') ? '&' : '?') . 'autoplay=1&muted=1&playsinline=1' : '';
            $html = sprintf(
                '<iframe src="%s" class="%s" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>',
                e($src),
                $class
            );

            return new HtmlString($html);
        }

        if ($this->video_type === self::VIDEO_TYPE_FILE && $this->video_path) {
            $imageClass = trim(str_replace('aspect-video', '', $class));
            $imageClass = trim($imageClass . ' object-cover');
            $alt = $this->t('title', app()->getLocale()) ?: 'Gallery image';
            $html = sprintf(
                '<img src="%s" class="%s" alt="%s">',
                e(asset($this->video_path)),
                e($imageClass),
                e($alt)
            );

            return new HtmlString($html);
        }

        return new HtmlString('');
    }

    public function thumbnailUrl(): ?string
    {
        return $this->thumb_path ? asset($this->thumb_path) : null;
    }

    public function cardImageUrl(): ?string
    {
        if ($thumbnail = $this->thumbnailUrl()) {
            return $thumbnail;
        }

        if ($this->video_type === self::VIDEO_TYPE_FILE && $this->video_path) {
            return asset($this->video_path);
        }

        return null;
    }

    public function sourceLabel(): string
    {
        return match ($this->video_type) {
            self::VIDEO_TYPE_YOUTUBE => 'YouTube',
            self::VIDEO_TYPE_VIMEO => 'Vimeo',
            self::VIDEO_TYPE_FILE => 'Image upload',
            default => ucfirst((string) $this->video_type),
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (self $item) {
            $titleEn = $item->title['en'] ?? null;

            if (empty($item->slug) && $titleEn) {
                $base = Str::slug($titleEn) ?: Str::random(8);
                $slug = $base;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . (++$i);
                }

                $item->slug = $slug;
            }
        });
    }

    private function transformYoutubeUrl(string $url): string
    {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:embed/|watch\?v=|shorts/))([\w\-]{11})~', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }

    private function transformVimeoUrl(string $url): string
    {
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return $url;
    }
}
