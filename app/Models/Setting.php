<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Traits\Common;

    protected $name = 'setting';
    protected $dates = [];
    protected $fillable = [];
    protected $casts = [];
}
