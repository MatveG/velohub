<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use App\Services\MetaService;
use Illuminate\Support\Facades\Artisan;

class RootController extends Controller
{
    public function __invoke()
    {
//        dd(Artisan::call('parse:veloplaneta'));

        $prod = Product::whereId(999)->with('category.features')->first();

        $prod->update(['category_id' => 1]);
        $prod = $prod->fresh()->with('category.features')->first(['id', 'category_id']);

        dd( $prod->toArray() );

        dd( $prod->only([
            ...($prod->wasChanged('category_id') ? ['category'] : []),
            ...array_keys($prod->getChanges())
        ]));

        $document = Document::where('slug', 'root')->firstOrFail();

        $meta = MetaService::title($document->meta_title ?? $document->title)
            ->description($document->meta_description)
            ->keywords($document->meta_keywords);

        $saleProducts = Product::where('is_active', true)
            ->where('is_stock', true)
            ->where('is_sale', true)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->where('is_stock', true)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        return view('root', compact(['document', 'meta', 'saleProducts', 'newProducts']));
    }
}
