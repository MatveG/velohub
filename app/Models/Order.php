<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Traits\Common;
    use Traits\Relations\BelongsTo\User;

    protected string $name = 'order';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'payment',
        'delivery',
        'email',
        'phone',
        'name',
        'surname',
        'text',
        'address',
    ];
    protected $casts = [
        'address' => 'object',
        'products' => 'object'
    ];
}
