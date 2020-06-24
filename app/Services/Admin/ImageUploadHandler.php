<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageUploadHandler
{
    public static function uploadArray($imagesArray, $settings)
    {
        $resultArray = [];

        foreach ($imagesArray as $image) {
            $resultArray[] = self::uploadImage($image, $settings);
        }

        return $resultArray;
    }

    public static function uploadImage($file, $settings)
    {
        $imageName = $settings->filename . '.' . $file->getClientOriginalExtension();
        $paths = self::createPath($file, $settings);

        self::createDirectory($paths['lg']);
        self::createDirectory($paths['md']);
        self::createDirectory($paths['sm']);

        $image = Image::make($file);
        $image->fit(1000)->save(public_path($paths['lg'] . $imageName), 70);
        $image->fit(500)->save(public_path($paths['md'] . $imageName), 70);
        $image->fit(200)->save(public_path($paths['sm'] . $imageName), 70);

        return $paths['lg'] . $imageName;
    }

    public static function deleteImages(array $imagesArray)
    {
        if (!count($imagesArray)) {
            return false;
        }

        foreach ($imagesArray as $image) {
            if(File::exists(public_path($image))) {
                File::delete(public_path($image));
            }
        }

        return true;
    }

    protected static function createPath($file, $settings)
    {
        $numHash = base_convert(md5_file($file), 16, 10);
        $hashPath = '/' . chunk_split(substr($numHash, 0, 10), 2, '/');
        $path = $settings->folder . $hashPath . $settings->uid;

        return [
            'lg' => $path . '/lg/',
            'md' => $path . '/md/',
            'sm' => $path . '/sm/',
        ];
    }

    protected static function createDirectory($path)
    {
        if(!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
        }
    }

}
