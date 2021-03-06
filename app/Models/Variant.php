<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use Traits\Common;
    use Traits\Shop;
    use Traits\Relations\BelongsTo\Product;
    use Traits\Relations\BelongsTo\Category;

    protected $name = 'variant';
    protected $imagesFolder = '/media/variant';
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'category_id',
        'is_active',
        'is_sale',
        'price',
        'surcharge',
        'stock',
        'weight',
        'code',
        'barcode',
        'parameters',
        'images'

    ];
    protected $casts = [
        'codes' => 'array',
        'images' => 'array',
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_barcode')->withPivot('amount');
    }

    public function getParametersAttribute($value)
    {
        return json_decode($this->attributes['parameters']);
    }

    public function getStocksAttribute($value)
    {
        return json_decode($this->attributes['stocks']);
    }

    public function getPricesAttribute($value)
    {
        return json_decode($this->attributes['prices']);
    }

    public function setParametersAttribute($value)
    {
        $this->attributes['parameters'] = json_encode((object)($value));
    }

    public function setStocksAttribute($value)
    {
        $this->attributes['stocks'] = json_encode((object)($value));
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = json_encode((object)($value));
    }

    public function getImagesNameAttribute()
    {
        $format = '%s-%s.%d.%s';

        return sprintf(
            $format,
            $this->product->latin,
            latinize( implode( array_values((array)$this->parameters), '-' ) ),
            $this->id,
            settings('category', 'images_format')
        );
    }

}
