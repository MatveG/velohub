<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use Traits\Common;

    protected string $name = 'content';
    protected $dates = ['created_at', 'updated_at'];
}
