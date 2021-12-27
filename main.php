<?php

spl_autoload_register(function ($class) {
    $a = explode('\\', $class);
    $last = array_pop($a);
    $fn = $class . '/' . $last . '.php';
    $fn = str_replace('\\', '/', $fn);
    if (file_exists($fn)) require_once $fn; 
});

array_shift($argv);
$controller = new src\Controller();
$controller->main($argv);