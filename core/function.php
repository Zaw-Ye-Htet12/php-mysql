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

function redirect(string $url,string $message = null){
    if(!is_null($message)){
        setSession($message);
    }
    return header("Location: " . $url);
}

function redirectBack(string $message = null):void{
    redirect($_SERVER['HTTP_REFERER'],$message);
}

function checkRequestMethod(string $methodName){
    $methodName = strtoupper($methodName);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $result = false;
    if($methodName === "POST" && $requestMethod === "POST" ){
        $result = true;
    }elseif($methodName === "PUT" && ($requestMethod === "PUT" || $requestMethod === "POST" && !empty($_POST['_method']) && strtoupper($_POST['_method']) === "PUT" )){
        $result = true;
    }elseif($methodName === "DELETE" && ($requestMethod === "DELETE" || $requestMethod === "POST" && !empty($_POST['_method']) && strtoupper($_POST['_method']) === "DELETE")){
        $result = true;
    }
    return $result;
}


function run(string $sql,bool $closeConnection = false):object|bool{
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


function all(string $sql): array {
    $query = run($sql, false);
    $lists = array();

    if (mysqli_num_rows($query) == 0) {
        return array ();
    } else {
        while ($row = mysqli_fetch_assoc($query)) {
            $lists[] = $row;
        }
    }

    return $lists;
}


function first(string $sql):array{
    $query = mysqli_query($GLOBALS['conn'],$sql);
    $list = mysqli_fetch_assoc($query);

    return $list;
}

function alert(string $message,string $color = "success") : string{
    return "<div class='alert alert-$color'>$message</div>";
}

function logger(string $message,int $colorCode = 32):void{
    echo "\e[39m[LOG]" . "\e[{$colorCode}m" . $message . " \n" ;
}

function responseJson(mixed $data, int $status = 200): string
{
    header("Content-type:Application/json");
    http_response_code($status);
    if (is_array($data)) {
        return print(json_encode($data));
    }
    return print(json_encode(["message" => $data]));
}

function filter($str,bool $strip = false){
    if($strip){
        $str = strip_tags($str);
    }
    $str = htmlentities($str,ENT_QUOTES);
    $str = stripslashes($str);
    return $str;
}


// session function start

function setSession(string $message,string $key = 'message'){
    $_SESSION[$key] = $message;
}

function showSession(string $key = 'message'):string{
    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $message;
}

function hasSession(string $key = 'message'):bool{
    if(!empty($_SESSION[$key])){
        return true;
    }else{
        return false;
    }
}

// session function end

// validation function start


// validation function end

function validationEnd(){
    if(hasSession('error')){
        redirectBack();
    }
}



// pagination function start
 
function pagination($sql,$limit = 10){
    $total = first(str_replace("*","count(*) as total",$sql))['total'];
    
    $totalPage = ceil($total / $limit);
    
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
    $offset = ($currentPage - 1 ) * 10 ;
    
    $sql .= " LIMIT $offset,$limit";

    $links = [];

    for ($i=1; $i <= $totalPage; $i++) { 

        $queries = $_GET;
        $queries['page'] = $i;
      
        $links[] = [
            "url" => url() . $GLOBALS['path']. "?" . http_build_query($queries),
            "is_active" => $currentPage == $i ? "active" : "",
            "page_number" => $i
        ] ;        
    }

    $lists = [
        "links" => $links,
        "total" => $total,
        "limit" => $limit,
        "totalPage" => $totalPage,
        "currentPage" => $currentPage,
        "data" => all($sql),        
    ];

    return  $lists;
}

// pagination function end

// paginator function start

function paginator($lists) {
    $paginationHtml = "<div class='d-flex justify-content-between'>
        <p>Total : " . $lists['total'] . "</p>
        <nav aria-label='Page navigation example'>
            <ul class='pagination'>";

    foreach ($lists['links'] as $link) {
        $activeClass = $link['is_active'] ? 'active' : '';
        $paginationHtml .= "<li class='page-item'><a class='page-link " . $activeClass . "' href='" . $link['url'] . "'>" . $link['page_number'] . "</a></li>";
    }

    $paginationHtml .= "</ul>
        </nav>
    </div>";

    return $paginationHtml;
}

// paginatior function end

// migration function start

function createTable(string $tableName,...$columName):void{
    $sql = "DROP TABLE IF EXISTS `$tableName`";
    run($sql);
    logger($tableName . " table was dropped sucessfully");

    $sql = "CREATE TABLE `$tableName` (
    `id` int NOT NULL,
    ".join(",",$columName).",
    `updated_at` timestamp NULL DEFAULT current_timestamp(),
    `created_at` timestamp NULL DEFAULT current_timestamp(),
    PRIMARY KEY(`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;";

    run($sql);
    logger($tableName . " table was created sucessfully");
}

// migration function end
