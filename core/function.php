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

function route(string $path,array $queries = null):string{
    $url = url($path);
    if(!is_null($queries)){
        $url .= "?" . http_build_query($queries);
    }
    return $url;
}

function redirect(string $url){
    return header("Location: " . $url);
}

function checkRequestMethod(string $methodName){
    $methodName = strtoupper($methodName);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $result = false;
    if($methodName === "POST" && $requestMethod === "POST" ){
        $result = true;
    }elseif($methodName === "PUT" && $requestMethod === "POST" && !empty($_POST['_method']) && strtoupper($_POST['_method']) === "PUT" ){
        $result = true;
    }elseif($methodName === "DELETE" && $requestMethod === "POST" && !empty($_POST['_method']) && strtoupper($_POST['_method']) === "DELETE"){
        $result = true;
    }
    return $result;
}


function run(string $sql,bool $closeConnection = true):object|bool{
    try {
        $query = mysqli_query($GLOBALS["conn"],$sql);
        if($closeConnection){
            mysqli_close($GLOBALS['conn']);
        }
        return $query;
    } catch (Exception $e) {
        dd($e);
    }
}

function all(string $sql):array{
    $query = run($sql);
    
    while($row = mysqli_fetch_assoc($query)){
        $lists[] = $row;
    }
    return $lists;
}

function first(string $sql):array{
    $query = mysqli_query($GLOBALS['conn'],$sql);
    $list = mysqli_fetch_assoc($query);

    return $list;
}