<?php 
session_start();
if($_SESSION['usertype']=="admin"){
    
}
else{
    $url="../index.php";
    header("Location:$url");
    exit();
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard- User Request</title>
	<?php require_once("../include.php");?>
</head>
<body>
	<?php require_once("../admin_menubar.php");?>

	<div class="container-fluid">
			<div class="row">
					<div class="col-sm-3">
						<?php 
							require_once("../admin_side_menubar.php");
						?>
					</div>
					<div class="col-sm-6">
						  <?php 
										require_once("../function/admin_model.php");

  if(isset($_POST['activate'])){
  $userid=$_POST['userid'];
  $action="activate";
     activate_user($userid,$action);
}
else if(isset($_POST['deactivate'])){
	  $userid=$_POST['userid'];
	  $action="deactivate";
	  deactivate_user($userid,$action);
}


  if(isset($_POST['usertype_user'])){
  $userid=$_POST['userid'];
  $action="user";
     create_user($userid,$action);
}
else if(isset($_POST['usertype_distributor'])){
	  $userid=$_POST['userid'];
	  $action="distributor";
	  create_distributor($userid,$action);
}

										load_user_request();
						  ?>

					</div>
					<div class="col-sm-3"></div>
			</div>
	</div>

</body>
</html>