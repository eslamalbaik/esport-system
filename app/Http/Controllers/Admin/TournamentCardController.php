<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentCardRequest;
use App\Http\Requests\UpdateTournamentCardRequest;
use App\Models\TournamentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TournamentCardController extends Controller
{
    public function index()
    {
        $cards = TournamentCard::ordered()->paginate(20);

        return view('admin.tournaments.cards.index', compact('cards'));
    }

    public function create()
    {
        return view('admin.tournaments.cards.create');
    }

    public function store(StoreTournamentCardRequest $request)
    {
        $data = $this->normaliseOptionalFields($request->validated());
        $data['title'] = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (TournamentCard::max('sort_order') ?? 0) + 1;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->storeImage($request->file('image'));
        }

        TournamentCard::create($data);

        return redirect()
            ->route('admin.tournament-cards.index')
            ->with('ok', __('Card created.'));
    }

    public function edit(TournamentCard $tournament_card)
    {
        return view('admin.tournaments.cards.edit', ['card' => $tournament_card]);
    }

    public function update(UpdateTournamentCardRequest $request, TournamentCard $tournament_card)
    {
        $data = $this->normaliseOptionalFields($request->validated());
        $data['title'] = [
            'en' => $request->input('title.en'),
            'ar' => $request->input('title.ar'),
        ];
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $this->deleteImage($tournament_card->image_path);
            $data['image_path'] = $this->storeImage($request->file('image'));
        }

        $tournament_card->update($data);

        return redirect()
            ->route('admin.tournament-cards.index')
            ->with('ok', __('Card updated.'));
    }

    public function destroy(TournamentCard $tournament_card)
    {
        $this->deleteImage($tournament_card->image_path);
        $tournament_card->delete();

        return redirect()
            ->route('admin.tournament-cards.index')
            ->with('ok', __('Card deleted.'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer', 'exists:tournament_cards,id'],
            'orders.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($validated['orders'] as $order) {
            TournamentCard::whereKey($order['id'])->update([
                'sort_order' => $order['sort_order'],
            ]);
        }

        return response()->json(['ok' => true]);
    }

    private function normaliseOptionalFields(array $data): array
    {
        foreach (['date', 'end_date', 'time', 'prize', 'register_url'] as $key) {
            if (array_key_exists($key, $data) && $data[$key] === '') {
                $data[$key] = null;
            }
        }

        return $data;
    }

    private function storeImage($file): string
    {
        $directory = public_path('content-images/tournaments');

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'png');
        $name = 'card-' . Str::random(12) . '.' . $extension;
        $file->move($directory, $name);

        return 'content-images/tournaments/' . $name;
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
