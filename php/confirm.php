<?php
//email verification redirect
  function redirect(){
    header('Location:login.php');
    exit();
  }
  if(!isset($_GET['email'])|| !isset($_GET['token'])){
    redirect();
  }else {
    require_once "connection.php";

    $email=$_GET['email'];
    $token=$_GET['token'];

    $sql=$pdo->query("SELECT user_id FROM user WHERE email='$email' AND token='$token' AND isEmailConfirmed=0");
    $num_rows=$sql->rowCount();
    if($num_rows>0){
      $sql="UPDATE user SET isEmailConfirmed=1, token='' WHERE email=?";
      $query=$pdo->prepare($sql);
      $query->execute(array($email));
      echo'Your email has been verified! You can log in now!';
      redirect();
    }else {
      redirect();
    }
  }


 ?>
