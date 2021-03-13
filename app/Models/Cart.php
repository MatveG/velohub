<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Traits\Common;

    protected $name = 'cart';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'products'
    ];

    public function getProductsAttribute()
    {
        return json_decode($this->attributes['products'], true);
    }

    public function setProductsAttribute($value)
    {
        $this->attributes['products'] = json_encode((array)($value));
    }
}
