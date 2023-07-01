<?php 

function index(){
    $sql = "SELECT * from users";
    if(isset($_GET['q'])){
        $q = $_GET['q'];
        $sql .= " WHERE name LIKE '%$q%'";
    }
    return responseJson(pagination($sql));  
}

function store(){   
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    run("INSERT INTO users (name,email,gender,address) values ('$name','$email','$gender','$address');"); 
    
    $currentUser = first("SELECT * FROM `users` WHERE id = {$GLOBALS["conn"]->insert_id}");
    return responseJson($currentUser);

}

function delete(){
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = {$id}";
    run($sql); 
    return responseJson("User id $id is deleted!");
}

function show(){
    $id = $_GET['id'];
    $sql = "SELECT * from users where id = {$id}";
    
    return responseJson(first($sql));
}

function edit(){
    parse_str(file_get_contents("php://input"),$_PUT);
    $name = $_PUT['name'];
    $email = $_PUT['email'];
    $gender = $_PUT['gender'];
    $address = $_PUT['address'];
    $id = $_GET['id'];
    $sql = "UPDATE users SET name = '$name',email = '$email',gender = '$gender',address = '$address' where id = $id";
    run($sql);  
    return responseJson(first("SELECT * FROM users WHERE id = $id"));
}