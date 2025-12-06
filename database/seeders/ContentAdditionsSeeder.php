<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentAdditionsSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('docs/content-registry.json');
        if (! file_exists($path)) {
            $this->command?->warn("Registry not found at docs/content-registry.json");
            return;
        }

        $registry = json_decode(file_get_contents($path), true) ?: [];
        $entries = $registry['entries'] ?? [];
        $count = 0;

        foreach ($entries as $e) {
            if (!isset($e['key'],$e['group'],$e['type'])) {
                $this->command?->warn("Skipping invalid entry: ".json_encode($e));
                continue;
            }

            $key   = (string)$e['key'];
            $group = (string)$e['group'];
            $type  = (string)$e['type'];

            if ($type === 'text') {
                // EN required placeholder = label|humanized key, AR optional null
                $label = isset($e['label']) && is_string($e['label']) ? $e['label'] : $this->humanizeKey($key);
                $value = ['en' => $label, 'ar' => null];
            } elseif ($type === 'image') {
                // Default to PNG unless you later upload a real file
                $value = ['path' => "{$key}.png"];
            } else {
                $this->command?->warn("Unknown type for {$key}: {$type}");
                continue;
            }

            Content::updateOrCreate(
                ['key' => $key],
                ['group' => $group, 'type' => $type, 'value' => $value]
            );

            $count++;
        }

        $this->command?->info("Upserted {$count} content rows from registry.");
    }

    private function humanizeKey(string $key): string
    {
        // "home.hero.title" => "Home Hero Title"
        $parts = array_map(fn($p) => ucfirst(str_replace('_',' ', $p)), explode('.', $key));
        return implode(' ', $parts);
    }
}