<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function asset;

class TeamRegistration extends Model
{
    protected $fillable = [
        'tournament_card_id',
        'tournament_game_id',
        'team_name',
        'captain_name',
        'captain_email',
        'captain_phone',
        'team_logo_path',
        'captain_logo_path',
        'game_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $appends = [
        'team_logo_url',
        'captain_logo_url',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(TournamentCard::class, 'tournament_card_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(TournamentGame::class, 'tournament_game_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class)->orderBy('id');
    }

    public function getTeamLogoUrlAttribute(): ?string
    {
        return static::logoPathToUrl($this->team_logo_path);
    }

    public function getCaptainLogoUrlAttribute(): ?string
    {
        return static::logoPathToUrl($this->captain_logo_path);
    }

    public static function logoPathToUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $cleanPath = Str::of($path)
            ->trim('/')
            ->replace('\\', '/')
            ->value();

        if ($cleanPath === '') {
            return null;
        }

        if (Str::startsWith($cleanPath, ['http://', 'https://', '//'])) {
            return $cleanPath;
        }

        $normalized = ltrim($cleanPath, '/');

        if (Str::startsWith($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (Str::startsWith($normalized, 'public/')) {
            $publicPath = Str::after($normalized, 'public/');
            if (file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }
        }

        if (file_exists(public_path($normalized))) {
            return asset($normalized);
        }

        if (Storage::disk('public')->exists($normalized)) {
            return Storage::disk('public')->url($normalized);
        }

        return asset('storage/' . $normalized);
    }
}
