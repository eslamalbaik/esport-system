<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tournament_card_id' => [
                'required',
                'integer',
                Rule::exists('tournament_cards', 'id')->where('status', 'open'),
            ],
            'tournament_game_id' => [
                'nullable',
                'integer',
                Rule::exists('tournament_games', 'id')->where(function ($query) {
                    $query->where('tournament_card_id', $this->input('tournament_card_id'))
                        ->where('allow_team', true)
                        ->where('status', 'open');
                }),
            ],
            'teamName' => ['required', 'string', 'max:255'],
            'captainName' => ['required', 'string', 'max:255'],
            'captainEmail' => ['required', 'email', 'max:255'],
            'captainPhone' => ['required', 'string', 'max:50'],
            'teamLogo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'captainLogo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gameId' => ['nullable', 'string', 'max:255'],
            'm1' => ['nullable', 'string', 'max:255'],
            'm2' => ['nullable', 'string', 'max:255'],
            'm3' => ['nullable', 'string', 'max:255'],
            'm4' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'members' => __('At least one team member is required.'),
            'website.max' => 'Invalid submission.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'tournament_card_id' => $this->input('tournament_card_id'),
            'tournament_game_id' => $this->input('tournament_game_id'),
            'teamName' => trim((string) $this->input('teamName')),
            'captainName' => trim((string) $this->input('captainName')),
            'captainEmail' => trim((string) $this->input('captainEmail')),
            'captainPhone' => trim((string) $this->input('captainPhone')),
            'gameId' => trim((string) $this->input('gameId')),
            'm1' => trim((string) $this->input('m1')),
            'm2' => trim((string) $this->input('m2')),
            'm3' => trim((string) $this->input('m3')),
            'm4' => trim((string) $this->input('m4')),
            'website' => trim((string) $this->input('website')),
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $members = collect([
                $this->input('m1'),
                $this->input('m2'),
                $this->input('m3'),
                $this->input('m4'),
            ])->filter(fn ($member) => filled($member));

            if ($members->isEmpty()) {
                $validator->errors()->add('members', __('At least one team member is required.'));
            }
        });
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        $members = collect([
            $data['m1'] ?? null,
            $data['m2'] ?? null,
            $data['m3'] ?? null,
            $data['m4'] ?? null,
        ])
            ->filter()
            ->map(fn ($member) => [
                'member_name' => $member,
                'member_ingame_id' => null,
            ])
            ->values()
            ->all();

        $payload = [
            'tournament_card_id' => $data['tournament_card_id'],
            'tournament_game_id' => $data['tournament_game_id'] ?? null,
            'team_name' => $data['teamName'],
            'captain_name' => $data['captainName'],
            'captain_email' => $data['captainEmail'],
            'captain_phone' => $data['captainPhone'],
            'game_id' => $data['gameId'] ?? null,
            'members' => $members,
        ];

        if (isset($data['teamLogo'])) {
            $payload['team_logo'] = $data['teamLogo'];
        }

        if (isset($data['captainLogo'])) {
            $payload['captain_logo'] = $data['captainLogo'];
        }

        return $payload;
    }
}
