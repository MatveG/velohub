<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variant;
use App\Services\Admin\ImagesUploader;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductObserver
{
    public function saving(Product $product)
    {
        //$this->clearUnusedFeatures($Product);

        if ($product->isDirty('brand') || $product->isDirty('model')) {
            $product->slug = latinize($product->brand . ' ' . $product->model);
        }

        if ($product->variants()->count()) {
//            $this->clearStockProperties($product);
            $this->syncVariantProperties($product);
            $this->syncVariantPrices($product);
        }
    }

    private function clearUnusedFeatures(Product $product)
    {
        if ($product->updated_at > Carbon::now()->subHour()) {
            return;
        }

        $productFeatures = $product->features;
        $categoryFeatures = $product->category->features;

        foreach ($productFeatures as $key => $feature) {
            if (empty($categoryFeatures->{$key})) {
                unset($productFeatures->{$key});
            }
        }
        $product->features = $productFeatures;
        $product->save();
    }

    private function clearStockProperties(Product $product)
    {
        $product->weight = null;
        $product->code = null;
        $product->barcode = null;
        $product->stocks = (object)[];
    }

    private function syncVariantProperties(Product $product, $update = [])
    {
        foreach (['category_id', 'is_active', 'is_sale'] as $value) {
            if($product->isDirty($value)) {
                $update[$value] = $product->{$value};
            }
        }

        if (count($update)) {
            Variant::where('product_id', $product->id)->update($update);
        }
    }

    private function syncVariantPrices(Product $product, $update = [])
    {
        if ($product->isDirty('price') || $product->isDirty('price_sale')) {
            $surcharge = $product->price - $product->price_sale;

            Variant::where('product_id', $product->id)->update([
                'price' => DB::raw("{$product->price} + surcharge - is_sale::int * {$surcharge}")
            ]);
        }
    }
}
