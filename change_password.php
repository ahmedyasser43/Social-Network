<!DOCTYPE html>
<?php
session_start();
include('include/connection.php');
if(!isset($_SESSION['email'])){
  header("location: index.php");
}
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Frogot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <style media="screen">
    body{
      overflow-x: hidden;
    }
    .main-content{
      width: 50%;
      height: 40%;
      margin: 10px auto;
      background-color: #fff;
      border: 2px solid #e6e6e6;
      padding: 40px 50px;
    }
    .header{
      border: 0px solid #000;
      margin-bottom: 5px;
    }
    .well{
      background-color: #6CC644;
    }
    #signup{
      width: 60%;
      border-radius: 30px;
    }
  </style>
  <body>
    <div class="row">
      <div class="col-sm-12">
        <div class="well">
          <center><h1 style="color:white;"><strong>The Social Network</strong></h1></center>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="main-content">
          <div class="header">
            <h3 style="text-align:center;"><strong>Change Your Password</strong></h3><hr>
          </div>
          <div class="l_pass">
            <form class="" action="" method="post">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id= "password" class="form-control" type="password" name="password" placeholder="New Password" required>
              </div><br>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" id="password" name="cpassword" class="form-control" placeholder="Confirm Password" required>
              </div><br>
              <center><button id="signup" class="btn btn-info btn-lg" name="Change" style=" background-color:#6CC644; border: 2px solid #6CC644; border-radius:30px;width: 60%;">Change Password</button></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
    if(isset($_POST['Change'])){
      $user = $_SESSION['email'];
      $get_user = "select * from users where email='$user'";
      $run_user = mysqli_query($con,$get_user);
      $row = mysqli_fetch_array($run_user);
      $uid = $row['uid'];
      $password= htmlentities(mysqli_real_escape_string($con,$_POST['password']));
      $cpassword= htmlentities(mysqli_real_escape_string($con,$_POST['cpassword']));
      if($password == $cpassword){
        if(strlen($password)>= 8 && strlen($password)<=60){
          $password=sha1($password);
          $update = "update users set upassword='$password' where uid ='$uid'";
          $run = mysqli_query($con,$update);
          if(isset($run)){
            $_SESSION['uid'] = $uid;
            echo "<script>alert('Password changed successful')</script>";
            echo "<script>window.open('home.php','_self')</script>";
          }
        }
        else{
          echo "<script>alert('Password should be longer than 8 characters')</script>";
        }
      }else {
        echo "<script>alert('Passwords doesn't address')</script>";
        echo "<script>window.open('change_password.php','_self')</script>";
      }
    }
 ?>
