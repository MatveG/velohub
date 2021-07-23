<?php

namespace App\Models;

use App\Models\Casts\JsonObject;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected string $modelName = 'config';
    public $timestamps = false;
    protected $fillable = [
        'value'
    ];
    protected $casts = [
        'value' => JsonObject::class
    ];
}
