<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use Traits\General;

    protected $name = 'banner';
    protected $dates = ['created_at', 'updated_at'];
}
