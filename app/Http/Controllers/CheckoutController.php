<?php

namespace App\Http\Controllers;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        $meta = (object)[
            'title' => 'Оформление заказа',
            'description' => '',
            'keywords' => '',
        ];

        return view('checkout', compact(['meta']));
    }
}
