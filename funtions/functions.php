
  <style>

  #own_posts
{
   margin-bottom:50px;
}

	#pic
{
	position:relative;
	height: 100px;
	bottom: 0;
	width: 100px;
}

	.col-sm-12-N
	{
		margin: auto;
		width:400px;

	}

	.col-sm-6-N
	{
		text-align: center;
	}




  </style>


<?php
    $con =mysqli_connect("localhost","root","","social_network");
    function insertPost(){
      if(isset($_POST['sub'])){
        global $con;
        global $user_id;
        global $user_fname;
        global $user_lname;
        global $user_privacy;
        $content = htmlentities($_POST['content']);
        $upload_image = $_FILES['upload_image']['name'];
        $image_tmp = $_FILES['upload_image']['tmp_name'];
        $random_number= rand(1,100);
        if(strlen($content)>250){
          echo "<script>alert('Please Use 250 or less 250 words!')</script>";
          echo "<script>window.open('home.php','_self')</script>";
        }else  if(strlen($upload_image)>=0 && strlen($content)>= 0){
          if(strlen($upload_image)>=1){
            move_uploaded_file($image_tmp,"imagepost/$upload_image.$random_number");
            $insert = "insert into posts (Pid,privacy,timePosted,image,posterName,caption,posterId) values('','$user_privacy',NOW(),'$upload_image.$random_number','$user_fname $user_lname','$content','$user_id')";
            $run = mysqli_query($con,$insert);
          }
          else{
            $insert = "insert into posts (Pid,privacy,timePosted,image,posterName,caption,posterId) values('','$user_privacy',NOW(),'','$user_fname $user_lname','$content','$user_id')";
            $run = mysqli_query($con,$insert);
          }
            if($run){
              echo "<script>alert('POSTED!!')</script>";
              echo "<script>window.open('home.php','_self')</script>";
            exit();
        }
      }
    }
  }
  function get_posts(){
    global $con;
    $per_page= 4;
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }else{
      $page=1;
    }
    $start_from = ($page-1)*$per_page;
    $get_posts="select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";
    $run_posts = mysqli_query($con,$get_posts);
    while($row_posts = mysqli_fetch_array($run_posts)){
      $Pid = $row_posts['Pid'];
      $uid = $row_posts['posterId'];
      $content = $row_posts['caption'];
      $upload_image = $row_posts['image'];
      $timePosted=$row_posts['timePosted'];
      $user = "select * from users where uid='$uid'";
      global $page_flag;
      $page_flag="home.php";
      $run_user = mysqli_query($con,$user);
      $row_user = mysqli_fetch_array($run_user);
      $fname = $row_user['fname'];
      $lname = $row_user['lname'];
      $privacy = $row_posts['privacy'];
      $profile_picture = $row_user['Profile_picture'];
      $likes = "select * from likes where Pid = '$Pid'";
      $likes_query = mysqli_query($con,$likes);
      $like_counter = 0;
      while($row_likes=mysqli_fetch_array($likes_query)){
        $like_counter++;
      }
      if(strcasecmp($privacy,"private")==0){
        $friendship = "select * from friends where uid = '$uid' AND friendid='$id' OR uid = '$id' AND friendId='$uid'";
        $friend_query  = mysqli_query($con,$friendship);
          if($friend_query){
          if(strlen($content) == 0 && strlen($upload_image)>= 1){
            echo "
                  <div id='own_posts'>
                      <div class='row'>
                          <div class='col-sm-12-N'>
                                <div class='row'>
                                  <div class='col-sm-2'>
                                    <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                  </div>
                                  <div class='col-sm-6-N'>
                                      <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                      <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                  </div>
                                  <div class='col-sm-4'>
                                  </div>
                                </div>
                                <div  class='row'>
                                    <div id='pic' class='col-sm-12-N'>
                                        <img id='posts-img'src='imagepost/$upload_image' style='height:350px; width:350px;'>
                                    </div>
                                </div>
                          </div>
                      </div><br>
                      ";
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
                                ";
                              }
                              else{
                                echo "
                                <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                </div><br><br><br>
                                ";
                              }
                      }
          else if(strlen($content)>=1 && strlen($upload_image)>= 1){
            echo "
                    <div id='own_posts'>
                        <div class='row'>
                            <div class='col-sm-12-N'>
                                  <div class='row'>
                                    <div class='col-sm-2'>
                                      <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                    </div>
                                    <div class='col-sm-6-N'>
                                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                  </div>
                                  <div class='row'>
                                      <div class='col-sm-12-N'>
                                          <p>$content</p>
                                          <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                                      </div>
                                  </div>
                            </div>
                        </div><br>
                        ";
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
                                ";
                              }
                              else{
                                echo "
                                <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                </div><br><br><br>
                                ";
                              }
                      }
          else{
            echo "
                    <div id='own_posts'>
                        <div class='row'>
                            <div class='col-sm-12-N'>
                                  <div class='row'>
                                    <div class='col-sm-2'>
                                      <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                                    </div>
                                    <div class='col-sm-6-N'>
                                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                                    </div>
                                    <div class='col-sm-4'>
                                    </div>
                                  </div>
                                  <div class='row'>
                                      <div class='col-sm-12-N'>
                                          <p>$content</p>
                                      </div>
                                  </div>
                            </div>
                        </div><br>
                        ";
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
                                ";
                              }
                              else{
                                echo "
                                <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                </div><br><br><br>
                                ";
                              }
                          }
                        }
                      }

    elseif(strcasecmp($privacy,"public")==0){
      $get_posts="select * from posts where privacy='public' ORDER by 1 DESC LIMIT $start_from, $per_page";
      $run_posts= mysqli_query($con,$get_posts);
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
                <div id='own_posts' class='col-sm-12-N'>
                      <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                      </div>
                    <div class='row'>
                        <div class='col-sm-12-N'>
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
                                              <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br>
                          </form>
                      </div><br><br><br>
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br>
                          </form>
                      </div><br><br><br>
                              ";
                            }
                    }
        else if(strlen($content)>=1 && strlen($upload_image)>= 1){
          echo "
                <div id='own_posts' class='col-sm-12-N'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12-N'>
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
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                              </div><br><br><br>
                              ";
                            }
                    }
        else{
          echo "
                <div id='own_posts' class='col-sm-12-N'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12-N'>
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
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                              </div><br><br><br>
                              ";
                            }
        }
      }
    }
    if(isset($_POST['like'])){
      $Pid = htmlentities($_POST['Pid']);
      echo $Pid;
      $query = "select *from likes where Pid = '$Pid'";
      $run = mysqli_query($con,$query);
      $uid=$_SESSION['uid'];
      while($row = mysqli_fetch_array($run)){
        $user_id = $row['uid'];
        if($user_id ==$uid){
          echo"<script>window.open('home.php?page=$page','_self')</script>";
          exit();
        }
      }
      $Like = "insert into likes (id,Pid,uid) values ('','$Pid','$uid')";
      $like_query = mysqli_query($con,$Like);
      echo"<script>window.open('home.php','_self')</script>";
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
          echo"<script>window.open('home.php?page=$page','_self')</script>";
        }
      }
    }
    }
    include("pagination.php");
  }
  function single_post(){
    if(isset($_GET['Pid'])){
      global $con;
      $get_Pid=$_GET['Pid'];
      $get_posts = "select * from posts where Pid='$get_Pid'";
      $run_posts = mysqli_query($con,$get_posts);
      $row_posts = mysqli_fetch_array($run_posts);
      $Pid = $row_posts['Pid'];
      $posterId = $row_posts['posterId'];
      $posterName = $row_posts['posterName'];
      $user_name=$posterName;
      $upload_image = $row_posts['image'];
      $content = $row_posts['caption'];
      $timePosted = $row_posts['timePosted'];
      $user = "select * from users where uid='$posterId'";
      $uid = $posterId;
      $run_user = mysqli_query($con,$user);
      $row_user = mysqli_fetch_array($run_user);
      $profile_picture=$row_user['Profile_picture'];
      $fname=$row_user['fname'];
      $lname = $row_user['lname'];
      $user_email = $_SESSION['email'];
      $post= $_GET['Pid'];
      $get_post = "select Pid from posts where Pid = '$post'";
      $run_post= mysqli_query($con,$get_post);
      $row = mysqli_fetch_array($run_post);
      $p_id = $row['Pid'];
      $comments = "select * from comments where Pid='$Pid'";
      $post_id = $_GET['Pid'];
      $likes = "select * from likes where Pid = '$Pid'";
      $likes_query = mysqli_query($con,$likes);
      $like_counter = 0;
      $page_flag="single_post.php";
      while($row_likes=mysqli_fetch_array($likes_query)){
        $like_counter++;
      }
      if($post_id != $p_id){
        echo "<script>alert('ERROR')</script>";
        echo "<script>window.open('home.php','_self')</script>";
      }else {
        if(strlen($content) == 0 && strlen($upload_image)>= 1){
          echo "
                <div class='col-sm-2'>
                </div>
                <div id='own_posts' class-'col-sm-10'>
                      <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                      </div>
                    <div class='row'>
                        <div class='col-sm-4'>
                        </div>
                        <div class='col-sm-8'>
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
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                              </div><br><br><br>
                              ";
                            }
        }
        else if(strlen($content)>=1 && strlen($upload_image)>= 1){
          echo "
                  <div class='col-sm-2'>
                  </div>
                  <div id='own_posts' class-'col-sm-10'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-4'>
                        </div>
                        <div class='col-sm-8'>
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
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                              </div><br><br><br>
                              ";
                            }
        }
        else{
          echo "
                  <div class='col-sm-2'>
                  </div>
                  <div id='own_posts' class-'col-sm-10'>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                        </div>
                        <div class='col-sm-6-N'>
                            <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                            <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                        </div>
                        <div class='col-sm-4'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-4'>
                        </div>
                        <div class='col-sm-8'>
                          <p>$content</p>
                        </div>
                        ";
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
                                  </div><br>
                                  </div><br><br><br>
                              ";
                            }
                            else{
                              echo "
                              <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                              </div><br>
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
          echo"<script>window.open('single_post.php?Pid=$Pid','_self')</script>";
          exit();
        }
      }
      $Like = "insert into likes (id,Pid,uid) values ('','$Pid','$uid')";
      $like_query = mysqli_query($con,$Like);
      echo"<script>window.open('single_post.php?Pid=$Pid','_self')</script>";
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
          echo"<script>window.open('single_post.php?Pid=$Pid','_self')</script>";
        }
      }
    }
    include("comments.php");
    echo"
          <div class='row'>
              <div class='col-md-6 col-md-offset-3'>
                  <div class='panel panel-info'>
                      <div class='panel-body'>
                          <form action='' method='post' class='form-inline'>
                              <textarea placeholder='Write Your Comment' class='pb-cmnt-textarea' name='comment'></textarea>
                              <button class='btn btn-info pull-right' name='reply'>Comment</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
    ";
    if(isset($_POST['reply'])){
      $comment = htmlentities($_POST['comment']);
      if($comment == ""){
        echo "<script>alert('Enter your comment!!')</script>";
        echo "<script>window.open('single_post.php?Pid=$Pid','_self')</script>";
      }else{
        $insert = "insert into comments (commentId,Pid,uid,timePosted,Caption) values('','$Pid','$uid',Now(),'$comment')";
        $run=mysqli_query($con,$insert);
        echo "<script>alert('Your comment added')</script>";
        echo "<script>window.open('single_post.php?Pid=$Pid','_self')</script>";
      }
    }
  }

  function user_posts(){
    global $con;
    global $user_id;
    if(isset($_GET['uid'])){
      $poster_id=$_GET['uid'];
    }
    $page_flag = "my_post.php";
    $get_posts = "select * from posts where posterId='$user_id' ORDER by 1 DESC";
    $run_posts = mysqli_query($con,$get_posts);
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
                    <div class='row'>
                      <div class='col-sm-12-N'>
                          <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                      </div>
                      <div class='col-sm-6-N'>
                          <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                          <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                      </div>
                      <div class='col-sm-4'>
                      </div>
                    </div>
                  </div>
                  <div class='row'>
                      <div class='col-sm-12-N'>
                          <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                      </div>
                  </div><br>
                  <div class='row'>
                  ";
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
                  <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success' name='view'>View</button></a>
                  <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                  <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                  </div>
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
                      <div class='col-sm-6-N'>
                          <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                          <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                      </div>
                      <div class='col-sm-4'>
                      </div>
                  </div>
                  <div class='row'>
                      <div class='col-sm-12-N'>
                          <p>$content</p>
                          <img id='posts-img'src='imagepost/$upload_image' style='height:350px;'>
                      </div>
                  </div><br>
                  <div class='row'>
                  ";
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
                  <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>View</button></a>
                  <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                  <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                  </div>
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
                      <div class='col-sm-6-N'>
                          <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$user_id'>$user_name</a></h3>
                          <h4><small style='color:black;'>Updated a post on<strong>$post_date</strong></small></h4>
                      </div>
                      <div class='col-sm-4'>
                      </div>
                  </div>
                  <div class='row'>
                      <div class='col-sm-2'>
                      </div>
                      <div class='col-sm-6-N'>
                          <p>$content</p>
                      </div>
                      <div class='col-sm-4'>
                      </div>
                  </div><br>
                  <div class='row'>
                  ";
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
                  <a href='single_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-success'>View</button></a>
                  <a href='edit_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-info'>Edit</button></a>
                  <a href='funtions/delete_post.php?Pid=$Pid' style='float:right;'><button class='btn btn-danger'>Delete</button></a><br>
                </div>
              </div><br><br><br>
        ";
      }
      include("funtions/delete_post.php");

    }
  }

  function results(){
    global $con;
    if(isset($_GET['search'])){
      $search_query= htmlentities($_GET['search_query']);
    }
    if(isset($_GET['search_query'])){
      $search_query=$_GET['search_query'];
    }
    $page_flag = "results.php";
    $search_query=$_GET['search_query'];
    $get_user = "select * from users where fname like '%$search_query%' OR email like '%$search_query%' OR lname like '%$search_query%' OR phone_number like '%$search_query%' OR hometown like '%$search_query%'";
    $get_post = "select * from posts where caption like '%$search_query%' OR image like '%$search_query%'";
    $run_user = mysqli_query($con,$get_user);
    $run_posts=mysqli_query($con,$get_post);
    while($row_users=mysqli_fetch_array($run_user)){
      $uid = $row_users['uid'];
      $fname = $row_users['fname'];
      $lname = $row_users['lname'];
      $profile_picture = $row_users['Profile_picture'];
      echo "
          <div class = 'row'>
              <div class='col-sm-2'>
              </div>
              <div class='col-sm-6-N'>
                  <div class='row' id='find_people'>
                      <div class='col-sm-4'>
                          <a href='user_profile.php?uid=$uid'>
                          <img src='users/$profile_picture'width='150px' height='150px' class='img-circle' title='$fname' style = 'float:left; margin:1px;'/>
                          </a>
                      </div><br><br>
                      <div class='col-sm-6-N'>
                          <a href='user_profile.php?uid=$uid' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                          <strong><h2>$fname $lname</h2></strong></a>
                      </div>
                      <div class='col-sm-3'>
                      </div>
                  </div>
              </div>
              <div class='col-sm-4'>
              </div>
          </div><br><br>
      ";
    }
    while($row_posts = mysqli_fetch_array($run_posts)){
      $Pid = $row_posts['Pid'];
      $uid = $row_posts['posterId'];
      $content = $row_posts['caption'];
      $upload_image = $row_posts['image'];
      $timePosted=$row_posts['timePosted'];
      $user = "select * from users where uid='$uid'";
      global $page_flag;
      $page_flag="home.php";
      $run_user = mysqli_query($con,$user);
      $row_user = mysqli_fetch_array($run_user);
      $fname = $row_user['fname'];
      $lname = $row_user['lname'];
      $privacy = $row_posts['privacy'];
      $profile_picture = $row_user['Profile_picture'];
      $likes = "select * from likes where Pid = '$Pid'";
      $likes_query = mysqli_query($con,$likes);
      $like_counter = 0;
      while($row_likes=mysqli_fetch_array($likes_query)){
        $like_counter++;
      }
      if(strcasecmp($privacy,"private")==0){
        $friendship = "select * from friends where uid = '$uid' AND friendid='$id' OR uid = '$id' AND friendId='$uid'";
        $friend_query  = mysqli_query($con,$friendship);
          if($friend_query){
            if(strlen($content) == 0 && strlen($upload_image)>= 1){
              echo "
                    <div id='own_posts' class='col-sm-12-N'>
                          <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6-N'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                          </div>
                        <div class='row'>
                            <div class='col-sm-12-N'>
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
                                                  <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br>
                              </form>
                          </div><br><br><br>
                                  ";
                                }
                                else{
                                  echo "
                                  <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br>
                              </form>
                          </div><br><br><br>
                                  ";
                                }
                        }
            else if(strlen($content)>=1 && strlen($upload_image)>= 1){
              echo "
                    <div id='own_posts' class='col-sm-12-N'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6-N'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12-N'>
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
                                  ";
                                }
                                else{
                                  echo "
                                  <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                  </div><br><br><br>
                                  ";
                                }
                        }
            else{
              echo "
                    <div id='own_posts' class='col-sm-12-N'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6-N'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                                <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12-N'>
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
                                  ";
                                }
                                else{
                                  echo "
                                  <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                                  </div><br><br><br>
                                  ";
                                }
            }
                        }
                      }

elseif(strcasecmp($privacy,"public")==0){
  $get_posts = "select * from posts where caption like '%$search_query%' OR image like '%$search_query%' AND privacy='Public'";
  $run_posts= mysqli_query($con,$get_posts);
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
            <div id='own_posts' class='col-sm-12-N'>
                  <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6-N'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                  </div>
                <div class='row'>
                    <div class='col-sm-12-N'>
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
                                          <button style='float:left;' class='btn btn-info' type='submit' name='unlike' value='$Pid'>Liked</button><br>
                      </form>
                  </div><br><br><br>
                          ";
                        }
                        else{
                          echo "
                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br>
                      </form>
                  </div><br><br><br>
                          ";
                        }
                }
    else if(strlen($content)>=1 && strlen($upload_image)>= 1){
      echo "
            <div id='own_posts' class='col-sm-12-N'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6-N'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12-N'>
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
                          ";
                        }
                        else{
                          echo "
                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                          </div><br><br><br>
                          ";
                        }
                }
    else{
      echo "
            <div id='own_posts' class='col-sm-12-N'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$profile_picture' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6-N'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0;'href='user_profile.php?uid=$uid'>$fname $lname</a></h3>
                        <h4><small style='color:black;'>Updated a post on<strong>$timePosted</strong></small></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12-N'>
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
                          ";
                        }
                        else{
                          echo "
                          <button style='float:left;' class='btn btn-info' type='submit' value='$Pid' name='like'>Like</button><br></form>
                          </div><br><br><br>
                          ";
                        }
    }
  }
}
}
    if(isset($_POST['like'])){
      $Pid = htmlentities($_POST['Pid']);
      echo $Pid;
      $query = "select *from likes where Pid = '$Pid'";
      $run = mysqli_query($con,$query);
      while($row = mysqli_fetch_array($run)){
        $user_id = $row['uid'];
        if($user_id ==$uid){
          echo"<script>window.open('home.php','_self')</script>";
          exit();
        }
      }
      $Like = "insert into likes (id,Pid,uid) values ('','$Pid','$uid')";
      $like_query = mysqli_query($con,$Like);
      echo"<script>window.open('home.php','_self')</script>";
    }
  }
  function search_friends(){
    global $con;
    if(isset($_GET['search_btn'])){
      $search_query = htmlentities($_GET['search_user']);
      $get_user = "select * from users where fname like '%$search_query%' OR lname like '%$search_query%' OR phone_number like '%$search_query%' OR hometown like '%$search_query%'";
    }
    else{
      $get_user = "select * from users";
      // $get_post = "select * from posts";
    }
    $run_user = mysqli_query($con,$get_user);
    // $run_post = mysqli_query($con,$get_post);
    while($row_user = mysqli_fetch_array($run_user)){
      $uid = $row_user['uid'];
      $fname = $row_user['fname'];
      $lname = $row_user['lname'];
      $profile_picture = $row_user['Profile_picture'];
      echo "
          <div class = 'row'>
              <div class='col-sm-3'>
              </div>
              <div class='col-sm-6-N'>
                  <div class='row' id='find_people'>
                      <div class='col-sm-4'>
                          <a href='user_profile.php?uid=$uid'>
                          <img src='users/$profile_picture' class='img-circle' width='150px' height='150px' title='$fname' style = 'float:left; margin:1px;'/>
                          </a>
                      </div><br><br>
                      <div class='col-sm-6-N'>
                          <a href='user_profile.php?uid=$uid' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                          <strong><h2>$fname $lname</h2></strong></a>
                      </div>
                      <div class='col-sm-3'>
                      </div>
                  </div>
              </div>
              <div class='col-sm-4'>
              </div>
          </div><br><br>
      ";
    }
    // $row_post = mysqli_fetch_array($run_post);
  }

  function get_requests(){
    global $con;
    $user = $_SESSION['email'];
    $get_user = "select uid from users where email='$user'";
    $query= mysqli_query($con,$get_user);
    $row_user = mysqli_fetch_array($query);
    $uid = $row_user['uid'];
    $request="select * from requests where receiverId='$uid'";
    $get_request=mysqli_query($con,$request);
    while($row_request = mysqli_fetch_array($get_request)){
      $senderId = $row_request['senderId'];
      $requestId = $row_request['requestId'];
      $sender = "select * from users where uid='$senderId'";
      $get_sender=mysqli_query($con,$sender);
      $row_sender=mysqli_fetch_array($get_sender);
      $senderid = $row_sender['uid'];
      $fname = $row_sender['fname'];
      $lname = $row_sender['lname'];
      $profile_picture = $row_sender['Profile_picture'];
      echo "
          <div class = 'row'>
              <div class='col-sm-3'>
              </div>
              <div class='col-sm-6-N'>
                  <div class='row' id='find_people'>
                      <div class='col-sm-3'>
                          <a href='user_profile.php?uid=$senderId'>
                            <img src='users/$profile_picture' class='img-circle' width='150px' height='150px' title='$fname' class='img-circle' style = 'float:left; margin:1px;'/>
                          </a>
                      </div><br><br>
                      <div class='col-sm-3'>
                          <a href='user_profile.php?uid=$senderId' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                          <strong><h2>$fname $lname</h2></strong></a>
                      </div>
                      <div class='col-sm-2'>
                          <form method='post'>
                          <input type = 'hidden' value = '$requestId' name='requestId'>
                          <button class='btn btn-success' name='confirm'>Confirm</button>
                      </div>
                          <input type = 'hidden' value = '$requestId' name='requestId'>
                          <button class='btn btn-danger' name='ignore'>Ignore</button>
                          </form>
                      <div class='col-sm-2'>
                      </div>
                  </div>
              </div>
              <div class='col-sm-4'>
              </div>
          </div><br><br>
      ";
    }
    if(isset($_POST['ignore'])){
      $requestId = $_POST['requestId'];
      ignore_request($requestId,"/Social_Network/requests.php","");
    }
    if(isset($_POST['confirm'])){
      $requestId = $_POST['requestId'];
      confrim_request($requestId,"/Social_Network/requests.php","");
    }
  }

  function get_friends(){
    global $con;
    $user = $_SESSION['email'];
    $get_user = "select * from users where email='$user'";
    $run_user = mysqli_query($con,$get_user);
    $row_user = mysqli_fetch_array($run_user);
    $user_id = $row_user['uid'];
    $friends_query = "select * from friends where uid='$user_id' OR friendId='$user_id'";
    $run_query = mysqli_query($con,$friends_query);
    while($row=mysqli_fetch_array($run_query)){
      $uid = $row['uid'];
      $friend_id = $row['friendId'];
      if($user_id==$uid){
        $query = "select * from users where uid='$friend_id'";
        $run = mysqli_query($con,$query);
        $row_friend=mysqli_fetch_array($run);
        $fname = $row_friend['fname'];
        $lname = $row_friend['lname'];
        $profile_picture = $row_friend['Profile_picture'];
        echo "
            <div class = 'row'>
                <div class='col-sm-3'>
                </div>
                <div class='col-sm-6-N'>
                    <div class='row' id='find_people'>
                        <div class='col-sm-4'>
                            <a href='user_profile.php?uid=$friend_id'>
                            <img src='users/$profile_picture' class='img-circle' width='150px' height='150px' title='$fname' style = 'float:left; margin:1px;'/>
                            </a>
                        </div><br><br>
                        <div class='col-sm-6-N'>
                            <a href='user_profile.php?uid=$friend_id' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                            <strong><h2>$fname $lname</h2></strong></a>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div>
                </div>
                <div class='col-sm-4'>
                </div>
            </div><br><br>
        ";
      }elseif ($friend_id==$user_id) {
        $query = "select * from users where uid='$uid'";
        $run = mysqli_query($con,$query);
        $row_friend=mysqli_fetch_array($run);
        $fname = $row_friend['fname'];
        $lname = $row_friend['lname'];
        $profile_picture = $row_friend['Profile_picture'];
        echo "
            <div class = 'row'>
                <div class='col-sm-3'>
                </div>
                <div class='col-sm-6-N'>
                    <div class='row' id='find_people'>
                        <div class='col-sm-4'>
                            <a href='user_profile.php?uid=$uid'>
                            <img src='users/$profile_picture'class='img-circle' width='150px' height='150px' title='$fname' style = 'float:left; margin:1px;'/>
                            </a>
                        </div><br><br>
                        <div class='col-sm-6-N'>
                            <a href='user_profile.php?uid=$uid' style ='text-decoration:none;cursor:pointer;color:#3897f0;'>
                            <strong><h2>$fname $lname</h2></strong></a>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div>
                </div>
                <div class='col-sm-4'>
                </div>
            </div><br><br>
        ";
      }
    }
  }

  function cancel_request($requestId){
    global $con;
    $query = "select receiverId from requests where requestId='$requestId'";
    $run = mysqli_query($con,$query);
    $uid= mysqli_fetch_array($run);
    $delete = "delete from requests where requestId='$requestId'";
    $delete_request = mysqli_query($con,$delete);
    echo "sssssssssssssssssssssssssssssssssssssssssss";
    if($delete_query){
      echo "kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk";
      echo"<script>alert('Request Canceled')</script>";
        echo "<script>window.open('user_profile?uid=$uid','_self')</script>";
    }
  }

  function ignore_request($requestId,$page,$uid){
    global $con;
    $delete = "delete from requests where requestId='$requestId'";
    $delete_query = mysqli_query($con,$delete);
    if($delete_query){
      echo"<script>alert('Request Deleted')</script>";
      if($uid==""){
        echo "<script>window.open('$page','_self')</script>";
        exit();
      }
        echo "<script>window.open('$page/uid=$uid','_self')</script>";
    }
  }
  function confrim_request($requestId,$page,$uid){
    global $con;
    $request_query = "select * from requests where requestId='$requestId'";
    $run= mysqli_query($con,$request_query);
    $row = mysqli_fetch_array($run);
    $receiverId = $row['receiverId'];
    $senderId = $row['senderId'];
    $friend_query = "insert into friends (id,uid,friendId) values ('','$receiverId','$senderId')";
    $get_query = mysqli_query($con,$friend_query);
    $delete = "delete from requests where requestId='$requestId'";
    $delete_query = mysqli_query($con,$delete);
    if($delete_query){
      echo"<script>alert('Request Accepted')</script>";
      if($uid==""){
        echo "<script>window.open('$page','_self')</script>";
        exit();
      }
        echo "<script>window.open('$page/uid=$uid','_self')</script>";
    }
  }
?>
