<?php 

function home(){
    return view("home",["name"=>"tharlay"]);;
}

function about(){
    return view("about");
}