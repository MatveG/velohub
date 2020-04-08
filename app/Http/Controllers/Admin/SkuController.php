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
            'cols' => [
                'options' => $product->category->pluck('options')->first(),
                'prices' => settings('shop', 'prices'),
                'stocks' => settings('shop', 'stocks'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $hasDuplicates = Sku::where(function ($query) use ($request) {
            foreach ($request->codes as $code) {
                $query->orwhereJsonContains('codes', $code);
            }
        })->exists();

        if($hasDuplicates) {
            return response()->json(['error' => 'Code already exists'], 400);
        }

        $sku = new Sku();
        $sku->fill($request->all());
        $sku->category_id = $product->category_id;

        if($product->skus->count() === 0) {
            $sku->is_default = true;
        }
        $sku->save();

        $this->updateProductStock($product);

        return response()->json([
            'id' => $sku->id,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sku = Sku::findOrFail($id);

        $hasDuplicates = Sku::where('id', '!=', $id)->where(function ($query) use ($request) {
            foreach ($request->codes as $code) {
                $query->orwhereJsonContains('codes', $code);
            }
        })->exists();

        if($hasDuplicates) {
            return response()->json(['error' => 'Code already exists'], 400);
        }

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

    public function imagesUpload(Request $request, Sku $sku, $id)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:1048',
        ]);

        $sku = $sku->findOrFail($id);
        $upload = $request->file('image');

        // create path //
        $numHash = base_convert( md5_file($upload), 16, 10 );
        $hashPath = chunk_split( substr($numHash, 0, 10), 2, '/' );
        $path = '/media/st/' . $hashPath . $id;
        $pathLg = $path . '-lg/';
        $pathMd = $path . '-md/';
        $pathSm = $path . '-sm/';

        // create image
        $extension = $upload->getClientOriginalExtension();
        $image = Image::make($request->file('image'));
        $name = $sku->product->latin . '.' . $extension;

        if(!empty($sku->images) && in_array($pathLg . $name, $sku->images, true)) {
            return response()->json(['error' => 'Image already exists'], 400);
        }

        // create directories and save images
        if(!File::exists(public_path($pathLg))) {
            File::makeDirectory(public_path($pathLg), 0775, true);
            File::makeDirectory(public_path($pathMd), 0775, true);
            File::makeDirectory(public_path($pathSm), 0775, true);
        }
        $image->fit(1000)->save(public_path($pathLg . $name), 70);
        $image->fit(500)->save(public_path($pathMd . $name), 70);
        $image->fit(200)->save(public_path($pathSm . $name), 70);

        // save new images array
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

    private function updateProductStock(Product $product)
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
