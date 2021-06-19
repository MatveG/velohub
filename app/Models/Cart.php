<?php

namespace App\Models;

use App\Models\Casts\OrderProducts;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected string $modelName = 'cart';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [];
    protected $casts = [
        'products' => OrderProducts::class
    ];
}
