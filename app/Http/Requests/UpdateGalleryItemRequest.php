<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGalleryItemRequest extends FormRequest
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
        $galleryItem = $this->route('gallery_item');

        $uploadedImageRules = [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:8192',
        ];

        if ($this->input('video_type') === 'file' && !$galleryItem?->video_path) {
            $uploadedImageRules[] = 'required';
        }

        return [
            'title.en' => ['required', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['nullable', 'string'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('gallery_items', 'slug')->ignore($galleryItem?->id),
            ],
            'video_type' => ['required', 'string', 'in:youtube,vimeo,file'],
            'video_url' => ['nullable', 'string', 'max:500', 'required_if:video_type,youtube,vimeo'],
            'video_file' => $uploadedImageRules,
            'thumb' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'is_published' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        unset($data['thumb'], $data['video_file']);

        return $data;
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->filled('slug') ? \Illuminate\Support\Str::slug($this->input('slug')) : null;
        $publishedAt = $this->input('published_at') ?: null;

        $this->merge([
            'slug' => $slug ?: null,
            'published_at' => $publishedAt,
            'video_url' => $this->filled('video_url') ? trim($this->input('video_url')) : null,
        ]);
    }
}
