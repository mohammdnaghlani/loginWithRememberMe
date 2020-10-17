<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'db.php';

if(isset($_SESSION['login'])){
    var_dump($_SESSION['login']);
}else{
    header('location:index.php') ;
}