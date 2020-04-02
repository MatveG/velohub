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
        'product_id',
        'category_id',
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
        'images' => 'array',
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_barcode')->withPivot('amount');
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($this->attributes['options']);
    }

    public function getStocksAttribute($value)
    {
        return json_decode($this->attributes['stocks']);
    }

    public function getPricesAttribute($value)
    {
        return json_decode($this->attributes['prices']);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode((object)($value));
    }

    public function setStocksAttribute($value)
    {
        $this->attributes['stocks'] = json_encode((object)($value));
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = json_encode((object)($value));
    }

}
