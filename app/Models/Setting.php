<?php

namespace App\Models;

use App\Models\Casts\OrderProducts;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Traits\Common;

    protected string $name = 'config';
    public $timestamps = false;
    protected $fillable = [];
    protected $casts = [
        'value' => OrderProducts::class
    ];
    protected $appends = [
        'value'
    ];

    public function getRawValueAttribute(): string
    {
        return $this->attributes['value'];
    }
}
