<?php

namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ModelImages
{
    public static function upload(Model $model, $file)
    {
        $imageName = $model->latin . '.' . $file->getClientOriginalExtension();
        $paths = self::generatePaths($model, $file);

        self::makeDirectory($paths['lg']);
        self::makeDirectory($paths['md']);
        self::makeDirectory($paths['sm']);

        $image = Image::make($file);
        $image->fit(1000)->save(public_path($paths['lg'] . $imageName), 70);
        $image->fit(500)->save(public_path($paths['md'] . $imageName), 70);
        $image->fit(200)->save(public_path($paths['sm'] . $imageName), 70);

        return $paths['lg'] . $imageName;
    }

    public static function delete(array $imagesArray)
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

    protected static function generatePaths($model, $file)
    {
        $numHash = base_convert(md5_file($file), 16, 10);
        $hashPath = '/' . chunk_split(substr($numHash, 0, 10), 2, '/');
        $path = $model->getImagesFolder() . $hashPath . $model->id;

        return [
            'lg' => $path . '/lg/',
            'md' => $path . '/md/',
            'sm' => $path . '/sm/',
        ];
    }

    protected static function makeDirectory($path)
    {
        if(!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0775, true);
        }
    }

}
