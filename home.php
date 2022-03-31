<!DOCTYPE html>


<style>


.col-sm-7-N {
	margin: auto;
	width: 400px;
	text-align: center;

}



</style>



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
    <title><?php echo "$user_fname $user_lname" ?></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
  </head>
  

  
  <body>
    <div class="row">
      <div id="insert_post" style="background-color:#fff; border:2px solid #e6e6e6; padding:40px 50px;" class="col-sm-12">
        <center>
        <form action="home.php?id=<?php echo $user_id;?>" method="post" id="f" enctype="multipart/form-data">
          <textarea name="content" rows="4" cols="80" style="width:70%;"id="content" data-emoji="true" class="form-control" placeholder="What's on your mind?"></textarea><br>
          <label class="btn btn-warning" id="upload_image_button">Select Image
            <input type="file" name="upload_image" size="30" style="opacity:0;">
          </label>
          <button id="btn-post" class="btn btn-success" type="submit" name="sub">Post</button>
        </form>
        <?php
            insertPost();
         ?>
      </center>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-7">
        <center><h2><strong>News Feed</strong></h2></center>
        <?php echo get_posts(); ?>
      </div>
    </div>
  </body>
</html>
