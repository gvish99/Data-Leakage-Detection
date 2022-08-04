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
	<title>Admin Dashboard- Distributor Files (Send By)</title>
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
        	<br>
    	<center><h3>Admin Dashboard/ Files (Send By others)</h3></center>    	
	<?php
	require_once("../function/user_model.php");

if(isset($_POST['send_request'])){
       $requestby=$_POST['requestby'];
       $requestto=$_POST['requestto'];
       $fileid=$_POST['fileid'];
       $askkey=$_POST['askkey'];
       $request_label=$_POST['request_label'];
       $date_time=date("Y-m-d H:i:s");
       send_request($requestby,$requestto,$fileid,$askkey,$request_label,$date_time);
}

if(isset($_POST['share'])){
	$fileid=$_POST['fileid'];
	$userid=$_POST['userid'];
	$secretkey=$_POST['secretkey'];
	$subject=$_POST['subject'];
	$date_time=date("Y-m-d H:i:s");
	share_file($userid,$subject,$fileid,$secretkey,$date_time);
}

if(isset($_POST['share_others'])){
    $userid=$_POST["userid"];
    $fileid=$_POST["fileid"];
    if(!empty($userid)){
    share_with_others($userid,$fileid);
    }
    else{
        echo "<div class='alert alert-danger'>please select user</div>";
    }
}

	$userid=$_SESSION['userid'];
	get_distributor_send_files($userid);
?>
        </div>
        <div class="col-sm-3"></div>
	 </div>
	</div>

</body>
</html>