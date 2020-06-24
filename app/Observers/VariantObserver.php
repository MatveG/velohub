<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Variant;
use App\Services\Admin\ImageUploadHandler;
use Illuminate\Support\Facades\DB;

class VariantObserver
{
    public function updating(Variant $variant)
    {
        if ($variant->isDirty('images')) {
            ImageUploadHandler::deleteImages(array_diff(
                json_decode($variant->getOriginal('images')),
                $variant->images
            ));
        }
    }

    //    protected function syncProducts(int $productId)
//    {
//        $product = Product::find($productId);
//        $product->is_stock = Variant::where('product_id', $productId)->where('stock', '>', 0)->exists();
//        $product->save();
//    }

    // deleted:
    // delete all images
    // update product stocks

}

