<?php 


require_once "./core/connect.php";
require_once "./core/function.php";

createTable("users","name varchar(20) NOT NULL","email varchar(30) NOT NULL","gender enum('male','female') NOT NULL","address text NOT NULL");
