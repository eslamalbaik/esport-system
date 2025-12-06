<?php

namespace App\Support;

use App\Models\Content;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentRepository
{
    public static function text(string $key, ?string $default=null): string
    {
        $locale = App::getLocale() ?: 'en';
        $cacheKey = "cms:content:{$key}:{$locale}";

        return Cache::rememberForever($cacheKey, function () use ($key, $locale, $default) {
            $row = Content::where('key',$key)->where('type','text')->first();
            if (!$row) return $default ?? '';
            $val = $row->getTranslation('value', $locale) ?: $row->getTranslation('value','en');
            return $val ?? ($default ?? '');
        });
    }

    public static function media(string $key, ?string $default=null): string
    {
        $cacheKey = "cms:content-media:{$key}";

        return Cache::rememberForever($cacheKey, function () use ($key, $default) {
            // Use raw database query to avoid model complications
            $row = DB::table('contents')
                     ->where('key', $key)
                     ->whereIn('type', ['image', 'video'])
                     ->first();
                     
            if (!$row) return $default ? asset($default) : '';

            // Parse the JSON value
            $value = json_decode($row->value, true);
            if (is_string($value)) {
                $value = ['path' => $value];
            } elseif (!is_array($value)) {
                $value = [];
            }
            $filename = $value['path'] ?? null;

            if (!$filename) return $default ? asset($default) : '';
            // If stored path is already an absolute URL (external video/CDN), skip local versioning
            if (is_string($filename) && preg_match('~^https?://~i', $filename)) {
                return $filename;
            }
            $url = asset('content-images/'.$filename);
            $path = public_path('content-images/'.$filename);
            $version = is_string($path) && file_exists($path) ? filemtime($path) : null;

            return $version ? "{$url}?v={$version}" : $url;
        });
    }

    public static function image(string $key, ?string $default=null): string
    {
        return self::media($key, $default);
    }

    public static function video(string $key, ?string $default=null): string
    {
        return self::media($key, $default);
    }

    public static function forgetText(string $key, array $locales = []): void
    {
        foreach (self::localesForKey($key, $locales) as $locale) {
            Cache::forget("cms:content:{$key}:{$locale}");
        }
    }

    public static function forgetImage(string $key): void
    {
        self::forgetMedia($key);
    }

    public static function forgetMedia(string $key): void
    {
        Cache::forget("cms:content-media:{$key}");
    }

    protected static function localesForKey(string $key, array $locales = []): array
    {
        $defaults = array_filter([
            App::getLocale(),
            config('app.locale'),
            config('app.fallback_locale'),
            'en',
            'ar',
        ]);

        $fromContent = [];

        if (empty($locales)) {
            try {
                $content = Content::where('key', $key)->first();
                if ($content) {
                    $fromContent = array_keys($content->getTranslations('value') ?? []);
                }
            } catch (\Throwable $e) {
                $fromContent = [];
            }
        }

        $candidates = array_merge($locales, $fromContent, $defaults);

        return array_values(array_unique(array_filter($candidates)));
    }
}
