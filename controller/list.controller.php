<?php 

function index(){
    $sql = "SELECT * from levels";
    if(isset($_GET['q'])){
        $q = filter($_GET['q']);
        $sql .= " WHERE name LIKE '%$q%'";
    }

    


    return view("list/list",['lists' => pagination($sql,10)]);
}

function create(){
   return view("list/create");
}

function store(){
        if (empty(trim($_POST['name']))) {
            setSession("Data is required",'error');
        } elseif (strlen($_POST['name']) < 3) {
            setSession("Data is too short.",'error');
        } elseif (strlen($_POST['name']) > 50) {
            setSession("Data is too long.",'error');
        } elseif (!preg_match('/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/', trim($_POST['name']))) {
            setSession("there is multiple spaces between words or may contain special characters",'error');
        }elseif($_POST['name'] !== trim($_POST['name'])){
            setSession("there is spaces at the start and end",'error');
        }

        validationEnd();
        
        dd("Data is ready to insert.");
        $name = filter($_POST['name']);
        $sql = "INSERT INTO levels (name,created_at) values ('$name',NOW());";
        run($sql);  
         
        redirect(route("list"),'Data is inserted successfully');
    
}

function delete(){
    $id = $_POST['id'];
    $sql = "DELETE FROM levels WHERE id = {$id}";
    run($sql);  

    redirect($_SERVER['HTTP_REFERER'],'Data is deleted successfully');
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
    redirect(route("list"),'Data is updated successfully');
}