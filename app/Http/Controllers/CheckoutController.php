<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
