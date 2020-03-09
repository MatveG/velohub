<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sku;

class SkuController extends Controller
{
    public function index(Sku $sku, $product_id)
    {
        //$this->checkAjaxRequiredFields($request, ['product_id']);

        $skus = $sku->where('product_id', $product_id)->orderBy('id')->get();
        $options = $skus->first()->category()->pluck('options')->first();

        return response()->json([
            'items' => $skus,
            'options' => $options,
            'prices' => settings('shop', 'prices'),
            'stocks' => settings('shop', 'stocks'),
        ]);
    }

    public function store(Product $product, Sku $sku, $product_id)
    {
        $product = $product->findOrFail($product_id);

        $sku->fill(request()->all());
        $sku->product_id = $product->id;
        $sku->category_id = $product->category_id;
        $sku->save();

        return response()->json([
            'id' => $sku->id,
        ]);
    }

    public function update(Sku $sku, $id)
    {
        $sku = $sku->findOrFail($id);
        $sku->update(request()->all());
        //$sku->save();
        $sku->update(['barcode' => json_encode(request()->all())]);

        return response()->json([]);
    }

//    public function save(Request $request)
//    {
//        if (empty($request->id)) {
//            return response()->json(['ok' => 0, 'ans' => 'Error']);
//        }
//
//        $data = $request->only(['title', 'barcode', 'options', 'stocks', 'prices']);
//        $data['codes'] = explode("\n", str_replace("\r", "", $request->codes));
//        $data['is_stock'] = max($request->stocks);
//
//        $sku = Sku::findOrFail($request->id);
//        $sku->update($data);
//
//        $product = Product::findOrFail($sku->product_id);
//        $result = Sku::fromRaw('skus, json_each_text(stocks)')->where('product_id', $sku->product_id)->whereRaw('value <> \'0\'')->first();
//        $product->is_stock = ($result) ? 0 : 1;
//
//        if ($sku->is_default) {
//            $product->prices = $data['prices'];
//        }
//        $product->save();
//
//        return response()->json(['ok' => 1, 'ans' => 'Сохранено']);
//    }

    public function delete(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['ok' => 0]);
        }

        Sku::findOrFail($request->id)->delete();

        return response()->json(['ok' => 1]);
    }

    public function setDefault(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['ok' => 0]);
        }

        $sku = Sku::findOrFail($request->id);
        Sku::where('product_id', $sku->product_id)->update(['is_default' => 0]);

        $sku->is_default = 1;
        $sku->save();

        return response()->json(['ok' => 1]);
    }

    public function setActive(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['ok' => 0]);
        }

        Sku::findOrFail($request->id)->update($request->only(['is_active']));

        return response()->json(['ok' => 1]);
    }
}
