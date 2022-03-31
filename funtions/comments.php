<?php
    $get_Pid = $_GET['Pid'];
    $get_comment="select * from comments where Pid='$get_Pid' ORDER by 1 DESC";
    $run_comments = mysqli_query($con,$get_comment);
    while($row_comments = mysqli_fetch_array($run_comments)){
      $commenter_id = $row_comments['uid'];
      $comment_time = $row_comments['timePosted'];
      $comment_content = $row_comments['Caption'];
      $user = "select * from users where uid=$commenter_id";
      $run_user = mysqli_query($con,$user);
      $row_user = mysqli_fetch_array($run_user);
      $user_name = $row_user['fname'];
      $user_image = $row_user['Profile_picture'];
      echo "
          <div class='row'>
              <div class='col-md-6 col-md-offset-3'>
                  <div class='panel panel-info'>
                      <div class='panel-body'>
                          <div>
                              <h4><strong>$user_name </stong><i>commented</i> at $comment_time</h4>
                              <p class='text-primary' style='margin-left:5px;font-size:20px;'>$comment_content</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      ";
    }
 ?>
