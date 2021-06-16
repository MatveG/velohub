<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Traits\Common;

    protected string $modelName = 'cart';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'products'
    ];
    protected $casts = [
        'products' => 'array',
    ];

    public function setProductsAttribute($value)
    {
        $this->attributes['products'] = json_encode(array_values($value));
    }
}
