<?php

namespace App\Observers;

use App\Models\product;
use App\Models\Variant;
use App\Services\Admin\ShopImages;
use Illuminate\Support\Facades\DB;

class VariantObserver
{
    public function retrieved(Variant $variant) {
        // clear unused parameters
    }

    public function updating(Variant $variant)
    {
        if ($variant->isDirty('images')) {
            ShopImages::deleteImages(array_diff(
                json_decode($variant->getOriginal('images'), true),
                $variant->images
            ));
        }
    }

    //    protected function syncProducts(int $productId)
//    {
//        $product = product::find($productId);
//        $product->is_stock = Variant::where('product_id', $productId)->where('stock', '>', 0)->exists();
//        $product->save();
//    }

    // deleted:
    // delete all images
    // update product stocks

}

