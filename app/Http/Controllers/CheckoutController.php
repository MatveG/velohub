<?php

namespace App\Http\Controllers;

use App\Services\MetaService;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        $meta = MetaService::title('Оформление заказа');

        return view('checkout', compact(['meta']));
    }
}
