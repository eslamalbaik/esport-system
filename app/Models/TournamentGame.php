<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TournamentGame extends Model
{
    protected $fillable = [
        'tournament_card_id',
        'title',
        'slug',
        'description',
        'image_path',
        'status',
        'allow_single',
        'allow_team',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'allow_single' => 'boolean',
        'allow_team' => 'boolean',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(TournamentCard::class, 'tournament_card_id');
    }

    public function winnerEntry(): HasOne
    {
        return $this->hasOne(TournamentGameWinner::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
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

    public function imageUrl(): ?string
    {
        $path = $this->image_path;

        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if ($this->publicAssetExists($path)) {
            return asset($path);
        }

        try {
            if (Storage::disk('public')->exists($path)) {
                return route('tournament-games.image', $this);
            }
        } catch (Throwable $e) {
            // Ignore disk issues and fall through to null so UI can fall back.
        }

        return null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (self $game) {
            if (! $game->slug) {
                $baseTitle = $game->title['en'] ?? collect($game->title ?? [])->first() ?? Str::random(8);
                $base = Str::slug($baseTitle) ?: Str::random(8);
                $slug = $base;
                $i = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . (++$i);
                }

                $game->slug = $slug;
            }
        });
    }

    private function publicAssetExists(string $path): bool
    {
        if (Str::startsWith($path, ['storage/', 'public/'])) {
            return false;
        }

        $fullPath = public_path($path);

        return is_string($fullPath) && is_file($fullPath);
    }
}
