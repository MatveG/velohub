<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImagesUploadService
{
    protected static int $imageSize = 700;
    protected static int $thumbSize = 200;
    protected static int $imgQuality = 80;
    protected static string $imgFormat = 'webp';

    public static function upload(array $imagesArr, string $imagesDir, string $thumbsDir): array
    {
        return array_filter(
            array_map(fn ($image) => self::storeWithThumb($image, $imagesDir, $thumbsDir), $imagesArr)
        );
    }

    private static function storeWithThumb($image, string $imagesDir, string $thumbsDir): ?string
    {
        $imageName = Str::orderedUuid() . '.' . self::$imgFormat;

        return Storage::put(
            $imagesDir . $imageName,
            self::makeImage($image, self::$imageSize, self::$imgFormat)
        ) && Storage::put(
            $thumbsDir . $imageName,
            self::makeImage($image, self::$thumbSize, self::$imgFormat)
        ) ? $imageName : null;
    }

    private static function makeImage($image, int $size, string $format): ?string
    {
        return Image::make($image)
            ->resize($size, $size, fn ($constraint) => $constraint->aspectRatio())
            ->encode($format);
    }
}
