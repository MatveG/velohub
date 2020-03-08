<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use Traits\General;

    protected $name = 'coupon';
    protected $dates = ['created_at', 'updated_at'];
}
