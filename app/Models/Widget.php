<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use Traits\Common;

    protected string $modelName = 'widget';
    public $timestamps = false;
}
