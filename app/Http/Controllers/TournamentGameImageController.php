<?php

namespace App\Http\Controllers;

use App\Models\TournamentGame;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TournamentGameImageController extends Controller
{
    public function __invoke(TournamentGame $game)
    {
        $path = $game->image_path;

        if (! $path) {
            abort(404);
        }

        $disk = Storage::disk('public');
        $candidates = $this->candidatePaths($path);

        foreach ($candidates as $candidate) {
            if ($disk->exists($candidate)) {
                return $this->respondFromDisk($disk, $candidate, basename($path));
            }
        }

        foreach ($candidates as $candidate) {
            $fullPath = public_path($candidate);

            if ($fullPath && is_file($fullPath)) {
                return response()->file($fullPath, [
                    'Cache-Control' => 'public, max-age=604800, immutable',
                ]);
            }
        }

        abort(404);
    }

    private function respondFromDisk(FilesystemAdapter $disk, string $relativePath, string $filename)
    {
        $mime = $disk->mimeType($relativePath) ?: 'application/octet-stream';

        $response = $disk->response($relativePath, $filename, [
            'Cache-Control' => 'public, max-age=604800, immutable',
        ]);

        $response->headers->set('Content-Type', $mime);

        return $response;
    }

    private function candidatePaths(string $path): array
    {
        $paths = [$path, ltrim($path, '/')];

        if (Str::startsWith($path, ['storage/', 'public/'])) {
            $paths[] = ltrim(preg_replace('#^(storage|public)/#', '', $path) ?? '', '/');
        }

        return array_values(array_filter(array_unique($paths)));
    }
}
