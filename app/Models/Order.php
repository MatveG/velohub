<?php

namespace App\Models;

use App\Models\Casts\OrderProducts;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Traits\Common;
    use Traits\Relations\BelongsTo\User;

    protected string $name = 'order';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'status',
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
        'created_at' => 'datetime:d-m-y, H:i',
        'address' => 'object',
        'products' => OrderProducts::class
    ];
    protected $appends = [
        'client'
    ];

    public function getClientAttribute(): string
    {
        return trim($this->attributes['name'] . ' ' . $this->attributes['surname']);
    }
}
