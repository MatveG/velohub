<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected string $modelName = 'content';
    protected $dates = ['created_at', 'updated_at'];
}
