<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImagesUploader
{
    protected static int $imgQuality = 70;
    protected static int $imgMaxSize = 1000;
    protected static string $imgFormat = 'jpg';

    public static function upload(array $imagesArr, string $dirPath): array
    {
        return array_filter(
            array_map(fn ($image) => self::store($image, $dirPath), $imagesArr)
        );
    }

    private static function store($image, string $dirPath): ?string
    {
        $imgPath = $dirPath . Str::orderedUuid() . '.' . self::$imgFormat;
        $imgInstance = Image::make($image)
            ->resize(self::$imgMaxSize, self::$imgMaxSize, fn ($constraint) => $constraint->aspectRatio())
            ->encode(self::$imgFormat);

        return Storage::disk('public')->put($imgPath, $imgInstance) ? $imgPath : null;
    }
}
