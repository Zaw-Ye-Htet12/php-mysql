<?php 

function home(){
    return view("home",["name"=>"tharlay"]);;
}

function about(){
    return view("about");
}

function ss(){
    // session_unset();
    dd($_SESSION);
}