<?php
include("include/connection.php");
// $password= htmlentities(mysqli_real_escape_string($con,$_POST['password']));
// $confirm_password =htmlentities(mysqli_real_escape_string($con,$_POST['confirm-password']));
// if($password != $confirm_password){
//   echo"<script>alert('Passwords don't match')</script>";
//   echo"<script>window.open('signup.php','_self')</script>";
//   exit();
// }
if(isset($_POST['sign_up'])){
  $first_name= htmlentities(mysqli_real_escape_string($con,$_POST['first_name']));
  $last_name= htmlentities(mysqli_real_escape_string($con,$_POST['last_name']));
  $email= htmlentities(mysqli_real_escape_string($con,$_POST['email']));
  $password= htmlentities(mysqli_real_escape_string($con,$_POST['password']));
  $confirm_password =htmlentities(mysqli_real_escape_string($con,$_POST['confirm-password']));
  $phone_number= htmlentities(mysqli_real_escape_string($con,$_POST['phone-number']));
  $gender= htmlentities(mysqli_real_escape_string($con,$_POST['gender']));
  $birthday= htmlentities(mysqli_real_escape_string($con,$_POST['Birthday']));
  $privacy = htmlentities(mysqli_real_escape_string($con,$_POST['privacy']));
  $recovery_question = htmlentities(mysqli_real_escape_string($con,$_POST['recovery_question']));
  $recovery_answer = htmlentities(mysqli_real_escape_string($con,$_POST['recovery_answer']));
  $password =sha1($password);
  $recovery_answer = sha1($recovery_answer);
  if(isset($_POST['country'])){
    $country= htmlentities(mysqli_real_escape_string($con,$_POST['country']));
  }
  else {
    $country='';
  }
  if(isset($_POST['mstatus'])){
    $mstatus= htmlentities(mysqli_real_escape_string($con,$_POST['mstatus']));
  }
  else {
    $mstatus='';
  }
  $about= htmlentities(mysqli_real_escape_string($con,$_POST['about']));
  $profile_picture= htmlentities(mysqli_real_escape_string($con,$_POST['profile_picture']));
  $check_email_query = "select * from users where email='$email'";
  $run_email= mysqli_query($con,$check_email_query);
  $check=mysqli_num_rows($run_email);
  if($check >0){
    echo"<script>alert('Email already exist, Please try again using another email')</script>";
    echo"<script>window.open('signup.php','_self')</script>";
    exit();
  }
  if(strlen($password)<8){
    echo"<script>alert('Password should be minimum 8 characters!!')</script>";
    exit();
  }
  if(strlen($profile_picture)==0){
    if($gender == "Male")
        $profile_picture="male.jpg";
    else if($gender =="female")
        $profile_picture="female.jpg";
        else {
          $profile_picture="other.jpg";
        }
      }
        $insert = "insert into users (uid,fname,lname,upassword,email,gender,phone_number,birthdate,Profile_picture,privacy,hometown,m_status,about,recovery_question,recovery_answer)
        values('','$first_name','$last_name','$password','$email','$gender','$phone_number','$birthday','$profile_picture','$privacy','$country','$mstatus','$about','$recovery_question','$recovery_answer')";
        $query = mysqli_query($con,$insert);
        if($query){
          echo"<script>alert('Well Done $first_name, Good to go.')</script>";
          echo"<script>window.open('signin.php','_self')</script>";
        }
        else {
          echo "$insert";
          echo "$query";
          echo"<script>alert('Regiseration FAILED,please try again...')</script>";
          echo"<script>window.open('signup.php','_self')</script>";
        }
        echo "string";


}
 ?>
