<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function save(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['ok' => 0, 'ans' => 'Error']);
        }

        $data = $request->only(['title', 'barcode', 'options', 'stocks', 'prices']);
        $data['codes'] = explode("\n", str_replace("\r", "", $request->codes));
        $data['is_stock'] = max($request->stocks);

        $sku = Sku::findOrFail($request->id);
        $sku->update($data);

        $product = Product::findOrFail($sku->product_id);
        $result = Sku::fromRaw('skus, json_each_text(stocks)')->where('product_id', $sku->product_id)->whereRaw('value <> \'0\'')->first();
        $product->is_stock = ($result) ? 0 : 1;

        if ($sku->is_default) {
            $product->prices = $data['prices'];
        }
        $product->save();

        return response()->json(['ok' => 1, 'ans' => 'Сохранено']);
    }

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
