<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait ProductImages
{
    public function getImagesStoragePathAttribute(): string
    {
        return $this->modelName . '/' . $this->category_id . '/';
    }

    public function getThumbAttribute(): ?string
    {
        return Storage::disk('public')->url($this->images[0]);
    }

    public function getImageAttribute(): ?string
    {
        return (count($this->images)) ? $this->images[0] : null;
    }

//    public function getImagesAttribute(): array
//    {
//        return array_map(fn ($image) => Storage::disk('public')->url($image), json_decode($this->attributes['images']));
//    }
//    public function getThumbsAttribute(): ?array
//    {
//        if (empty($this->images)) {
//            return null;
//        }
//
//        return array_map(function ($item) {
//            return route('img.product', ['img' => str_replace('.jpg', '-md.jpg', $item)]);
//        }, $this->images);
//    }
}
