
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'db.php';
if(isset($_COOKIE['rememberMe']) && !isset($_SESSION['login'])){
  echo $_COOKIE['rememberMe'] ;
  forceLogin($_COOKIE['rememberMe']) ;
}
 if(isset($_POST['submit'])){
   $email = trim($_POST['email']);
   $password = trim($_POST['pw']) ;
   if($email <> '' && $password != ''){
      $get_user = getUserByEmail($email);
      var_dump($get_user) ;
      if(!$get_user){

          echo 'user not found !' ;
      
        }else{

        if($password != $get_user->password){
          echo 'password incorect';
        }else{
            //echo 'login' ;
            $_SESSION['login'] = array(
              'status' => true ,
              'info' => $get_user ,
            );
            if(isset($_POST['rememberMe'])){
              $token = getRememberMeToken($email);
             if($token){
               setcookie('rememberMe' , $token , time() + 30) ;
             }
            }
        }

      }

   }else{
    
   }
 }
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Bootstrap Snippet: Login Form</title>
  <link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
  <?php if(!isset($_SESSION['login']['status'])) :?>
<!-- partial:index.partial.html -->
<div class="wrapper">
    <form class="form-signin" action="" method="POST">       
      <h2 class="form-signin-heading">Please login</h2>
      <input type="text" class="form-control" name="email" placeholder="Email Address"  />
      <input type="password" class="form-control" name="pw" placeholder="Password" />      
      <label class="checkbox">
        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
      </label>
      <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="login">
    </form>
  </div>
<!-- partial -->
  <?php endif;?>
  
</body>
</html>
