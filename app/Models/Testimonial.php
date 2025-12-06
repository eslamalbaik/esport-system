<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'text',
        'avatar_path',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'role' => 'array',
        'text' => 'array',
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

    public function nameFor(string $locale, ?string $fallback = 'en'): string
    {
        $value = $this->name ?? [];
        return $value[$locale] ?? ($fallback ? ($value[$fallback] ?? '') : '');
    }

    public function roleFor(string $locale, ?string $fallback = 'en'): string
    {
        $value = $this->role ?? [];
        return $value[$locale] ?? ($fallback ? ($value[$fallback] ?? '') : '');
    }

    public function textFor(string $locale, ?string $fallback = 'en'): string
    {
        $value = $this->text ?? [];
        return $value[$locale] ?? ($fallback ? ($value[$fallback] ?? '') : '');
    }
}
