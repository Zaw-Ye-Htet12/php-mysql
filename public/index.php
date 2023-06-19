<?php 

require_once ("../index.php");


switch ($_SERVER['REQUEST_URI']) {
    case '/':
        return view("home",["name"=>"tharlay"]);
        break;
        
        case '/about':
            return view("about");
            break;

            case '/list':
                controller("list@index");
                break;
    
    default:
        echo  "<h1>Not Found</h1>";
        break;
}