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
