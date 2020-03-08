<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Traits\General;
    use Traits\Relations\BelongsTo\User;

    protected $name = 'order';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'phone',
        'name',
        'address',
        'email',
        'comment',
    ];
    protected $casts = [
        'items' => 'array'
    ];

}
