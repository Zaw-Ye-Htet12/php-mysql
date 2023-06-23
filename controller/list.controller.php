<?php 

function index(){
    $sql = "SELECT * from levels";
    if(isset($_GET['q'])){
        $q = $_GET['q'];
        $sql .= " WHERE name LIKE '%$q%'";
    }
    return view("list/list",['lists' => all($sql)]);
}

function create(){
   return view("list/create");
}

function store(){
    
    $name = $_POST['name'];
        $sql = "INSERT INTO levels (name,created_at) values ('$name',NOW());";
        run($sql);   
        redirect(route("list"));
    
}

function delete(){
    $id = $_POST['id'];
    $sql = "DELETE FROM levels WHERE id = {$id}";
    run($sql);  
    redirect(route("list"));
}

function update(){
    $id = $_GET['id'];
    $sql = "SELECT * from levels where id = {$id}";
    return view("list/update",['list' => first($sql)]);
    
}

function edit(){
    $name = $_POST['name'];
    $id = $_POST['id'];
    $sql = "UPDATE levels SET name = '$name' where id = $id";
    run($sql);  
    redirect(route("list"));
}