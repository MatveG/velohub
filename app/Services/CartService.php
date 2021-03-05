<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    protected $cart;
    protected $items;

    public function __construct()
    {
        $this->cart = new Cart();
        if (empty($_COOKIE['cart'])) {
            return;
        }

        $cookie = json_decode(rawurldecode($_COOKIE['cart']));
        $this->cart = $cart->where('id', $cookie->id)->where('sign', $cookie->sign)->first();

        if (!$this->cart) {
            setcookie('cart', '', time() - 60, '/', null);
            return;
        }

        if($cookie->actual !== true) {
            $this->cart->variants()->detach();

            foreach ($cookie->items as $item) {
                $this->cart->variants()->attach($item->id, ['amount' => $item->q]);
                $this->cart->variants->push($item->id, ['amount' => $item->q]);
            }

            $cookie->actual = true;
            setcookie('cart', json_encode($cookie), time()+60*60*24*365, '/', null);
        }

        $this->items = $this->cart->variants()->get();
    }

    public function getItems()
    {
        if (!$this->items) {
            return null;
        }

        return $this->items->map(function ($item) {
            $item->amount = $item->pivot->amount;
            $item->sum = $item->price * $item->pivot->amount;
            return $item;
        });
    }

    public function getItemsJson()
    {
        if (!$this->items) {
            return null;
        }

        return $this->items->map(function ($item) {
            return [
                'code_id' => $item->id,
                'price' => $item->prices->{Product::shopPrice()},
                'amount' => $item->pivot->amount,
            ];
        })->toJson();
    }

    public function clearCart()
    {
        $this->cart->delete();
        setcookie('cart', '', time()-60, '/', null);
    }

}
