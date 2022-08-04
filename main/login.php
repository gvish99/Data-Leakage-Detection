<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php require_once("../include.php");?>
</head>
<body class="front-background">
	<?php require_once("../nonactive_menubar.php");?>

<div class="container">
		<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 shadow-sm p-5 mt-5 bg-white">

<?php
require_once("../function/model.php");
if(isset($_POST['login'])){
  $email=$_POST['email'];
  $password=$_POST['password'];
  $data="<br>";

  if(!empty($email) && !empty($password)){
           login($email,$password);
}
else{
	$data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Please fill up data
</div>
	";
}

  echo $data;
}
?>


					<form action="login.php" method="post">


							<div class="form-group">
									<label for="email">Email Id</label>
									<input type="text" name="email" class="form-control">
							</div>

							<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control">
							</div>


							<div class="form-group">
		<center>
			<input type="submit" name="login" value="Sign In" class="btn btn-primary my-1">
									</center>

									<a href="forget.php">Forget Password?</a>

							</div>
					</form>
					<br>

					<!--<div class="card">
								<div class="card-body">
<i><b>Note:</b> Password may be changed, try to forget password using given email id below.</i><hr color="red">

						Admin:  <br>
						email: admin@gmail.com  <br>
						password: 12345 <hr color="red">

						Distributor: <br>
						email: distributor@gmail.com <br>
						password: 12345 <hr color="red">

						User: <br>
						<strong>user1</strong><br>
						email: user1@gmail.com <br>
						password: 12345 <br>

						<strong>user2</strong><br>
						email: user2@gmail.com <br>
						password: 12345
					</div></div>-->

				</div>
				<div class="col-sm-4"></div>
		</div>
</div>

</body>
</html>
