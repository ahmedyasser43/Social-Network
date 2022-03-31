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
    <?php
    $user = $_SESSION['email'];
    $get_user = "select * from users where email='$user'";
    $run_user = mysqli_query($con,$get_user);
    if($run_user==""){
    echo "email was not found";}
    $row = mysqli_fetch_array($run_user);
    $user_fname = $row['fname'];
     ?>
    <title><?php echo "$user_fname" ?></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
<style media="screen">
  #cover-img{
    height:400px;
    width: 100%;
  }
  #profile-img{
    position: absolute;
    top: 160px;
    left: 40px;
  }
  #update_profile{
    position: relative;
    top: -40px;
    cursor: pointer;
    left: 93px;
    border-radius: 4px;
    background-color: rgba(0,0,0,0.1);
    transform: translate(-50%,-50%);
    opacity:0;
  }
  #button-profile{
    position: absolute;
    top: 85%;
    left:30%;
    cursor: pointer;
    transform: translate(-50%,-50%);
  }
  #own_posts{
    border: 5px solid #e6e6e6;
    padding: 40px 70px;
  }
  #posts_image{
    height: 300px;
    width: 70%;
  }

  #icdAid
{
   margin-bottom:15px;
}

#footer {
position:relative;
height: 20px;
bottom: 0;
width: 100%;
background-color: green;
}


#col-sm-7-N{
	margin: auto;
	width:400px;
}
</style>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-2">
      </div>
      <div class="col-sm-8">
        <?php
            echo"
            <div>
            <div><img id='cover-img' class='img-rounded' src='Cover/$user_cover' alt='cover'</div>
            <form action='profile.php?uid=$user_id' method='POST' enctype='multipart/form-data'>
            <ul class='nav pull-left' style='position:absolute;top:10px;left:40px;'>
            <li class='dropdown'>
            <button class='dropdown-toggle btn btn-default' data-toggle='dropdown'>Change Cover</button>
            <div class='dropdown-menu'>
            <center>
            <p>Click<strong> Select Cover</strong> and then click the<br><strong>Update Cover</strong></p>
            <label class='btn btn-info'>Select Cover Photo
            <input type='file' name='cover' size='60'value='Select Cover'/></label><br><br>
            <button name='submit'class='btn btn-info'>Update Cover</button>
            </center>
            </div>
            </li>
            </ul>
            </form>
            </div>
            <div id='profile-img'>
            <img src='users/$user_image' alt='Profile' class='img-circle' width='180px' height='185px'>
            <form action='profile.php?uid$user_id' method='post' enctype='multipart/form-data'>
            <label id='update_profile'class='btn btn-info'>Select Profile Picture
            <input type='file' name='u_image' style='opacity:0' size='60'/></label><br><br>
            <button id='button-profile' name='update'class='btn btn-info'>Update Profile</button>
            </form>
            </div><br>
            ";
         ?>
         <?php
              if(isset($_POST['submit'])){
                $u_cover=$_FILES['cover']['name'];
                $image_tmp=$_FILES['cover']['tmp_name'];
                $random_number=rand(1,100);
                if($u_cover==''){
                  echo"<script>alert('Please select cover Image')</script>";
                  echo"<script>window.open('profile.php?uid=$user_id','_self')</script>";
                  exit();
                }
                else{
                  move_uploaded_file($image_tmp,"cover/$user_cover .$random_number");
                  $update="update users set cover='$user_cover.$random_number' where uid='$user_id'";
                  $run = mysqli_query($con,$update);
                  if($run){
                    echo"<script>alert('Your Cover Updated')</script>";
                    echo"<script>window.open('profile.php?uid=$user_id','_self')</script>";
                  }
                }
              }
          ?>
      </div>
      <?php
           if(isset($_POST['update'])){
             $user_image=$_FILES['u_image']['name'];
             $image_tmp=$_FILES['u_image']['tmp_name'];
             $random_number=rand(1,100);
             if($user_image==''){
               echo"<script>alert('Please select a profile picture')</script>";
               echo"<script>window.open('profile.php?uid=$user_id','_self')</script>";
               exit();
             }
             else{
               move_uploaded_file($image_tmp,"users/$user_image.$random_number");
               $update="update users set Profile_picture='$user_image.$random_number' where uid='$user_id'";
               $run = mysqli_query($con,$update);
               if(strlen($user_image)>=1){
                 echo "string";
                 $user_image=$_FILES['u_image']['name'];
                 $image_tmp=$_FILES['u_image']['tmp_name'];
                 copy("users/$user_image.$random_number","imagepost/$user_image.$random_number");
                 $insert = "insert into posts (Pid,privacy,timePosted,image,posterName,caption,posterId) values('','only me',NOW(),'$user_image.$random_number','$user_fname $user_lname','','$user_id')";
                 $run_post = mysqli_query($con,$insert);
                 echo "$insert";
               }
               if(isset($run) && isset($run_post)){
                 echo"<script>alert('Your Profile Updated')</script>";
                 echo"<script>window.open('profile.php?uid=$user_id','_self')</script>";
               }
             }
           }
       ?>
       <div class="col-sm-1">
       </div>
    </div>
    <div class="row">
      <div class="col-sm-1">
      </div>
      <div class="col-sm-4" style="background-color:#e6e6e6; text-align:center;border-radius:5px;">
        <?php
            echo "
                  <center><h2><strong>About</strong></h2></center>
                  <center><h4><strong>$user_fname $user_lname</strong></h4></center>
                  <p><strong><i style='color:grey;'>$user_about</i></strong></p><br>
                  <p><strong>Date of birth: </strong> $user_birthday</p><br>
                  <p><strong>Relationship Status: </strong> $user_mstatus</p>
                  <p><strong>Lives In: </strong> $user_country</p><br>
            ";
         ?>
      </div>
      <div class="col-sm-7">
        <?php
            global $con;
            global $user_id;
            if(isset($_GET['uid'])){
              $poster_id=$_GET['uid'];
            }
            $page_flag = "profile.php";
            $get_posts = "select * from posts where posterId='$user_id' ORDER by 1 DESC LIMIT 5";
            $run_posts = mysqli_query($con,$get_posts);
            $page_flag="profile.php";
            while($row_posts = mysqli_fetch_array($run_posts)){
              $Pid = $row_posts['Pid'];
              $poster_id = $row_posts['posterId'];
              $content = $row_posts['caption'];
              $upload_image=$row_posts['image'];
              $post_date=$row_posts['timePosted'];
              $user = "select * from users where uid ='$poster_id'";
              $run_user= mysqli_query($con,$user);
              $row_user = mysqli_fetch_array($run_user);
              $user_name= $row_posts['posterName'];
              $user_image = $row_user['Profile_picture'];
              $likes = "select * from likes where Pid = '$Pid'";
              $likes_query = mysqli_query($con,$likes);
              $like_counter = 0;
              while($row_likes=mysqli_fetch_array($likes_query)){
                $like_counter++;
              }
              if(strlen($content) == 0 && strlen($upload_image)>= 1){
                echo "
                      <div id='own_posts'>
                          <div class='row'>
                            <div class='col-sm-3'>
                            </div>
                            <div  class='row'>
                              <div  class='col-sm-12'>
                                  <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                              </div>
                              <div class='col-sm-6'>
                                  <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                                  <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                              </div>
                              <div class='col-sm-4'>
                              </div>
                            </div>
                          </div>
                          <div id='col-sm-7-N' class='row'>
                              <div class='col-sm-12'>
                                  <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                              </div>
                          </div><br>";
                          if($like_counter==1){
                            echo"
                            <form action='' method='post' class='form-inline'>
                              <input type = 'hidden' value = '$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
                            </form>";
                          }
                          if($like_counter>1){
                            echo"
                            <form>
                              <input type = 'hidden' value ='$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Persons Liked this post</small></a></h4>
                            </form>
                            ";
                          }
                          echo"
                          <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success' name='view'>View</button></a>
                          <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                          <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                      </div><br><br><br>
                ";
              }
              else if(strlen($content)>=1 && strlen($upload_image)>= 1){
                echo "
                      <div id='own_posts'>
                          <div class='row'>
                              <div class='col-sm-2'>
                                  <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                              </div>
                              <div class='col-sm-6'>
                                  <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                                  <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                              </div>
                              <div class='col-sm-4'>
                              </div>
                          </div>
                          <div id='col-sm-7-N' class='row'>
                              <div class='col-sm-12'>
                                  <p>$content</p>
                                  <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                              </div>
                          </div><br>";
                          if($like_counter==1){
                            echo"
                            <form action='' method='post' class='form-inline'>
                              <input type = 'hidden' value = '$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
                            </form>";
                          }
                          if($like_counter>1){
                            echo"
                            <form>
                              <input type = 'hidden' value ='$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Persons Liked this post</small></a></h4>
                            </form>
                            ";
                          }
                          echo"
                          <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>View</button></a>
                          <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                          <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                      </div><br><br><br>
                ";
              }
              else{
                echo "
                      <div id='own_posts'>
                          <div class='row'>
                              <div class='col-sm-2'>
                                  <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                              </div>
                              <div class='col-sm-6'>
                                  <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                                  <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                              </div>
                              <div class='col-sm-4'>
                              </div>
                          </div>
                          <div class='row'>
                              <div class='col-sm-2'>
                              </div>
                              <div class='col-sm-6'>
                              <p>$content</p>
                              </div>
                              <div class='col-sm-4'>
                              </div>
                          </div><br>";
                          if($like_counter==1){
                            echo"
                            <form action='' method='post' class='form-inline'>
                              <input type = 'hidden' value = '$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
                            </form>";
                          }
                          if($like_counter>1){
                            echo"
                            <form>
                              <input type = 'hidden' value ='$Pid' name='Pid'>
                              <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal'><small style='color:black;'>$like_counter Persons Liked this post</small></a></h4>
                            </form>
                            ";
                          }
                          echo"
                          <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>View</button></a>
                          <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                          <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                      </div><br><br><br>
                ";
              }
              include("funtions/delete_post.php");

            }
         ?>
      </div>
      <div class="col-sm-2">
      </div>
    </div>
  </body>
</html>
