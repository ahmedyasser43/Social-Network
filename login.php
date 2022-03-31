<?php
    session_start();
    include("include/connection.php");
    if(isset($_POST['submit'])){
      $email= htmlentities(mysqli_real_escape_string($con,$_POST['email']));
      $password= htmlentities(mysqli_real_escape_string($con,$_POST['password']));
      $password =sha1($password);
      $select_user = "select * from users where email = '$email' AND upassword = '$password'";
      $query = mysqli_query($con,$select_user);
      $check_user =  mysqli_num_rows($query);
      if($check_user==1){
          $row = mysqli_fetch_array($query);
          $uid = $row['uid'];
          $_SESSION['uid'] = $uid;
          $_SESSION['email']=$email;
          echo"<script>window.open('home.php','_self')</script>";
        }
      else {
        echo "<script>alert('Wrong Email or Password')</script>";
        echo"<script>window.open('signin.php','_self')</script>";
      }
    }
 ?>
