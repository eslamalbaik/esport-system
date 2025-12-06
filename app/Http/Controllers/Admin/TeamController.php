<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::query()
            ->ordered()
            ->paginate(20);

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $defaultSortOrder = (Team::max('sort_order') ?? 0) + 1;

        return view('admin.teams.create', [
            'team' => null,
            'defaultSortOrder' => $defaultSortOrder,
        ]);
    }

    public function store(StoreTeamRequest $request)
    {
        $data = $this->extractData($request);
        $data['slug'] = $this->makeSlug($data['name']['en'] ?? null);
        $data['sort_order'] = $request->filled('sort_order')
            ? (int) $request->input('sort_order')
            : ((Team::max('sort_order') ?? 0) + 1);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request->file('image'), $data['slug']);
        }

        $team = Team::create($data);

        return redirect()->route('admin.teams.index')->with('ok', __('Team created.'));
    }

    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', [
            'team' => $team,
            'defaultSortOrder' => $team->sort_order,
        ]);
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $data = $this->extractData($request);
        $data['slug'] = $this->makeSlug($data['name']['en'] ?? null, $team);
        $data['sort_order'] = $request->filled('sort_order')
            ? (int) $request->input('sort_order')
            : $team->sort_order;

        if ($request->hasFile('image')) {
            $this->deleteImage($team->image_path);
            $data['image_path'] = $this->storeImage($request->file('image'), $data['slug']);
        }

        $team->update($data);

        return redirect()->route('admin.teams.index')->with('ok', __('Team updated.'));
    }

    public function destroy(Team $team)
    {
        $this->deleteImage($team->image_path);
        $team->delete();

        return redirect()->route('admin.teams.index')->with('ok', __('Team deleted.'));
    }

    private function extractData(StoreTeamRequest|UpdateTeamRequest $request): array
    {
        return [
            'name' => [
                'en' => $request->input('name.en'),
                'ar' => $request->input('name.ar'),
            ],
            'role' => null,
            'description' => $this->prepareNullableTranslatable(
                $request->input('description.en'),
                $request->input('description.ar')
            ),
            'values' => $this->prepareHighlights($request),
            'is_published' => $request->boolean('is_published'),
        ];
    }

    private function prepareNullableTranslatable(?string $en, ?string $ar): ?array
    {
        $payload = [
            'en' => $en,
            'ar' => $ar,
        ];

        return (blank($en) && blank($ar)) ? null : $payload;
    }

    private function makeSlug(?string $englishName, ?Team $team = null): string
    {
        $base = Str::slug($englishName ?? '') ?: ($team?->slug ?? 'team');
        $slug = $base;
        $suffix = 2;

        while ($this->slugExists($slug, $team?->id)) {
            $slug = sprintf('%s-%d', $base, $suffix++);
        }

        return $slug;
    }

    private function prepareHighlights(StoreTeamRequest|UpdateTeamRequest $request): ?array
    {
        $locales = ['en', 'ar'];
        $result = [];

        foreach ($locales as $locale) {
            $entries = $request->input("values.$locale", []);

            if (!is_array($entries)) {
                $entries = [];
            }

            $normalized = [];

            foreach (array_slice($entries, 0, 3) as $entry) {
                $title = trim((string)($entry['title'] ?? ''));
                $body = trim((string)($entry['body'] ?? ''));

                if ($title === '' && $body === '') {
                    continue;
                }

                $normalized[] = [
                    'title' => $title,
                    'body' => $body,
                ];
            }

            if (!empty($normalized)) {
                $result[$locale] = $normalized;
            }
        }

        return empty($result) ? null : $result;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return Team::where('slug', $slug)
            ->when($ignoreId, fn ($query, $id) => $query->where('id', '<>', $id))
            ->exists();
    }

    private function storeImage(UploadedFile $file, string $slug): string
    {
        $directory = public_path('content-images/teams');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'png');
        $name = sprintf('%s-%s.%s', $slug ?: 'team', Str::random(6), $extension);

        $file->move($directory, $name);

        return 'content-images/teams/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::isFile($fullPath)) {
            File::delete($fullPath);
        }
    }
}
