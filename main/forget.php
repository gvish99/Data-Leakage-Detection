<!DOCTYPE html>
<html>
<head>
	<title>Forget Password</title>
	<?php require_once("../include.php");?>
</head>
<body>
	<?php require_once("../nonactive_menubar.php");?>

<div class="container">
		<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 shadow-sm p-5 mt-5 bg-white">

<?php
require_once("../function/model.php");
if(isset($_POST['forget'])){
  $email=$_POST['email'];
  $data="<br>";

  if(!empty($email)){
           forget_password($email);
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

					<br>
					<form action="forget.php" method="post">


							<div class="form-group">
									<label for="email">Email Id</label>
									<input type="text" name="email" class="form-control">
							</div>


							<div class="form-group">
		<center>
			<input type="submit" name="forget" value="Recover Password" class="btn btn-primary my-2">
									</center>



							</div>
					</form>
					<br>

				</div>
				<div class="col-sm-4"></div>
		</div>
</div>

</body>
</html>
