<?php

namespace App\Models\Traits;

trait Shop
{
    public static function shopCurrency()
    {
        return settings('shop', 'prices');
    }

    public static function shopPrice()
    {
        return settings('shop', 'default_price');
    }

    public static function currencyCode()
    {
        return self::shopCurrency()->{self::shopPrice()}->code;
    }

    public static function currencySign()
    {
        return self::shopCurrency()->{self::shopPrice()}->sign;
    }

    // ------------------------------

//    public function getPriceAttribute()
//    {
//        return $this->prices->{self::shopPrice()} ?? null;
//    }

    public function getThumbAttribute()
    {
        return (isset($this->images[0]))
            ? route('img.product', ['img' => str_replace('.jpg', '-md.jpg', $this->images[0])])
            : null;
    }

    public function getThumbsAttribute()
    {
        if(empty($this->images)) return null;

        return array_map(function ($item) {
            return route('img.product', ['img' => str_replace('.jpg', '-md.jpg', $item)]);
        }, $this->images);
    }

    public function getImageAttribute()
    {
        return (isset($this->images[0])) ? route('img.product', ['img' => $this->images[0]]) : null;
    }


}
