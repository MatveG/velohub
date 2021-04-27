<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use SebastianBergmann\Environment\Console;

class RootController extends Controller
{
    public function __invoke()
    {
        Artisan::call('parse:veloplaneta');


        $document = Document::where('slug', 'root')->firstOrFail();

        $saleProducts = Product::where('is_active', true)
            ->where('is_stock', true)
            ->where('is_sale', true)
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->where('is_stock', true)
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $meta = (object)[
            'title' => $document->seo_title,
            'description' => $document->seo_description,
            'keywords' => $document->seo_keywords,
        ];

        return view('root', compact(['document', 'saleProducts', 'newProducts', 'meta']));
    }

}
