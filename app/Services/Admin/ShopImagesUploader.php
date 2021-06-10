<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ShopImagesUploader
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

    public static function uploadImage(
        UploadedFile $imageFile,
        string $folderName,
        string $fileName,
        int $imgSize = 1000,
        int $imgQuality = 70
    ): ?string {
        $folderPath = "$folderName/" . self::fileHashPath($imageFile);
        $filePath = $folderPath .  $fileName . $imageFile->extension();
        $fullFolderPath = public_path($folderPath);
        $fullFilePath = public_path($filePath);

        if (File::exists($fullFilePath)) {
            File::delete($fullFilePath);
        }

        if (!File::exists($fullFolderPath)) {
            File::makeDirectory($fullFolderPath, 0775, true);
        }

        Image::make($imageFile)
            ->resize($imgSize, null, fn ($constraint) => $constraint->aspectRatio())
            ->save($fullFilePath, $imgQuality);

        return $filePath;
    }

//    public static function renameImage(string $filePath, string $fileName): string
//    {
//        $newFilePath = File::dirname($filePath) . '/' . $fileName;
//        File::move(public_path($filePath), public_path($newFilePath));
//
//        return $newFilePath;
//    }

    protected static function fileHashPath($file): string
    {
        return chunk_split(substr(md5_file($file), 0, 14), 2, '/');
    }
}
