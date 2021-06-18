<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait Images
{
    private string $imagesDir = '/image/';
    private string $thumbsDir = '/thumb/';
    private string $refValue = '';
    private array $cacheValue = [];

    public function getImagesAttribute(): array
    {
        return array_map(fn ($url) => Storage::url($this->imagesStorage() . $url), $this->castValue());
    }

    public function getThumbsAttribute(): array
    {
        return array_map(fn ($url) => Storage::url($this->thumbsStorage() . $url), $this->castValue());
    }

    public function getImageAttribute(): ?string
    {
        return (count($this->castValue())) ? Storage::url($this->imagesStorage() . $this->castValue()[0]) : null;
    }

    public function getThumbAttribute(): ?string
    {
        return (count($this->castValue())) ? Storage::url($this->thumbsStorage() . $this->castValue()[0]) : null;
    }

    public function setImagesAttribute(array $value): void
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function imagesStorage(): string
    {
        return $this->modelName . $this->imagesDir;
    }

    public function thumbsStorage(): string
    {
        return $this->modelName . $this->thumbsDir;
    }

    private function castValue(): array
    {
        if ($this->attributes['images'] !== $this->refValue) {
            $this->cacheValue = json_decode($this->attributes['images'], true);
            $this->refValue = $this->attributes['images'];
        }

        return $this->cacheValue;
    }
}
