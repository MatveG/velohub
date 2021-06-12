<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ModelImages
{
    protected static int $imgSize = 1000;
    protected static int $imgQuality = 70;

    public static function uploadImages(array $files, string $dirPrefix, string $fileName): array
    {
        $uploadArray = array_map(fn ($image) => self::uploadImage($image, $dirPrefix, $fileName), $files);

        return array_filter($uploadArray);
    }

    public static function uploadImage(UploadedFile $imageFile, string $dirPrefix, string $fileName): string
    {
        $dirPath = "$dirPrefix/" . chunk_split(substr(md5_file($imageFile), 0, 14), 2, '/');
        $filePath = $dirPath .  $fileName . '.' . $imageFile->extension();

        return self::createImage($imageFile, $filePath);
    }

    public static function copyByUrl(string $imageUrl, string $dirPrefix, string $fileName): string
    {
        $dirPath = "$dirPrefix/" . chunk_split(substr(md5(file_get_contents($imageUrl)), 0, 14), 2, '/');
        $filePath = $dirPath .  $fileName . '.' . strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));

        return self::createImage($imageUrl, $filePath);
    }

    protected static function createImage($image, string $filePath): string
    {
        $filePath = public_path($filePath);
        $dirPath = dirname($filePath);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        if (!File::exists($dirPath)) {
            File::makeDirectory($dirPath, 0775, true);
        }

        Image::make($image)
            ->resize(self::$imgSize, null, fn ($constraint) => $constraint->aspectRatio())
            ->save($filePath, self::$imgQuality);

        return $filePath;
    }

//    public static function uploadImage(
//        UploadedFile $imageFile,
//        string $folderName,
//        string $fileName,
//        int $imgSize = 1000,
//        int $imgQuality = 70
//    ): ?string {
//        $folderPath = "$folderName/" . self::fileHashPath($imageFile);
//        $filePath = $folderPath .  $fileName . $imageFile->extension();
//        $fullFolderPath = public_path($folderPath);
//        $fullFilePath = public_path($filePath);
//
//        if (File::exists($fullFilePath)) {
//            File::delete($fullFilePath);
//        }
//
//        if (!File::exists($fullFolderPath)) {
//            File::makeDirectory($fullFolderPath, 0775, true);
//        }
//
//        Image::make($imageFile)
//            ->resize($imgSize, null, fn ($constraint) => $constraint->aspectRatio())
//            ->save($fullFilePath, $imgQuality);
//
//        return $filePath;
//    }

    protected static function fileHashPath($file): string
    {
        return chunk_split(substr(md5_file($file), 0, 14), 2, '/');
    }
}

//    public static function renameImage(string $filePath, string $fileName): string
//    {
//        $newFilePath = File::dirname($filePath) . '/' . $fileName;
//        File::move(public_path($filePath), public_path($newFilePath));
//
//        return $newFilePath;
//    }
