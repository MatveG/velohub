<?php

namespace App\Casts;

use Illuminate\Database\Eloquent\Model;

class Feature
{
    public $foo;
    public $bar;

    public function __construct($foo)
    {
        dd($foo);
        $this->foo = $foo;
//        $this->bar = $bar;
    }
}
