<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name.en' => ['required', 'string', 'max:200'],
            'name.ar' => ['nullable', 'string', 'max:200'],
            'role.en' => ['nullable', 'string', 'max:200'],
            'role.ar' => ['nullable', 'string', 'max:200'],
            'text.en' => ['required', 'string'],
            'text.ar' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if (array_key_exists('avatar', $data)) {
            unset($data['avatar']);
        }

        return $data;
    }
}
