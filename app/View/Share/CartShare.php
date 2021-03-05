<?php

namespace App\View\Share;

use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Support\Facades\View;

class CartShare
{
    public static function share()
    {
        View::share('cartItems', self::cart());
    }

    public static function cart()
    {
        $service = new CartService();
        return $service->getItems();
    }
}
