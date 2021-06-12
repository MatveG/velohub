<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class RootController extends Controller
{
    public function __invoke()
    {

        dd(Artisan::call('parse:veloplaneta'));
//        dd(Artisan::call('update:veloplaneta'));

//        $orders = Order::all();
//        return response()->json($orders);


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
