<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.en' => ['required', 'string', 'max:255'],
            'name.ar' => ['nullable', 'string', 'max:255'],
            'description.en' => ['nullable', 'string'],
            'description.ar' => ['nullable', 'string'],
            'values.en' => ['nullable', 'array'],
            'values.en.*.title' => ['nullable', 'string', 'max:255'],
            'values.en.*.body' => ['nullable', 'string'],
            'values.ar' => ['nullable', 'array'],
            'values.ar.*.title' => ['nullable', 'string', 'max:255'],
            'values.ar.*.body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
