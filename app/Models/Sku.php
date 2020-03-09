<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use Traits\General;
    use Traits\Shop;
    use Traits\Relations\BelongsTo\Product;
    use Traits\Relations\BelongsTo\Category;

    protected $name = 'sku';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'barcode',
        'options',
        'stocks',
        'prices',
        'codes',
        'is_active',
    ];
    protected $casts = [
        'codes' => 'array',
        'options' => 'object',
        'stocks' => 'object',
        'prices' => 'object',
        'images' => 'array',
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_barcode')->withPivot('amount');
    }

}
