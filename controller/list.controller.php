<?php 

function index(){
    $sql = "SELECT * from bbb";
    $query = mysqli_query($GLOBALS["conn"],$sql);
    return view("list/list");
}