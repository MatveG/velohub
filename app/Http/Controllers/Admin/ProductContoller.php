<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductContoller extends Controller
{
    // $table-> unsignedBigInteger ('company_id'); //if primary id BigIncrements
    // 'photo' => 'dimensions:max_width=4096,max_height=4096'
    // return redirect()->action('SomeController@method',['param' => $value]);
    public function index()
    {
        // category_title
        // price
        $products = Product::with('category')
            ->orderByDesc('id')
            ->get(['category_id', 'id', 'code', 'brand', 'model', 'is_active']);

        return response()->json($products->map(function ($product) {
            $product->price = $product->price;
            $product->category_title = $product->category->title;
            $product->category = [];

            return $product;
        }));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::with('category')->find($id);

        // clean unused features
        if (isset($product->features)) {
            $features = (array)$product->features;

            foreach ($features as $key => $feature) {
                if(empty($product->category->features->{$key})) {
                    unset($features->{$key});
                }
            }
        }
        $product->features = $features;
        $product->save();

        return response()->json([
            'item' => $product->toArray(),
            'variantsCount' => $product->variants->count(),
            'currency' => settings('shop', 'currency'),
        ]);
    }

    public function update(Request $request, Product $product, $id)
    {
        $product = $product->findOrFail($id);
        $product->fill($request->all());
        $product->latin = $this->stringToLatin($product->fullName);
        $product->save();

        $this->syncVariants($product);

        return response()->json( $product->only(array_keys($product->getChanges())) );
    }

    public function imagesUpload(Request $request, $id)
    {
        // check if already exists
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $product = Product::findOrFail($id);
        $newImage = $this->upload(
            '/media/pt/',
            $request->file('image'),
            $product->id,
            $product->latin
        );
        $product->images = array_merge($product->images, [$newImage]);
        $product->save();

        return response()->json($newImage);
    }

    public function imagesUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->images = $request->images;

        foreach (array_diff($product->images, $product->getDirty('images')) as $image) {
            $this->delete($image);
        }
        $product->save();

        return response()->json();
    }

    private function syncVariants(Product $product)
    {
        $update = [
            'category_id' => $product->category_id,
            'is_active' => $product->is_active,
        ];

        if(isset($product->getChanges()['is_sale'])) {
            $update['is_sale'] = $product->is_sale;
        }

        Variant::where('product_id', $product->id)->update($update);

        $surcharge = $product->price - $product->surcharge;
        Variant::where('product_id', $product->id)->update([
            'price' => DB::raw("{$product->price} + surcharge - is_sale::int * {$surcharge}")
        ]);
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
