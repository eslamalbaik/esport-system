<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['key', 'group', 'type', 'value'];

    protected $casts = ['value' => 'array'];

    public $translatable = ['value'];

    public function isText(): bool
    {
        return $this->type === 'text';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function imageFilename(): ?string
    {
        if (! ($this->isImage() || $this->isVideo())) {
            return null;
        }

        $value = $this->value;
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            return $value['path'] ?? null;
        }
        return null;
    }
}
