<?php

namespace App\Models;

use App\Models\Casts\OrderProducts;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Traits\Common;

    protected string $modelName = 'config';
    public $timestamps = false;
    protected $fillable = [];
    protected $casts = [];
    protected $appends = [];

    public function getRawValueAttribute(): string
    {
        return  ? json_decode($this->attributes['value']) : $this->attributes['value'];
    }
}
