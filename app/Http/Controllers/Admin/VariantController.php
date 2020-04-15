<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class VariantController extends Controller
{
    public function index(Product $product, $product_id)
    {
        $product = $product->findOrFail($product_id);

        return response()->json([
            'items' => $product->variants()->orderBy('id')->get(),
            'parameters' => $product->category->pluck('parameters')->first(),
        ]);
    }

    public function store(Request $request)
    {
        if(Variant::where('code', '=', $request->code)->exists()) {
            return response()->json(['error' => 'This Code already exists'], 400);
        }
        $variant = new Variant();
        $variant->fill($request->all());
        $variant->save();
        $this->syncProducts($variant->product_id);

        return response()->json(['variant' => $variant]);
    }

    public function update(Request $request, $id)
    {
        if(isset($request->code) && Variant::where('id', '!=', $id)->where('code', '=', $request->code)->exists()) {
            return response()->json(['error' => 'Code already exists'], 400);
        }
        $variant = Variant::findOrFail($id);
        $variant->update($request->all());
        $this->syncProducts($variant->product_id);

        return response()->json();
    }

    public function destroy(Variant $variant, $id)
    {
        $variant = $variant->findOrFail($id);
        $product_id = $variant->product_id;
        $variant->delete();

        $this->syncProducts($product_id);

        return response()->json();
    }

    protected function syncProducts(int $productId)
    {
        $product = Product::find($productId);
        $product->is_stock = Variant::where('product_id', $productId)->where('stock', '>', 0)->exists();
        $product->save();
    }






    public function imagesUpload(Request $request, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $variant = Variant::findOrFail($id);

//        if(!empty($sku->images) && in_array($pathLg . $fullName, $product->images, true)) {
//            return response()->json(['error' => 'Image already exists'], 400);
//        }

        $newImagePath = $this->upload(
            '/media/su/',
            $request->file('image'),
            $variant->id,
            $variant->product->latin
        );

        $images = $variant->images ?: [];
        if(!in_array($newImagePath, $images)) {
            $images[] = $newImagePath;
            $variant->images = array_values($images);
            $variant->save();
        }

        return response()->json(['image' => $newImagePath]);
    }

    public function imagesUpdate(Request $request, $id)
    {
        $variant = Variant::findOrFail($id);
        $variant->images = $request->images;
        $variant->save();

        foreach ($variant->images as $image) {
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
