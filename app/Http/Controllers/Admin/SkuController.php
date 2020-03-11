<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SkuController extends Controller
{
    public function index(Product $product, $product_id)
    {
        //$this->checkAjaxRequiredFields($request, ['product_id']);

        $product = $product->findOrFail($product_id);
        $skus = $product->skus()->orderBy('is_default', 'desc')->orderBy('id')->get();
        $options = $product->category->pluck('options')->first();

        return response()->json([
            'items' => $skus,
            'cols' => [
                'options' => $options,
                'prices' => settings('shop', 'prices'),
                'stocks' => settings('shop', 'stocks'),
            ]
        ]);
    }

    public function store(Request $request, Sku $sku)
    {
        $sku->category_id = 0; // remove
        $sku->fill($request->all())->save();

        return response()->json([
            'id' => $sku->id,
        ]);
    }

    public function update(Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        $sku->update(request()->all());

//        $product = Product::findOrFail($sku->product_id);
//        $result = Sku::fromRaw('skus, json_each_text(stocks)')->where('product_id', $sku->product_id)->whereRaw('value <> \'0\'')->first();
//        $product->is_stock = ($result) ? 0 : 1;
//
//        if ($sku->is_default) {
//            $product->prices = $data['prices'];
//        }
//        $product->save();

        return response()->json();
    }

    public function destroy(Sku $sku, $id)
    {
        // do not delete default!
        $sku = $sku->findOrFail($id);

        if(!$sku->is_default) {
            $sku->delete();
        }

        return response()->json();
    }

    public function setDefault(Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        Sku::where('product_id', $sku->product_id)->update(['is_default' => false]);
        $sku->is_default = true;
        $sku->save();

        return response()->json();
    }

    public function deleteImage(Sku $sku, $id, $key)
    {
        $sku = $sku->findOrFail($id);
        $images = $sku->images;

        if(File::exists(public_path($images[$key]))) {
            File::delete(public_path($images[$key]));
        }
        unset($images[$key]);
        $sku->images = array_values($images);
        $sku->save();

        return response()->json();
    }

    public function uploadImage(Request $request, Sku $sku, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048',
        ]);

        $sku = $sku->findOrFail($id);
        $upload = $request->file('image');

        // create directories
        $numHash = base_convert( md5_file($upload), 16, 10 );
        $hashPath = chunk_split( substr($numHash, 0, 10), 2, '/' );
        $path = '/media/QQ/' . $hashPath . $id;
        $pathLg = $path . '-lg/';
        $pathMd = $path . '-md/';
        $pathSm = $path . '-sm/';

        if(!File::exists(public_path($pathLg))) {
            File::makeDirectory(public_path($pathLg), 0775, true);
            File::makeDirectory(public_path($pathMd), 0775, true);
            File::makeDirectory(public_path($pathSm), 0775, true);
        }

        // create image
        $extension = $upload->getClientOriginalExtension();
        $image = Image::make($request->file('image'));
        $name = $sku->product->latin . '.' . $extension;

        // save images
        $image->fit(1000)->save(public_path($pathLg . $name), 70);
        $image->fit(500)->save(public_path($pathMd . $name), 70);
        $image->fit(200)->save(public_path($pathSm . $name), 70);

        // add to Sku images array
        $images = $sku->images ?: [];
        if(!in_array($pathLg . $name, $images)) {
            $images[] = $pathLg . $name;
            $sku->images = array_values($images);
            $sku->save();
        }

        return response()->json(['image' => $pathLg . $name]);
    }

}
