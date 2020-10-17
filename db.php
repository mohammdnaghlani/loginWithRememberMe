<?php
session_start() ;
$dsn = "mysql:host=localhost;dbname=my_database";
$username = 'root';
$password = '' ;

try{
    $connect = new PDO($dsn,$username,$password);
    if($connect){
       // echo 'connect' ;
    }
}catch(PDOException $error){
    echo $error->getMessage() ;
}

//---------------function

function getUserByEmail(string $email)
{
    global $connect ;
    $query = "SELECT * FROM `users` WHERE `email`=:email LIMIT 1" ;
    $result = $connect->prepare($query);
    $result->bindParam(':email' , $email);
    $result->execute();
    $user = $result->fetch(PDO::FETCH_OBJ);
    if(!$user){
        return false ;
    }
    return $user ;
}

function getRememberMeToken(string $email)
{
    global $connect ;
    $query = "UPDATE `users` SET `remember_me` = ? WHERE `email` = ? LIMIT 1" ;
    $token = md5(microtime(). $email);
    $result = $connect->prepare($query);
    $result->bindValue(1 , $token);
    $result->bindValue(2 , $email);
    $result->execute();
    if($result->rowCount() > 0){
        return $token ;
    }
    return false ;
}

function forceLogin(string $token)
{
    global $connect ;
    $query = "SELECT * FROM `users` WHERE `remember_me`=:token LIMIT 1" ;
    $result = $connect->prepare($query);
    $result->bindParam(':token' , $token);
    $result->execute();
    $user = $result->fetch(PDO::FETCH_OBJ);
    if(!$user){
        return false ;
    }
    $_SESSION['login'] = array(
        'status' => true ,
        'info' => $user ,
      );
    return true ; 
}