<?php

if (!function_exists('media')) {
    function media($file)
    {
        return asset('media' . $file);
    }
}
