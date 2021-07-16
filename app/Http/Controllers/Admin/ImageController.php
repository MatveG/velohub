<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImagesUploadService;

class ImageController extends Controller
{
    protected static int $imgQuality = 70;
    protected static int $imgMaxSize = 1000;
    protected static string $imgFormat = 'jpg';
    protected static string $storageDisk = 'public';

    public function upload(Request $request, string $model, int $id): JsonResponse
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,gif,png|max:1048',
            'images.0' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $class = 'App\Models\\' . ucfirst($model);
        $model = (new $class())->findOrFail($id);

        $uploaded = ImagesUploadService::upload(
            $request->images,
            $model->imagesStorage(),
            $model->thumbsStorage()
        );

        $model->images = [...$model->images, ...$uploaded];
        $model->save();

        return response()->json($model->images);
    }

    public function update(Request $request, string $model, int $id): JsonResponse
    {
        $request->validate([
            'images.*' => 'string',
        ]);

        $class = 'App\Models\\' . ucfirst($model);
        $model = (new $class())->findOrFail($id);
        $images = $request->images ?? [];

        if (count($images)) {
            Storage::delete(array_diff($model->images, $images));
        }

        $model->images = $images;
        $model->save();

        return response()->json($model->images);
    }
}
