<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected string $modelName = 'cart';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [];
    protected $casts = [
        'products' => 'array',
    ];

    public function setProductsAttribute($value)
    {
        $this->attributes['products'] = json_encode(array_values($value));
    }
}
