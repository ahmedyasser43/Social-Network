<!DOCTYPE html>
<html>
<head>
  <title>Social Netwrok</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
#signup{
  width: 60%;
  border-radius: 30px;
}
#login{
  width: 60%;
  border-radius: 30px;
  background-color: #6CC644;
  border: 2px solid #6CC644;
  color: #fff;
}
#login:hover{
  width: 60%;
  border-radius: 30px;
  background-color: #6CC644;
  border: 2px solid #6CC644;
  color: #6CC644;
}
.well{
  background-color: #6CC644;
}

.center {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 57%;
  width: 30%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);

}
</style>




<body>

  <div class="row">
    <div class="col-sm-12">
      <div class="well">
	  
        <center><h1 style="color:white;">The Social Netwrok</h1></center>
		
      </div>
    </div>
	
    <div class="center">
			<h2><strong>Get in touch <br> with the whole world </strong></h2><br><br>
			<h4><strong>join Now!</strong></h4>
		
		<form method = "post" action="">
        <button id="signup" class="btn" name="signup">Sign up</button><br><br>
        <?php if(isset($_POST['signup'])){
          echo "<script>window.open('signup.php','_self')</script>";
        }
        ?>
        <button id="login" class="btn" name="login">Login</button>
        <?php if(isset($_POST['login'])){
          echo "<script>window.open('signin.php','_self')</script>";
        }
        ?>
      </form>
		
		
      
    </div>
  </div>
</body> 
</html>
