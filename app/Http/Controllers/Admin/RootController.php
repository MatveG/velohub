<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RootController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $ordersCount = Order::all()->count();
        $commentsCount = Comment::all()->count();
        $categoriesCount = Category::all()->count();
        $productsCount = Product::all()->count();

        $lastOrders = Order::orderBy('id', 'desc')->limit(10)->get();
        $lastComments = Comment::orderBy('id', 'desc')->limit(10)->get();

        return response()->json(compact([
            'commentsCount',
            'ordersCount',
            'categoriesCount',
            'productsCount',
            'lastOrders',
            'lastComments'
        ]));
    }
}
