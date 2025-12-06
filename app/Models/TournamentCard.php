<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TournamentCard extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'date',
        'end_date',
        'time',
        'prize',
        'image_path',
        'register_url',
        'is_published',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'title' => 'array',
        'date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'open');
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset($this->image_path) : null;
    }

    public function titleFor(string $locale, ?string $fallback = 'en'): string
    {
        $titles = $this->title ?? [];

        if (array_key_exists($locale, $titles) && $titles[$locale]) {
            return $titles[$locale];
        }

        if ($fallback && array_key_exists($fallback, $titles) && $titles[$fallback]) {
            return $titles[$fallback];
        }

        return '';
    }

    public function singleRegistrations()
    {
        return $this->hasMany(SingleRegistration::class);
    }

    public function teamRegistrations()
    {
        return $this->hasMany(TeamRegistration::class);
    }

    public function winner()
    {
        return $this->hasOne(Winner::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(TournamentGame::class, 'tournament_card_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (self $card) {
            $titleEn = $card->title['en'] ?? null;

            if (empty($card->slug) && $titleEn) {
                $base = Str::slug($titleEn) ?: Str::random(8);
                $slug = $base;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . (++$i);
                }

                $card->slug = $slug;
            }
        });
    }
}
