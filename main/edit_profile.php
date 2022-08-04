<?php
 session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
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

if(isset($_POST['edit_profile'])){
		$userid=$_POST['userid'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$cpassword=$_POST['cpassword'];
		$data="<br>";
		if(!empty($username) && !empty($password) && !empty($cpassword)){
           if($password ==$cpassword){
                   save_changes($userid,$username,$password);
           }
           else{
$data.="<div class='alert alert-danger'>
<strong>Failed:</strong>
Password and confirm password are not same.
</div>
";
           }
		}
		else{
$data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Fill up data.
</div>
";
		}
		echo $data;
}

        get_profile($_SESSION['userid']);
        ?>




				</div>
				<div class="col-sm-4"></div>
		</div>
</div>

</body>
</html>
