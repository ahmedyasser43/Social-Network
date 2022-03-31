<?php
  $con =mysqli_connect("localhost","root","","social_network");
  session_start();
  if(isset($_GET['uid'])){
    $receiverId = $_GET['uid'];
  }
  $user = $_SESSION['email'];
  $get_user = "select * from users where email='$user'";
  $run_user = mysqli_query($con,$get_user);
  $row = mysqli_fetch_array($run_user);
  $senderId =$row['uid'];
  $receiverId = $_GET['uid'];
  $request_query = "select * from requests where senderId='$senderId' AND receiverId='$receiverId' OR senderId='$receiverId' AND receiverId='$senderId'";
  $get_requests = mysqli_query($con,$request_query);
  while($row_request = mysqli_fetch_array($get_requests)){
    echo "$senderId";
    $sender_id = $row_request['senderId'];
    echo "$sender_id";
    $receiver_id = $row_request['receiverId'];
    if($sender_id == $senderId){
      echo "strin2222222222222222g";
      echo "<script>window.open('/Social_Network/user_profile.php?uid=$receiverId','_self')</script>";
      exit();
    }elseif ($senderId == $receiver_id) {
      echo "string";
      echo "<script>window.open('/Social_Network/user_profile.php?uid=$receiverId','_self')</script>";
      exit();
    }
  }
  $request = "insert into requests (requestId,senderId,receiverId) values ('','$senderId',$receiverId)";
  $query = mysqli_query($con,$request);
  if(isset($query)){
    echo"<script>alert('Request Sent')</script>";
    echo "<script>window.open('/Social_Network/user_profile.php?uid=$receiverId','_self')</script>";
  }else{
    echo"<script>alert('ERROR while sending the request!!!')</script>";
      echo "<script>window.open('requests.php?uid=$receiverId','_self')</script>";
  }
 ?>
