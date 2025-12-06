<?php

namespace App\Support;

class HighlightParser
{
    /**
     * Normalize highlight data (array or legacy string) into a uniform array of [title, body].
     *
     * @param  array|string|null  $value
     * @return array<int, array{title:string, body:string}>
     */
    public static function normalize(array|string|null $value): array
    {
        if (is_array($value)) {
            if (isset($value[0]) && is_array($value[0])) {
                return collect($value)
                    ->map(fn ($entry) => self::mapEntry($entry))
                    ->values()
                    ->all();
            }

            if (isset($value['title']) || isset($value['body'])) {
                return [self::mapEntry($value)];
            }
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $blocks = preg_split("/\n{2,}/", $value) ?: [];

        return collect($blocks)
            ->map(fn ($block) => self::parseLegacyBlock($block))
            ->filter()
            ->values()
            ->all();
    }

    private static function mapEntry(?array $entry): array
    {
        return [
            'title' => isset($entry['title']) ? trim((string) $entry['title']) : '',
            'body' => isset($entry['body']) ? trim((string) $entry['body']) : '',
        ];
    }

    private static function parseLegacyBlock(string $block): ?array
    {
        $block = trim($block);

        if ($block === '') {
            return null;
        }

        $title = '';
        $body = $block;

        foreach (['::', '||', '|'] as $separator) {
            if (str_contains($block, $separator)) {
                [$title, $body] = array_map('trim', explode($separator, $block, 2));
                break;
            }
        }

        return [
            'title' => $title,
            'body' => $body,
        ];
    }
}
