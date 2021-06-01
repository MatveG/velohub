<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Traits\Common;

    protected string $name = 'config';
    public $timestamps = false;
    protected $fillable = [];
    protected $casts = [];
    protected $appends = [
        'value'
    ];

    public function getValueAttribute()
    {
        return $this->attributes['value'][0] === '{' ?
            json_decode($this->attributes['value']) :
            $this->attributes['value'];
    }
}
