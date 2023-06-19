<?php 

function dd($data):void{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function url(string $path=null):string{
    $url = isset($_SERVER['HTTPS']) ? "https://" : "http://";
    $url .= $_SERVER['HTTP_HOST'];
    if(isset($path)){
        $url .= "/";
        $url .= $path;
    }
    return $url;
}

function view(string $file,array $data = null){
    if(!is_null($data)){
        foreach($data as $key => $value){
            ${$key} = $value;  
        }
    }
    require_once ViewDir."/".$file.".view.php";
}

function controller(string $controllerName){
    $controllerNameArray = explode("@",$controllerName);
    require_once ControllerDir."/{$controllerNameArray[0]}.controller.php";
    call_user_func($controllerNameArray[1]);
}