<?php

if (! function_exists('d')) {
    
    function d(...$params)
    {
        array_map(function($param) {
            dump($param);
        }, $params);
    }
}
