<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateNewsArticleRequest extends FormRequest
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
        $articleId = $this->route('news_article')?->getKey();

        return [
            'title.en' => ['required', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:news_articles,slug,' . $articleId],
            'date' => ['nullable', 'date'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
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
