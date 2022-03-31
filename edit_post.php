<!DOCTYPE html>
<?php
session_start();
include('include/header.php');
if(!isset($_SESSION['email'])){
  header("location: index.php");
}
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6">
        <?php
        global $Pid;
        $post_content="";
            if(isset($_GET['Pid'])){
              $get_id = $_GET['Pid'];
              $get_post = "select * from posts where Pid='$get_id'";
              $run_post= mysqli_query($con,$get_post);
              $row = mysqli_fetch_array($run_post);
              $post_content = $row['caption'];
            }
         ?>
         <form class="" action="" method="post" id="f">
           <center><h2>Edit Your Post</h2></center>
           <textarea class="form-control" name="content" rows="4" cols="83"><?php echo $post_content; ?></textarea><br>
           <input type="submit" name="update" value="Update Post" class="btn btn-info">
         </form>
         <?php
              if(isset($_POST['update'])){
                $content=$_POST['content'];
                $update_post="update posts set caption='$content' where Pid='$get_id'";
                $run_update = mysqli_query($con,$update_post);
                if($run_update){
                  echo "<script>alert('A Post has been Updated')</script>";
                  echo "<script>window.open('home.php','_self')</script>";
                }
              }
          ?>
      </div>
      <div class="col-sm-3">
      </div>
    </div>
  </body>
</html>
