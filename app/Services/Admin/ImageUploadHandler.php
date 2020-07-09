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
            $result = self::uploadImage($image, $settings);

            if ($result) {
                $resultArray[] = $result;
            }
        }

        return $resultArray;
    }

    public static function uploadImage($file, $settings)
    {
        $imageName = $settings->filename . '.' . $file->getClientOriginalExtension();
        $pathArray = self::createPath($file, $settings);
        $folderContent = File::files(public_path($pathArray['lg']));

        if (count($folderContent)) {
            return false;
        }

        self::createDirectory($pathArray['lg']);
        self::createDirectory($pathArray['md']);
        self::createDirectory($pathArray['sm']);

        $image = Image::make($file);
        $image->fit(1000)->save(public_path($pathArray['lg'] . $imageName), 70);
        $image->fit(500)->save(public_path($pathArray['md'] . $imageName), 70);
        $image->fit(200)->save(public_path($pathArray['sm'] . $imageName), 70);

        return $pathArray['lg'] . $imageName;
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
