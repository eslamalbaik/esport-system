<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.en' => ['nullable', 'string', 'max:200'],
            'name.ar' => ['nullable', 'string', 'max:200'],
            'description.en' => ['nullable', 'string'],
            'description.ar' => ['nullable', 'string'],
            'history.en' => ['nullable', 'string'],
            'history.ar' => ['nullable', 'string'],
            'media_type' => ['required', 'in:image,video'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'video_url' => ['nullable', 'string', 'max:500'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('partners', 'slug')],
            'is_published' => ['sometimes', 'boolean'],
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
