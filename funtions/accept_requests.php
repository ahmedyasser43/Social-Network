<?php
  $con =mysqli_connect("localhost","root","","social_network");
  session_start();
  if(isset($_GET['uid'])&&$_GET['senderId']){
    $receiverId = $_GET['uid'];
    $senderId = $_GET['senderId'];
  }
  $friend_query = "insert into friends (id,uid,friendId) values ('','$receiverId','$senderId')";
  $get_query = mysqli_query($con,$friend_query);
  $request_query = "select requestId from requests where senderId='$senderId' AND receiverId='$receiverId'";
  $get_request = mysqli_query($con,$request_query);
  $row = mysqli_fetch_array($get_request);
  $requestId = $row['requestId'];
  $delete = "delete from requests where requestId='$requestId'";
  $delete_query = mysqli_query($con,$delete);
  if($delete_query){
    echo"<script>alert('Request Accepted')</script>";
      echo "<script>window.open('/Social_Network/Requests.php','_self')</script>";
  }

 ?>
