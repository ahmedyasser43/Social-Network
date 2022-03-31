<!DOCTYPE html>
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
            <h3 style="text-align:center;"><strong>Forgot Password</strong></h3><hr>
          </div>
          <div class="l_pass">
            <form class="" action="" method="post">
              <div class="input-group">
                <?php
                    session_start();
                    include("include/connection.php");
                    if(isset($_GET['email'])){
                      $email=$_GET['email'];
                    }
                    $query = "select * from users where email='$email'";
                    $run = mysqli_query($con,$query);
                    $row = mysqli_fetch_array($run);
                    $recovery_question = $row['recovery_question'];
                    $user_answer = $row['recovery_answer'];
                 ?>
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <pre class="text"><?php  echo "$email"; ?></pre>
              </div><br>
              <hr>
              <pre class="text"><?php  echo "$recovery_question"; ?></pre>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <input type="text" id="msg" name="recovery_answer" class="form-control" placeholder="Answer" required>
              </div><br>
              <a href="signin.php" style="text-decoration: none;float: right;color: #6CC644;" data-toggle="tooltip" title="Signin" >Back to Login Page</a><br><br>
              <center><button id="signup" class="btn btn-info btn-lg" name="submit" style=" background-color:#6CC644; border: 2px solid #6CC644; border-radius:30px;width: 60%;">Submit</button></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
    if(isset($_POST['submit'])){
      if(isset($_POST['email'])){
        $email= htmlentities(mysqli_real_escape_string($con,$_POST['email']));
      }
      if(isset($_POST['recovery_answer'])){
        $recovery_answer = htmlentities(mysqli_real_escape_string($con,$_POST['recovery_answer']));
        $answer = sha1($recovery_answer);
      }
      if($user_answer==$answer){
      // if($user_answer==sha1("hello")){
          $_SESSION['email'] = $email;
          echo"<script>window.open('change_password.php','_self')</script>";
        }
      else {
        $ss = sha1("hello");
        echo "$answer         $ss";
        echo "<script>alert('Wrong Email or Answer')</script>";
      }
    }
 ?>
