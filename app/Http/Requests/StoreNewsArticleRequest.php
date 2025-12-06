<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreNewsArticleRequest extends FormRequest
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
            'title.en' => ['required', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:news_articles,slug'],
            'date' => ['nullable', 'date'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        unset($data['image']);

        return $data;
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->filled('slug') ? Str::slug($this->input('slug')) : null;

        $this->merge([
            'slug' => $slug ?: null,
            'date' => $this->input('date') ?: null,
        ]);
    }
}
