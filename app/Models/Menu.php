<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Traits\Common;

    protected $name = 'menu';
    public $timestamps = false;
}
