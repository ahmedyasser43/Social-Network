<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <title>Sign in</title>

	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </head>
  <style>
	body{
		overflow-x: hidden;
	}
	.main-content{
		width: 50%;
		height: 40%;
		margin: 10px auto;
		background-color: #fff;
		border: 2px solid #e6e6e6;
		padding: 40px 50px;

	}
	.header{
		border: 0px solid #000;
		margin-bottom: 5px;

	}
	.well{
		background-color: #6CC644;
	}
	.signin{
		width: 60%;
		border-radius: 30px;
		background-color: #6CC644;
	}
	.overlap-text{
		position: relative;
		background-color: #6CC644;
	}
	.overlap-text a{
		position: absolute;
		top: 45px;
		right: 12px;
		font-size: 14px;
		text-decoration: none;
		font-family: 'Overpass Mono', monospace;
		letter-spacing: -1px;


	}
</style>



  <body>
    <div class="row">
      <div class="col-sm-12">
        <div class="well" style="background-color:#6CC644;">
          <center><h1 style="color:white;">The Social Network</h1></center>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="main-content">
          <div class="header">
            <h3 style="text-align: center;"><strog>Login to The Social Network</strong></h3>
          </div>
          <div class="l-part">
            <form action="login.php" method="post">
              <div class="col-sm-6">
                <input type="email" name="email" placeholder="Email" required class="form-control input-md"><br>
              </div>
              <div class="overlap-text">
                <div class="col-sm-6">
                  <input type="password" name="password" placeholder="Password" required class="form-control input-md"><br>
                  <a style="float:right; color: #6CC644" title="Reset Password"href="email.php">Forgot Password?</a>
                </div>
              </div>
              <center><input type="submit"class="btn btn-info btn-lg" style=" background-color:#6CC644; border: 2px solid #6CC644; border-radius:30px;width: 60%;" name="submit" value="Login"></center>
               <?php include("login.php"); ?>
            </form>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
