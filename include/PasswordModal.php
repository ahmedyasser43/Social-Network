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

        $("#PasswordModal").modal('show');

    });

</script>
  </head>
  <body>
    <div id="PasswordModal" class="modal" role="dialog" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Reset Password</h4>
          </div>
          <div class="modal-body">
            <?php
                if(isset($_GET['uid'])){
                  $uid=$_GET['uid'];
                }
                $query = "select * from users where uid='$uid'";
                $run = mysqli_query($con,$query);
                $row = mysqli_fetch_array($run);
                ?>
                      <div class = "row">
                              <div class="row">
                                  <div class="col-sm-2">
                                  </div>
                                  <div class="col-sm-8">
                                      <form method="post" action="">
                                          <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="password" type="password" class="form-control" placeholder="New Password" name="password" required="required">
                                          </div><br>
                                          <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input id="confirm_password" type="password" class="form-control" placeholder="Confirm Password" name="confirm-password" required="required">
                                          </div><br>
                                    <!-- </form> -->
                                  </div><br><br>
                                  <div class="col-sm-2">
                                  </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-2">
                                </div>
                                  <div class="col-sm-2">
                                    <button class="btn btn-default" type="submit" name="update_password"style="width:150px;">Update Password</button><br><br>
                                  </div>
                                  <div class="col-sm-4">
                                  </div>
                                  <div class="col-sm-2">
                                      <!-- <form action="" method="post"> -->
                                      <a href="/Social_Network/<?php echo "edit_profile.php?uid=$uid"; ?>" style =text-decoration:none;cursor:pointer;''><button type="button" class="btn btn-info" >Close</button></a>
                                      </form>
                                  </div>
                                  <div class="col-sm-2">
                                  </div>
                              </div>
                          </div>
                      </div><br><br>
                  <?php
                  if(isset($_POST['update_password'])){
                    $new_password= $_POST['password'];
                    $confirm_password =htmlentities($_POST['confirm-password']);
                    if(strlen($new_password>=8)){
                      if($new_password == $confirm_password){
                        $new_password= sha1($new_password);
                        $update = "update users set upassword = '$new_password' where uid='$uid'";
                        $run = mysqli_query($con,$update);
                        if($run){
                          echo"<script>alert('Password updated')</script>";
                          echo"<script>window.open('/Social_Network/edit_profile.php?uid=$uid','_self')</script>";
                        }
                        else {
                          echo"<script>alert('Error while changing the password!')</script>";
                          echo"<script>window.open('PasswordModal.php?uid=$uid','_self')</script>";
                          exit();
                        }
                      }
                      else{
                        echo"<script>alert('Passwords don't match')</script>";
                        echo"<script>window.open('PasswordModal.php?uid=$uid','_self')</script>";
                        exit();
                      }
                    }
                    else {
                      echo"<script>alert('Password must be longer than 8 characters!')</script>";
                      echo"<script>window.open('PasswordModal.php?uid=$uid','_self')</script>";
                    }
                  }

             ?>
          </div>
          <div class="modal-footer">
            <form class="" action="" method="post" enctype="multipart/form-data">
              <!-- <input class="btn btn-info" type="submit" name="update" style="width:250px;" value="Close"> -->
              <?php
                //   if($page_flag=="user_profile.php"){
                //   echo"
                //   <a href='/Social_Network/$page_flag?uid=$uid' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                //   ";
                // }
                // elseif ($page_flag=="home.php") {
                //   echo"
                //   <a href='/Social_Network/$page_flag' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                //   ";
                // }
                // elseif ($page_flag=="single_post.php") {
                //   echo"
                //   <a href='/Social_Network/$page_flag?Pid=$post_id' style =text-decoration:none;cursor:pointer;''><button type='button' class='btn btn-info' >Close</button></a>
                //   ";
                // }
               ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
