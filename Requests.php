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
    <title>Friend Requests</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-12">
        <center><h2>Friend Requests</h2></center><br><br>
        <div class="row">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
          </div>
        </div><br><br>
        <?php get_requests(); ?>
      </div>
    </div>
  </body>
</html>
