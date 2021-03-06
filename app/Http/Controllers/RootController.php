<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;

class RootController extends Controller
{
    public function index(Document $content, Product $product)
    {
        $content = $content->where('slug', 'index')->firstOrFail();

        $saleProducts = $product
            ->where('is_active', true)
            ->where('is_stock', true)
            ->where('is_sale', true)
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $newProducts = $product
            ->where('is_active', true)
            ->where('is_stock', true)
            ->orderBy('products.id', 'desc')
            ->limit(6)
            ->get();

        $meta = (object)[
            'title' => $content->seo_title,
            'description' => $content->seo_description,
            'keywords' => $content->seo_keywords,
        ];

        return view('root', compact(['content', 'saleProducts', 'newProducts', 'meta']));
    }

}
