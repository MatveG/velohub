<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected string $modelName = 'config';
    public $timestamps = false;
    protected $fillable = [];
    protected $casts = [];
    protected $appends = [];

    public function getValueAttribute()
    {
        $decoded = json_decode($this->attributes['value'], JSON_OBJECT_AS_ARRAY);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $this->attributes['value'];
    }
}
