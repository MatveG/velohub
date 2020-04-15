<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use Traits\Common;

    protected $name = 'widget';
    public $timestamps = false;
}
