<?php

$base_path = __DIR__ . '/';
require_once $base_path . 'settings/helper.php';

function my_autoloader(string $class_name){
    global $base_path;
    require_once $base_path . $class_name . 'php';
}

spl_autoload_register('my_autoloader');

require_once $base_path . 'router.php';
