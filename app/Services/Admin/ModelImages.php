<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

// upload
// delete
// rename

class ModelImages
{
    public static function uploadImages(array $filesArray, string $folderName, string $fileName): array
    {
        return array_filter(
            array_map(
                fn ($image) => self::uploadImage($image, $folderName, $fileName),
                $filesArray
            )
        );
    }

    public static function uploadImage($file, string $folderName, string $fileName): ?string
    {
        if (File::exists($file)) {
            return null;
        }

        $folderPath = self::getHashPath($file, $folderName);
        $fullPath = $folderPath . $fileName;

        if (File::exists(public_path($fullPath))) {
            return null;
        }

        self::createDirectory($folderPath);
        self::resizeAndSave($file, $fullPath);

        return $fullPath;
    }

    public static function renameImages(array $imagesArray, string $fileName): array
    {
        return array_map(static function ($image) use ($fileName) {
            $newFullPath = File::dirname($image) . '/' . $fileName;
            File::move(public_path($image), public_path($newFullPath));

            return $newFullPath;
        }, $imagesArray);
    }

    public static function deleteImages(array $imagesArray): void
    {
        foreach ($imagesArray as $image) {
            if (File::exists(public_path($image))) {
                File::delete(public_path($image));
            }
        }
    }

    protected static function getHashPath($file, string $folderName): string
    {
        return "$folderName/" . chunk_split(substr(md5_file($file), 0, 14), 2, '/');
    }

    protected static function createDirectory(string $path)
    {
        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
        }
    }

    protected static function resizeAndSave($file, string $fullPath, int $size = 1000, int $quality = 70): void
    {
        Image::make($file)->resize($size, null, static function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($fullPath), $quality);
    }

}
