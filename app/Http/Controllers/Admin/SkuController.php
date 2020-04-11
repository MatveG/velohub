<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sku;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SkuController extends Controller
{
    public function index(Product $product, $product_id)
    {
        $product = $product->findOrFail($product_id);

        return response()->json([
            'items' => $product->skus()->orderBy('id')->get(),
            'options' => $product->category->pluck('options')->first(),
        ]);
    }

    public function store(Request $request)
    {
        if(Sku::where('code', '=', $request->code)->exists()) {
            return response()->json(['error' => 'This Code already exists'], 400);
        }

        $sku = new Sku();
        $sku->fill($request->all());
        $sku->save();

        $this->updateProductStock($sku->product_id);

        return response()->json([
            'id' => $sku->id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sku = Sku::findOrFail($id);

        if(isset($request->code) && Sku::where('id', '!=', $sku->id)->where('code', '=', $request->code)->exists()) {
            return response()->json(['error' => 'Code already exists'], 400);
        }

        $sku->update($request->all());
        $this->updateProductStock($sku->product_id);

        return response()->json();
    }

    public function destroy(Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        $product_id = $sku->product_id;
        $sku->delete();

        $this->updateProductStock($product_id);

        return response()->json();
    }

    private function updateProductStock(int $productId)
    {
        $product = Product::find($productId);
        $product->is_stock = Sku::where('product_id', $productId)->where('stock', '>', 0)->exists();
        $product->save();
    }






    public function imagesUpload(Request $request, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $sku = Sku::findOrFail($id);

//        if(!empty($sku->images) && in_array($pathLg . $fullName, $product->images, true)) {
//            return response()->json(['error' => 'Image already exists'], 400);
//        }

        $newImagePath = $this->upload(
            '/media/su/',
            $request->file('image'),
            $sku->id,
            $sku->product->latin
        );

        $images = $sku->images ?: [];
        if(!in_array($newImagePath, $images)) {
            $images[] = $newImagePath;
            $sku->images = array_values($images);
            $sku->save();
        }

        return response()->json(['image' => $newImagePath]);
    }

    public function imagesUpdate(Request $request, $id)
    {
        $sku = Sku::findOrFail($id);
        $sku->images = $request->images;
        $sku->save();

        foreach ($sku->images as $image) {
            if(!in_array($image, $request->images)) {
                $this->delete($image);
            }
        }

        return response()->json();
    }





    public function upload($folder, $file, $id, $name)
    {
        // create path
        $numHash = base_convert( md5_file($file), 16, 10 );
        $hashPath = chunk_split( substr($numHash, 0, 10), 2, '/' );
        $path = $folder . $hashPath . $id;
        $pathLg = $path . '-lg/';
        $pathMd = $path . '-md/';
        $pathSm = $path . '-sm/';

        // create image
        $extension = $file->getClientOriginalExtension();
        $image = Image::make($file);
        $fullName = $name . '.' . $extension;

        // create directories and save images
        if(!File::exists(public_path($pathLg))) {
            File::makeDirectory(public_path($pathLg), 0775, true);
            File::makeDirectory(public_path($pathMd), 0775, true);
            File::makeDirectory(public_path($pathSm), 0775, true);
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
