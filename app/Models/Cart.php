<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Traits\General;

    protected $name = 'cart';
    public $timestamps = false;
    protected $fillable = [
        'sign',
    ];

    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'cart_sku')->withPivot('amount');
    }
}
