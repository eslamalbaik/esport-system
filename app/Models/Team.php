<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'slug',
        'description',
        'values',
        'image_path',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'role' => 'array',
        'description' => 'array',
        'values' => 'array',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope published teams.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope ordered listing.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name->en');
    }

    /**
     * Fetch a localized text value with fallback.
     */
    public function textFor(array|string|null $field, string $locale, string $fallback = 'en'): string
    {
        if (is_array($field)) {
            $value = $field[$locale] ?? $field[$fallback] ?? null;
            return is_string($value) ? $value : '';
        }

        if (is_string($field)) {
            return $field;
        }

        return '';
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset($this->image_path) : null;
    }
}
