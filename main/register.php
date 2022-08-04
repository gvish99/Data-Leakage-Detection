<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<?php require_once("../include.php");?>
</head>
<body class="front-background">
	<?php require_once("../nonactive_menubar.php");?>

<div class="container">
		<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 shadow p-5 mt-5 bg-white">

<?php
require_once("../function/model.php");
if(isset($_POST['register'])){
	$username=$_POST['username'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$cpassword=$_POST['cpassword'];
	$data="<br>";
	if(!empty($username) && !empty($email) && !empty($password) && !empty($cpassword)){
		if($password==$cpassword){
           register($username,$email,$password);
		}
		else{
			$data.="
				<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Password and confirm password are not matched.
</div>
			";
		}
	}
	else{
$data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Please fill up data.
</div>
";
	}
	echo $data;
}

 ?>


					<form action="register.php" method="post">
							<div class="form-group">
									<label for="username">User Name</label>
									<input type="text" name="username" class="form-control">
							</div>

							<div class="form-group">
									<label for="email">Email Id</label>
									<input type="email" name="email" class="form-control">
							</div>

							<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control">
							</div>

							<div class="form-group">
									<label for="cpassword">Confirm Password</label>
									<input type="password" name="cpassword" class="form-control">
							</div>

							<div class="form-group text-center">
									<input type="submit" name="register" value="Sign Up" class="btn btn-primary my-1">
							</div>
					</form>

				</div>
				<div class="col-sm-4"></div>
		</div>
</div>

</body>
</html>
