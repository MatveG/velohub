<?php

namespace App\Widgets;

class Widget
{
    protected $widgets;

    public function __construct() {
        $widgets = config('widgets');

        foreach ($widgets as $key => $widget) {
            $this->widgets[$key] = \App::make($widgets[$key]);
        }
    }

    public function show($name, $data = null) {
        if(isset($this->widgets[$name])) {
            return $this->widgets[$name]->execute($data);
        }
    }
}
