<?php

namespace App\Models\Traits;

trait Images
{
    public function getImagesFolderAttribute(): string
    {
        return $this->imagesFolder;
    }

    public function getImagesNameAttribute(): string
    {
        $format = '%s.%d.%s';

        return sprintf($format, $this->slug, $this->id, settings('shop.images_format'));
    }

    public function getThumbAttribute(): ?string
    {
        return (count($this->images)) ? $this->images[0] : null;

//        return (count($this->images))
//            ? route('img.product', ['img' => str_replace('.jpg', '-md.jpg', $this->images[0])])
//            : null;
    }

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

    public function getImageAttribute(): ?string
    {
        return (count($this->images)) ? $this->images[0] : null;
//        return (isset($this->images[0])) ? route('img.product', ['img' => $this->images[0]]) : null;
    }


}
