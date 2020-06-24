<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;

class ProductObserver
{
    public function saving(Product $product)
    {
        if ($product->isDirty('title')) {
           $product->latin = latinize($product->title);
        }
        //$this->removeUnusedFeatures($product);
        $this->syncProductVariants($product);
    }

    public function removeUnusedFeatures(Product $product)
    {
        $features = $product->features;

        foreach ($features as $key => $feature) {
            if(empty($product->category->features->{$key})) {
                unset($features->{$key});
            }
        }
        $product->features = $features;
    }

    private function syncProductVariants(Product $product, $update = [])
    {
        foreach (['category_id', 'is_active', 'is_sale'] as $value) {
            if($product->isDirty($value)) {
                $update[$value] = $product->{$value};
            }
        }

        if (count($update)) {
            Variant::where('product_id', $product->id)->update($update);
        }

        if ($product->isDirty('price') || $product->isDirty('surcharge')) {
            $surcharge = $product->price - $product->surcharge;

            Variant::where('product_id', $product->id)->update([
                'price' => DB::raw("{$product->price} + surcharge - is_sale::int * {$surcharge}")
            ]);
        }
    }
}
