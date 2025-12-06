<?php

use App\Support\ContentRepository;

if (! function_exists('content')) {
    function content(string $key, ?string $default = null): string {
        return ContentRepository::text($key, $default);
    }
}

if (! function_exists('content_media')) {
    function content_media(string $key, ?string $default = null): string {
        return ContentRepository::image($key, $default);
    }
}
