<?php
      $con = mysqli_connect("localhost","root","","social_network") or die("Connection wasn't established");
      global $Pid;
      if(isset($_GET['Pid'])){
        $Pid = $_GET['Pid'];
        $delete_post="delete from posts where Pid= '$Pid'";
        $run_delete = mysqli_query($con,$delete_post);
        $delete_likes = "delete from likes where Pid ='$Pid'";
        $run_likes = mysqli_query($con,$delete_likes);
        $delete_comments = "delete from comments where Pid='$Pid'";
        $run_comments=mysqli_query($con,$delete_comments);
        if($run_delete){
          echo "<script>alert('A Post have been deleted')</script>";
          echo "<script>window.open('../home.php','_self')</script>";
        }
      }
 ?>
