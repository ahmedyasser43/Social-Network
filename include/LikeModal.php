<!DOCTYPE html>
<?php
// session_start();
include('connection.php');
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>

    $(document).ready(function(){

        $("#LikeModal").modal('show');

    });

</script>
  </head>
  <body>
    <div id="LikeModal" class="modal" role="dialog" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Likes</h4>
          </div>
          <div class="modal-body">
            <?php
                if(isset($_GET['Pid'])){
                  $post_id = $_GET['Pid'];
                }
                if(isset($_GET['page_flag'])){
                  $page_flag=$_GET['page_flag'];
                }
                if(isset($_GET['search_query'])){
                  $search_query = $_GET['search_query'];
                }
                $likes = "select * from likes where Pid='$post_id'";
                $likes_query = mysqli_query($con,$likes);
                while($row= mysqli_fetch_array($likes_query)){
                  $uid = $row['uid'];
                  $query= "select * from users where uid='$uid'";
                  $run = mysqli_query($con,$query);
                  $row = mysqli_fetch_array($run);
                  $fname =$row['fname'];
                  $lname =$row['lname'];
                  $profile_picture = $row['Profile_picture'];
                  echo "
                      <div class = 'row'>
                          <div class='col-sm-1'>
                          </div>
                          <div class='col-sm-8'>
                              <div class='row' id='find_people'>
                                  <div class='col-sm-3'>
                                      <a href='/Social_Network/user_profile.php?uid=$uid'>
                                      <img src='/Social_Network/users/$profile_picture' class= 'img-circle' width='80px' height='80px' title='$fname' style = 'float:left; margin:1px;'/>
                                      </a>
                                  </div><br><br>
                                  <div class='col-sm-6'>
                                      <a href='user_profile.php?uid=$uid' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                                      <strong><h4>$fname $lname</h4></strong></a>
                                  </div>
                                  <div class='col-sm-2'>
                                  </div>
                              </div>
                          </div>
                          <div class='col-sm-3'>
                          </div>
                      </div><br><br>
                  ";
                }
             ?>
          </div>
          <div class="modal-footer">
            <form class="" action="" method="post" enctype="multipart/form-data">
              <!-- <input class="btn btn-info" type="submit" name="update" style="width:250px;" value="Close"> -->
              <?php
                  if($page_flag=="user_profile.php"){
                  echo"
                  <a href='/Social_Network/$page_flag?uid=$uid' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                  ";
                }
                if($page_flag=="results.php"){
                echo"
                <a href='/Social_Network/$page_flag?search_query=$search_query' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                ";
              }
                if($page_flag=="profile.php"){
                echo"
                <a href='/Social_Network/$page_flag?uid=$uid' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                ";
              }
                elseif ($page_flag=="home.php") {
                  echo"
                  <a href='/Social_Network/$page_flag' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                  ";
                }
                elseif ($page_flag=="single_post.php") {
                  echo"
                  <a href='/Social_Network/$page_flag?Pid=$post_id' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                  ";
                }
                elseif($page_flag=="my_post.php"){
                  echo"
                  <a href='/Social_Network/$page_flag?uid=$uid' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                  ";
                }
               ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
