<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'description',
        'history',
        'slug',
        'media_type',
        'image_path',
        'video_url',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'history' => 'array',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey()
    {
        return $this->slug ?: $this->getKey();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        $query = static::query();

        if ($field === 'slug') {
            return $query->where('slug', $value)
                ->orWhere('id', $value)
                ->firstOrFail();
        }

        return $query->where($field, $value)->firstOrFail();
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function displayName(string $locale, ?string $fallback = 'en'): string
    {
        return $this->displayText($this->name, $locale, $fallback);
    }

    public function displayText(array|string|null $field, string $locale, ?string $fallback = 'en'): string
    {
        if (is_array($field)) {
            if (!empty($field[$locale])) {
                return $field[$locale];
            }

            if ($fallback && !empty($field[$fallback])) {
                return $field[$fallback];
            }

            foreach ($field as $value) {
                if ($value) {
                    return $value;
                }
            }

            return '';
        }

        return $field ?? '';
    }

    public function mediaTag(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $alt = e($this->displayName($locale));

        if ($this->media_type === 'video' && $this->video_url) {
            $src = e($this->video_url);

            return <<<HTML
<div class="ratio-16x9"><iframe src="{$src}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>
HTML;
        }

        if ($this->media_type === 'image' && $this->image_path) {
            $src = e(asset($this->image_path));

            return <<<HTML
<img src="{$src}" alt="{$alt}" class="w-full h-full object-cover" />
HTML;
        }

        return '';
    }
}
