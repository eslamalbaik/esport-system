<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title.en' => ['required', 'string', 'max:200'],
            'title.ar' => ['nullable', 'string', 'max:200'],
            'date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:date'],
            'time' => ['nullable', 'string', 'max:20'],
            'prize' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'register_url' => ['nullable', 'url'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if (array_key_exists('image', $data)) {
            unset($data['image']);
        }

        return $data;
    }
}
