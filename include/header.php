<?php
    include("connection.php");
    include("funtions/functions.php");
?>
 <nav class="navbar navbar-default">
   <div class="container-fluid">
     <div class="navbar-header">
       <button type="submit" class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-11" data-toggle="collapse">
       <span class="sr-only">Toggle notification</span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span>
       <span class="icon-bar"></span></button>
       <a href="home.php" class="navbar-brand py-0">The Social Network</a>
     </div>
     <div class="collapse navbar-collapse">
       <ul class="nav navbar-nav">
         <?php
              // session_start();
              $user_id = $_SESSION['uid'];
              $get_user = "select * from users where uid='$user_id'";
              $run_user = mysqli_query($con,$get_user);
              $row = mysqli_fetch_array($run_user);
              $user_fname = $row['fname'];
              $user_lname= $row['lname'];
              $user_password = $row['upassword'];
              $user_birthday=$row['birthdate'];
              $user_email=$row['email'];
              $user_country=$row['hometown'];
              $user_gender = $row['gender'];
              $user_image=$row['Profile_picture'];
              $user_cover=$row['cover'];
              $user_mstatus=$row['m_status'];
              $user_privacy=$row['privacy'];
              $user_phone=$row['phone_number'];
              $user_about=$row['about'];
              $recovery_question=$row['recovery_question'];
              $recovery_answer =$row['recovery_answer'];
              $user_posts="select * from posts where posterId='$user_id'";
              $run_posts=mysqli_query($con,$user_posts);
              $posts = mysqli_num_rows($run_posts);
          ?>
          <li>
            <a href='profile.php?<?php echo "email=$user_email"?>'><?php echo"$user_fname";?></a>
          </li>
          <li><a class="navbar-brand py-0" href='home.php'>Home</a></li>
          <li><a class="navbar-brand py-0" href='find_people.php'>Find People</a></li>
          <li><a class="navbar-brand py-0" href='friends.php'>Friends</a></li>
            <li><a class="navbar-brand py-0" href='requests.php'>Requests</a></li>
            <?php
                echo"
                <li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>
                <span><i class='glyphicon glyphicon-chevron-down'></i></span></a>
                <ul class='dropdown-menu'>
                <li>
                <a href='my_post.php?uid=$user_id'>My Posts<span class='badge badge-secondary'>$posts</span></a>
                </li>
                <li>
                <a href='edit_profile.php?uid=$user_id'>Edit Account</a>
                </li>
                <li role='separatot' class='divider'></li>
                <li> <a href='logout.php'>Logout</a></li>
                </ul>
                </li>
                ";
             ?>
             <ul class="nav navbar-nav navbar-right">
               <li class="dropdown">
                 <form class="navbar-form navbar-left" action="results.php" method="get">
                   <div class="form-group" style="float:right;">
                     <input type="text" name="search_query" data-emoji="true" placeholder="search" class="form-control" emoji>
                   </div>
                   <button type="submit" class="btn btn-info"name="search">Search</button>
                 </form>
               </li>
             </ul>
       </ul>
     </div>
   </div>
 </nav>
