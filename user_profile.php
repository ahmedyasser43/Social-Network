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
    <title>Find People</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>


    <div class="row">
      <?php
          if(isset($_GET['uid'])){
                $uid=$_GET['uid'];
                $user_id = $_SESSION['uid'];
          }else {
            exit();
          }
          if($uid<0 || $uid==""){
            echo "<script>window.open('home.php','_self')</script>";
          }elseif ($uid == $user_id) {
            echo "<script>window.open('profile.php?uid=$user_id','_self')</script>";
          }
          else{
       ?>
       <div class="col-sm-12">
          <?php
            if(isset($_GET['uid'])){
              global $con;
              $uid = $_GET['uid'];
              $select = "select * from users where uid = '$uid'";
              $run = mysqli_query($con,$select);
              $row = mysqli_fetch_array($run);
              $name = $row['fname'];
            }
           ?>
           <?php
                if(isset($_SESSION['uid'])){
                  $uid = $_SESSION['uid'];
                }
                if(isset($_GET['uid'])){
                  global $con;
                  $id = $_GET['uid'];
                  $select = "select * from users where uid='$id'";
                  $run = mysqli_query($con,$select);
                  $row=mysqli_fetch_array($run);
                  $profile_picture = $row['Profile_picture'];
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $about = $row['about'];
                  $country = $row['hometown'];
                  $gender = $row['gender'];
                  $privacy = $row['privacy'];
                  $birthday = $row['birthdate'];
                  echo"
                      <div class='row'>
                          <div class='col-sm-4'>
                          </div>
                          <center>
                          <div class='col-sm-4' style='background-color: #e6e6e6'>
                              <h2>Information about</h2>
                              <img class='img-circle' src='users/$profile_picture' width='150' height='150'><br><br>
                              <ul class='list-group'>
                                  <li class='list-group-item' title='Username'><strong>$fname $lname</strong></li>
                                  <li class='list-group-item' title='gender'><strong>$gender</strong></li>
                                  <li class='list-group-item' title='Username'><strong>$country</strong></li>";
                                  $friend_query = "select * from friends where uid='$user_id' AND friendId='$uid'";
                                  $friend_query2 = "select * from friends where uid='$uid'AND friendId='$user_id'";
                                  $get_friends = mysqli_query($con,$friend_query);
                                  $get_friends2 = mysqli_query($con,$friend_query2);
                                  $friendsflag = 0;
                                  if(mysqli_num_rows($get_friends)==1||mysqli_num_rows($get_friends2)==1){
                                    $friendsflag=1;
                                  }
                                  if($friendsflag==1){
                                  echo"
                                  <li class='list-group-item' title='birthday'><strong>$birthday</strong></li>
                                  <li class='list-group-item' title='User Status'><strong style='color:grey;'>$about</strong></li>
                              </ul>
                  ";
                }
                  $user = $_SESSION['email'];
                  $get_user="select * from users where email='$user'";
                  $run_user = mysqli_query($con,$get_user);
                  $row= mysqli_fetch_array($run_user);
                  $user_id = $row['uid'];
                  $query = "select * from requests where senderId='$user_id' AND receiverId='$uid'";
                  $query2 = "select * from requests where senderId='$uid' AND receiverId='$user_id'";
                  $get_query= mysqli_query($con,$query);
                  $get_query2= mysqli_query($con,$query2);
                  $friend_query = "select * from friends where uid='$id' AND friendId='$uid'";
                  $friend_query2 = "select * from friends where uid='$uid'AND friendId='$id'";
                  $request_query = "select * from requests where senderId='$uid' AND receiverId='$id'";
                  $run = mysqli_query($con,$request_query);
                  $request_query2 = "select * from requests where senderId='$id' AND receiverId='$uid'";
                  $receive_run = mysqli_query($con,$request_query2);
                  $sentflag = 0;
                  $receivedflag = 0;
                  $flag = 0;
                  $friendsflag = 0;
                  if(mysqli_num_rows($get_query)==1||mysqli_num_rows($get_query2)==1){
                    $flag = 1;
                  }
                  $get_friends = mysqli_query($con,$friend_query);
                  $get_friends2 = mysqli_query($con,$friend_query2);
                  $x = mysqli_num_rows($get_friends);
                  $y = mysqli_num_rows($get_friends2);
                  if(mysqli_num_rows($get_friends)==1||mysqli_num_rows($get_friends2)==1){
                    $friendsflag=1;
                  }
                  if(mysqli_num_rows($run)==1){
                    echo "$uid   $user_id";
                    $sentflag =1;
                    $row_request = mysqli_fetch_array($run);
                    $requestId = $row_request['requestId'];
                  }
                  if(mysqli_num_rows($receive_run)==1){
                    echo "$uid   $id";
                    $receivedflag =1;
                    $row_request = mysqli_fetch_array($receive_run);
                    $requestId = $row_request['requestId'];
                    $senderId = $row_request['senderId'];
                  }
                  if($uid == $id){
                    echo "<a href='edit_profile.php?uid=$user_id' class='btn btn-success'>Edit Profile</a><br><br><br>";
                  }
                  else{
                    if($friendsflag==1){
                    }
                    elseif ($sentflag==1) {
                      echo "
                      <form action='' method='post'>
                      <button type='submit' class='btn btn-danger' name='cancel'>Cancel Request</button>
                      </form>
                      ";
                    }
                    elseif ($receivedflag==1) {
                      echo"
                      <form method='post'>
                      <button class='btn btn-success' name='confirm'>Confirm</button>
                      <button class='btn btn-danger' name='ignore'>Ignore</button>
                      </form>
                      ";
                    }
                    else {
                        echo "<a href='funtions/requests.php?uid=$id' class='btn btn-success'>Send Request</a><br><br><br>";
                      }
                    }
                  echo "
                  </div>
                  </center>
                  <div class='col-sm-4'>
                  </div>
                  ";
                }
            ?>
            <div class="col-sm-8">
              <center><h1><strong><?php echo "$fname $lname"; ?></strong> Posts</h1></center>
              <?php
                  global $con;
                  if(isset($_GET['uid'])){
                    $uid = $_GET['uid'];
                  }
                  $get_posts ="select * from posts where posterId='$uid' ORDER by 1 DESC LIMIT 5";
                  $run_posts = mysqli_query($con,$get_posts);
                  $query = "select * from users where uid='$uid'";
                  $run = mysqli_query($con,$query);
                  $row=mysqli_fetch_array($run);
                  $page_flag="user_profile.php";
                  $user_privacy= $row['privacy'];
                  $friendship = "select * from friends where uid = '$uid' AND friendid='$id' OR uid = '$id' AND friendId='$uid'";
                  $friend_query  = mysqli_query($con,$friendship);
                  if($user_privacy=="private"){
                  if($friend_query){
                  while($row_posts = mysqli_fetch_array($run_posts)){
                    $Pid = $row_posts['Pid'];
                    $uid = $row_posts['posterId'];
                    $content = $row_posts['caption'];
                    $upload_image = $row_posts['image'];
                    $timePosted=$row_posts['timePosted'];
                    $user = "select * from users where uid='$uid'";
                    $run_user = mysqli_query($con,$user);
                    $row_user = mysqli_fetch_array($run_user);
                    $fname = $row_user['fname'];
                    $lname = $row_user['lname'];
                    $profile_picture = $row_user['Profile_picture'];
                    $likes = "select * from likes where Pid = '$Pid'";
                    $likes_query = mysqli_query($con,$likes);
                    $like_counter = 0;
                    while($row_likes=mysqli_fetch_array($likes_query)){
                      $like_counter++;
                    }
                    if(strlen($content) == 0 && strlen($upload_image)>= 1){
                      echo "
                            <br><br><br>
                            <div class='col-sm-1'>
                            </div>
                            <div id='own_posts class='col-sm-10'>
                                  <div class='row'>
                                  <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                    <div class='col-sm-2'>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                  </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                                    </div>
                                </div><br>";
                                if($like_counter==1){
                                  echo"
                                  <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>
                                    <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                                <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                                <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>";
                                    $like_flag=0;
                                    $user_id = $_SESSION['uid'];
                                    $likes = "select * from likes where Pid='$Pid'";
                                    $query = mysqli_query($con,$likes);
                                    while($row = mysqli_fetch_array($query)){
                                      $liker_id = $row['uid'];
                                      if($liker_id == $user_id){
                                        $like_flag=1;
                                        break;
                                      }
                                    }
                                    if($like_flag==1){
                                          echo "
                                              <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                              </div><br><br><br>
                                              <div class='col-sm-1'>
                                              </div>
                                          ";
                                        }
                                        else{
                                          echo "
                                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                          </div>
                                          <div class='col-sm-1'>
                                          </div><br><br><br>
                                          ";
                                        }
                    }
                    else if(strlen($content)>=1 && strlen($upload_image)>= 1){
                      echo "
                            <br><br><br>
                            <div class='col-sm-1'>
                            </div>
                            <div id='own_posts' class='col-sm-10'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12' style='align:center;'>
                                        <p>$content</p>
                                        <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                                    </div>
                                </div><br>";
                                if($like_counter==1){
                                  echo"
                                  <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>
                                    <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                                <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                                <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>";
                                    $like_flag=0;
                                    $user_id = $_SESSION['uid'];
                                    $likes = "select * from likes where Pid='$Pid'";
                                    $query = mysqli_query($con,$likes);
                                    while($row = mysqli_fetch_array($query)){
                                      $liker_id = $row['uid'];
                                      if($liker_id == $user_id){
                                        $like_flag=1;
                                        break;
                                      }
                                    }
                                    if($like_flag==1){
                                          echo "
                                              <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                              </div><br><br><br>
                                              <div class='col-sm-1'>
                                              </div>
                                          ";
                                        }
                                        else{
                                          echo "
                                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                          </div>
                                          <div class='col-sm-1'>
                                          </div><br><br><br>
                                          ";
                                        }
                    }
                    else{
                      echo "
                            <br><br><br>
                            <div class='col-sm-1'>
                            </div>
                            <div id='own_posts' class='col-sm-10'>
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                    </div>
                                    <div class='col-sm-6'>
                                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                      <p>$content</p>
                                    </div>
                                </div><br>";
                                if($like_counter==1){
                                  echo"
                                  <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>
                                    <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                                <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                                <form action='' method='post' class='form-inline'>
                                    <input type = 'hidden' value = '$Pid' name='Pid'>";
                                    $like_flag=0;
                                    $user_id = $_SESSION['uid'];
                                    $likes = "select * from likes where Pid='$Pid'";
                                    $query = mysqli_query($con,$likes);
                                    while($row = mysqli_fetch_array($query)){
                                      $liker_id = $row['uid'];
                                      if($liker_id == $user_id){
                                        $like_flag=1;
                                        break;
                                      }
                                    }
                                    if($like_flag==1){
                                          echo "
                                              <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                              </div><br><br><br>
                                              <div class='col-sm-1'>
                                              </div>
                                          ";
                                        }
                                        else{
                                          echo "
                                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                          </div>
                                          <div class='col-sm-1'>
                                          </div><br><br><br>
                                          ";
                                        }
                    }
                  }
                }
              }
              else {
                while($row_posts = mysqli_fetch_array($run_posts)){
                  $Pid = $row_posts['Pid'];
                  $uid = $row_posts['posterId'];
                  $content = $row_posts['caption'];
                  $upload_image = $row_posts['image'];
                  $timePosted=$row_posts['timePosted'];
                  $user = "select * from users where uid='$uid'";
                  $run_user = mysqli_query($con,$user);
                  $row_user = mysqli_fetch_array($run_user);
                  $fname = $row_user['fname'];
                  $lname = $row_user['lname'];
                  $profile_picture = $row_user['Profile_picture'];
                  $likes = "select * from likes where Pid = '$Pid'";
                  $likes_query = mysqli_query($con,$likes);
                  $like_counter = 0;
                  while($row_likes=mysqli_fetch_array($likes_query)){
                    $like_counter++;
                  }
                  if(strlen($content) == 0 && strlen($upload_image)>= 1){
                    echo "
                          <br><br><br>
                          <div class='col-sm-1'>
                          </div>
                          <div id='own_posts' class='col-sm-10'>
                              <div class='row'>
                                  <div class='col-sm-2'>
                                      <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                  </div>
                                  <div class='col-sm-6'>
                                      <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                      <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                  </div>
                                  <div class='col-sm-4'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-sm-12'>
                                      <p>$content</p>
                                      <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                                  </div>
                              </div><br>";
                              if($like_counter==1){
                                echo"
                                <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>
                                  <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                              <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                              <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>";
                                  $like_flag=0;
                                  $user_id = $_SESSION['uid'];
                                  $likes = "select * from likes where Pid='$Pid'";
                                  $query = mysqli_query($con,$likes);
                                  while($row = mysqli_fetch_array($query)){
                                    $liker_id = $row['uid'];
                                    if($liker_id == $user_id){
                                      $like_flag=1;
                                      break;
                                    }
                                  }
                                  if($like_flag==1){
                                        echo "
                                            <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                            </div><br><br><br>
                                            <div class='col-sm-1'>
                                            </div>
                                        ";
                                      }
                                      else{
                                        echo "
                                        <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                        </div>
                                        <div class='col-sm-1'>
                                        </div><br><br><br>
                                        ";
                                      }
                  }
                  else if(strlen($content)>=1 && strlen($upload_image)>= 1){
                    echo "
                          <br><br><br>
                          <div class='col-sm-1'>
                          </div>
                          <div id='own_posts' class='col-sm-10'>
                              <div class='row'>
                                  <div class='col-sm-2'>
                                      <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                  </div>
                                  <div class='col-sm-6'>
                                      <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                      <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                  </div>
                                  <div class='col-sm-4'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-sm-12'>
                                      <p>$content</p>
                                      <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                                  </div>
                              </div><br>";
                              if($like_counter==1){
                                echo"
                                <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>
                                  <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                              <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                              <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>";
                                  $like_flag=0;
                                  $user_id = $_SESSION['uid'];
                                  $likes = "select * from likes where Pid='$Pid'";
                                  $query = mysqli_query($con,$likes);
                                  while($row = mysqli_fetch_array($query)){
                                    $liker_id = $row['uid'];
                                    if($liker_id == $user_id){
                                      $like_flag=1;
                                      break;
                                    }
                                  }
                                  if($like_flag==1){
                                        echo "
                                            <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                            </div><br><br><br>
                                            <div class='col-sm-1'>
                                            </div>
                                        ";
                                      }
                                      else{
                                        echo "
                                        <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                        </div>
                                        <div class='col-sm-1'>
                                        </div><br><br><br>
                                        ";
                                      }
                  }
                  else{
                    echo "
                          <br><br><br>
                          <div class='col-sm-1'>
                          </div>
                          <div id='own_posts' class='col-sm-10'>
                              <div class='row'>
                                  <div class='col-sm-2'>
                                      <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                  </div>
                                  <div class='col-sm-6'>
                                      <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                      <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                  </div>
                                  <div class='col-sm-4'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-sm-12'>
                                    <p>$content</p>
                                  </div>
                              </div><br>";
                              if($like_counter==1){
                                echo"
                                <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>
                                  <h4><a style='text-decorarion:none; cursor:pointer;' href='include/LikeModal.php?Pid=$Pid&page_flag=$page_flag' data-toggle='modal' data-id='$Pid'><small style='color:black;'>$like_counter Person Liked this post</small></a></h4>
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
                              <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>Comment</button></a>
                              <form action='' method='post' class='form-inline'>
                                  <input type = 'hidden' value = '$Pid' name='Pid'>";
                                  $like_flag=0;
                                  $user_id = $_SESSION['uid'];
                                  $likes = "select * from likes where Pid='$Pid'";
                                  $query = mysqli_query($con,$likes);
                                  while($row = mysqli_fetch_array($query)){
                                    $liker_id = $row['uid'];
                                    if($liker_id == $user_id){
                                      $like_flag=1;
                                      break;
                                    }
                                  }
                                  if($like_flag==1){
                                        echo "
                                            <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br></form>
                                            </div><br><br><br>
                                            <div class='col-sm-1'>
                                            </div>
                                        ";
                                      }
                                      else{
                                        echo "
                                        <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                        </div>
                                        <div class='col-sm-1'>
                                        </div><br><br><br>
                                        ";
                                      }
                  }
                }
              }
              if(isset($_POST['like'])){
                $user = $_GET['uid'];
                $Pid = htmlentities($_POST['Pid']);
                echo $Pid;
                $query = "select *from likes where Pid = '$Pid'";
                $run = mysqli_query($con,$query);
                $uid=$_SESSION['uid'];
                while($row = mysqli_fetch_array($run)){
                  $user_id = $row['uid'];
                  if($user_id ==$uid){
                    echo"<script>window.open('user_profile.php?uid=$user','_self')</script>";
                    exit();
                  }
                }
                $Like = "insert into likes (id,Pid,uid) values ('','$Pid','$uid')";
                $like_query = mysqli_query($con,$Like);
                echo"<script>window.open('user_profile.php?uid=$user','_self')</script>";
              }
              if(isset($_POST['unlike'])){
                $Pid = htmlentities($_POST['Pid']);
                $uid= $_SESSION['uid'];
                $query = "select *from likes where Pid = '$Pid'";
                $run = mysqli_query($con,$query);
                while($row = mysqli_fetch_array($run)){
                  $user_id = $row['uid'];
                  if($user_id ==$uid){
                    $delete = "delete from likes where Pid='$Pid' AND uid='$uid'";
                    $delete_query=mysqli_query($con,$delete);
                    echo"<script>window.open('user_profile.php?uid=$user','_self')</script>";
                  }
                }
              }
              if(isset($_POST['cancel'])){
                cancel_request($requestId);
              }
              if(isset($_POST['ignore'])){
                ignore_request($requestId,"user_profile.php",$id);
              }
              if(isset($_POST['confirm'])){
                confrim_request($requestId,"user_profile.php",$id);
              }
               ?>
            </div>
       </div>
    </div>
  <?php } ?>
  </body>
</html>
