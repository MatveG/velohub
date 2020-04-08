<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductContoller extends Controller
{
    public function index()
    {
        $products = Product::with('category')->with('skus')->orderBy('id', 'desc')->paginate();
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'codes' => implode(PHP_EOL, $product->sku->codes),
                'brand' => $product->brand,
                'model' => $product->model,
                'category_name' => $product->category->name,
                'price' => number_format($product->price),
                'is_active' => $product->is_active,
                'is_stock' => $product->is_stock,
                'is_sale' => $product->is_sale,
                'thumb' => $product->thumb,
                'link' => $product->link,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json(['data' => $products]);
    }

//    public function store(Request $request, Product $product, $id)
//    {
//        $product = $product->findOrFail($id);
//        $product->update( $request->only($product->getFillable()) );
//
//        return response()->json();
//    }

    public function edit(Request $request, Product $product, $id)
    {
        $product = $product->with('category')->find($id)->toArray();

        return response()->json(['item' => $product]);
    }

    public function update(Request $request, Product $product, $id)
    {
        $product = $product->findOrFail($id);
        $category_id = $product->category_id;
        $product->update( $request->only($product->getFillable()) );

        if($product->category_id !== $category_id) {
            return response()->json(['category' => $product->category]);
        }

        return response()->json();
    }

//    public function destroy(Request $request)
//    {
//        $this->checkAjaxRequiredFields(['ids']);
//
//        Product::destroy($request->ids);
//
//        return response()->json();
//    }
    public function imagesUpload(Request $request, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::findOrFail($id);

        $newImagePath = $this->upload(
            $request->file('image'),
            $product->id,
            $product->latin
        );

        $images = $product->images ?: [];
        if(!in_array($newImagePath, $images)) {
            $images[] = $newImagePath;
            $product->images = array_values($images);
            $product->save();
        }

        return response()->json(['image' => $newImagePath]);
    }

    public function imagesUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->images = $request->images;
        $product->save();

        foreach ($product->images as $image) {
            if(!in_array($image, $request->images)) {
                $this->delete($image);
            }
        }

        return response()->json();
    }



    public function upload($file, $id, $name)
    {
        // create path
        $numHash = base_convert( md5_file($file), 16, 10 );
        $hashPath = chunk_split( substr($numHash, 0, 10), 2, '/' );
        $path = '/media/st/' . $hashPath . $id;
        $pathLg = $path . '-lg/';
        $pathMd = $path . '-md/';
        $pathSm = $path . '-sm/';

        // create image
        $extension = $file->getClientOriginalExtension();
        $image = Image::make($file);
        $fullName = $name . '.' . $extension;

//        if(!empty($product->images) && in_array($pathLg . $fullName, $product->images, true)) {
//            return response()->json(['error' => 'Image already exists'], 400);
//        }

        // create directories and save images
        if(!File::exists(public_path($pathLg))) {
            File::makeDirectory(public_path($pathLg), 0775, true);
            File::makeDirectory(public_path($pathMd), 0775, true);
            File::makeDirectory(public_path($pathSm), 0775, true);

            return 'Image already exists';
        }
        $image->fit(1000)->save(public_path($pathLg . $fullName), 70);
        $image->fit(500)->save(public_path($pathMd . $fullName), 70);
        $image->fit(200)->save(public_path($pathSm . $fullName), 70);

        return $pathLg . $fullName;
    }

    public function delete($filePath)
    {
        if(File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
    }
}
