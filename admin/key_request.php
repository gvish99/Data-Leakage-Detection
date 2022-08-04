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
	<title>Admin Dashboard- Key Request</title>
	<?php 
require_once("../include.php");
	 ?>
</head>
<body>
	<?php 
require_once("../admin_menubar.php");
	 ?>

	 <div class="container-fluid">
	 	<div class="row">
			<div class="col-sm-3">
				
				<?php 
require_once("../admin_side_menubar.php");
				 ?>
			</div>
			<div class="col-sm-6">
				<?php 
require_once("../function/distributor_model.php");

 if(isset($_POST['share_key'])){
 	$fileid=$_POST['fileid'];
 	     share_key($fileid);
 }
 
 if(isset($_POST['decline'])){
     $fileid=$_POST["fileid"];
     $requestby=$_POST["requestby"];
     decline($fileid,$requestby);
 }
 

key_request();

				 ?>
				
			</div>
			<div class="col-sm-3"></div>
	 </div>
	</div>

</body>
</html>