<?php

$request_path = $_GET['route'];

if(isset($_GET['category'])){
$ctt = $_GET['category'];
}


if($request_path && $request_path[-1] == '/'){
    $request_path = substr($request_path, 0, strlen($request_path) - 1);//Удаляем слэш, если он есть
}

if($request_path == 'cat'){
    require $base_path . '/cat.php';
}

if($request_path == '' || $request_path == 'main'){
    require $base_path . '/main.php';
}

if($request_path == 'add'){
    require $base_path . '/add.php';
}

if($request_path == 'img_add'){
    require $base_path . '/img_add.php';
}

if($request_path == 'add_comment'){
    require $base_path . '/add_comment.php';
}