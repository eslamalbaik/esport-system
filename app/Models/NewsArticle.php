<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'date',
        'description',
        'image_path',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'date' => 'date',
        'is_published' => 'bool',
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

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset($this->image_path) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (self $article) {
            $titleEn = $article->title['en'] ?? null;

            if (empty($article->slug) && $titleEn) {
                $base = Str::slug($titleEn) ?: Str::random(8);
                $slug = $base;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . (++$i);
                }

                $article->slug = $slug;
            }
        });
    }
}
