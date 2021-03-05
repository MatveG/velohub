<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Traits\Common;

    protected $name = 'cart';
    public $timestamps = false;
    protected $fillable = [
        'sign',
    ];

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'cart_variants')->withPivot('amount');
    }
}
