<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SingleRegistrationRequest extends FormRequest
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
                        ->where('allow_single', true)
                        ->where('status', 'open');
                }),
            ],
            'player_name' => ['required', 'string', 'max:255'],
            'ingame_id' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'website' => ['nullable', 'string', 'max:0'], // honeypot
        ];
    }

    public function messages(): array
    {
        return [
            'website.max' => 'Invalid submission.',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        unset($data['website']);

        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'player_name' => trim((string) $this->input('player_name')),
            'ingame_id' => trim((string) $this->input('ingame_id')),
            'website' => trim((string) $this->input('website')),
        ]);
    }
}
