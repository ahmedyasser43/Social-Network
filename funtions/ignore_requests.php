<?php
  $con =mysqli_connect("localhost","root","","social_network");
  session_start();
  if(isset($_GET['uid'])&&$_GET['senderId']){
    $receiverId = $_GET['uid'];
    $senderId = $_GET['senderId'];
  }
  $request_query = "select requestId from requests where senderId='$senderId' AND receiverId='$receiverId'";
  $get_request = mysqli_query($con,$request_query);
  $query = mysqli_fetch_array($get_request);
  $requestId = $query;
  $delete = "delete from requests where requestId='$requestId'";
  $delete_query = mysqli_query($con,$delete);
  if($delete_query){
    echo"<script>alert('Request Deleted')</script>";
      echo "<script>window.open('/Social_Network/Requests.php','_self')</script>";
  }
 ?>
