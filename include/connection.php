<?php
$con = mysqli_connect("localhost","root","","social_network");
$page_flag="";
if($con-> connect_errno){
  echo "Failed to connect to MYSQL".$con->connect_error;
  exit();
}
// echo "connection successful";
 ?>
