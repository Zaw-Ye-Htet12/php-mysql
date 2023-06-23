<?php 

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri)['path'];

const Routes = [
    "/" => "page@home",
    "/about" => "page@about",
    "/list" => "list@index",
    "/list-create" => "list@create",
    "/list-store" => ['post','list@store'],
    "/list-delete" => ["delete","list@delete"],
    "/list-update" => "list@update",
    "/list-edit" => ["put","list@edit"]
];

if(array_key_exists($path,Routes) && is_array(Routes[$path]) && checkRequestMethod(Routes[$path][0])){
    controller(Routes[$path][1]);
}elseif(array_key_exists($path,Routes) && !is_array(Routes[$path])){
    controller(Routes[$path]);
    
}else{
    echo "<h1>Not Found</h1>";
}