<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use App\Models\Sku;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SkuController extends Controller
{
    public function index(Product $product, $product_id)
    {
        //$this->checkAjaxRequiredFields($request, ['product_id']);

        $product = $product->findOrFail($product_id);
        $skus = $product->skus()->orderBy('id')->get();
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

    public function store(Request $request, Product $product, Sku $sku)
    {
        $product = $product->findOrFail($request->product_id);

        $sku->fill($request->all());
        $sku->category_id = $product->category_id;

        foreach (['options', 'prices', 'stocks'] as $item) {
            if (empty($sku->{$item})) {
                $sku->{$item} = (object)[];
            }
        }

        $sku->save();

        $this->updateProductStock($product);

        return response()->json([
            'id' => $sku->id,
        ]);
    }

    public function update(Request $request, Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        $sku->update($request->all());

        $this->updateProductStock($sku->product);

        if ($sku->is_default) {
            $sku->product->prices = $sku->prices;
            $sku->product->save();
        }

        return response()->json();
    }

    public function destroy(Sku $sku, $id)
    {
        // do not delete default!
        $sku = $sku->findOrFail($id);

        if(!$sku->is_default) {
            $sku->delete();
        }
        $this->updateProductStock($sku->product);

        return response()->json();
    }

    public function setDefault(Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        $sku->product->skus()->update(['is_default' => false]);
        $sku->is_default = true;
        $sku->save();

        $sku->product->prices = $sku->prices;
        $sku->product->save();

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

    public function updateImages(Request $request, Sku $sku, $id)
    {
        $sku->where('id', $id)->update($request->only(['images']));

        return response()->json();
    }

    public function updateProductStock(Product $product)
    {
        $result = Sku
            ::fromRaw('skus, jsonb_each_text(stocks)')
            ->where('product_id', $product->id)
            ->whereRaw('value <> \'0\'')
            ->first();
        $product->is_stock = ($result) ? 1 : 0;
        $product->save();
    }

}
