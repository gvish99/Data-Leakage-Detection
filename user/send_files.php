<?php
session_start();
if($_SESSION['usertype']=="user"){

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
	<title>User Dashboard- Send Files</title>
	<?php
require_once("../include.php");
	 ?>
</head>
<body>
	<?php
require_once("../user_menubar.php");
	 ?>

	 <div class="container-fluid">
	 	<div class="row">
			<div class="col-sm-3">

				<?php


require_once("../user_side_menubar.php");



				 ?>
			</div>
			<div class="col-sm-9 shadow-sm p-5 mt-5 bg-white">
				<br>
				<center><h2>Send Files to Selected user</h2></center>
<?php
require_once("../function/distributor_model.php");
     if(isset($_POST['send_file'])){
     	$userid=$_POST['userid'];
     	$senderid=$_SESSION['userid'];
     	$subject=$_POST['subject'];

     	$filename=$_FILES['file']['name'];
     	$file_tmpname=$_FILES['file']['tmp_name'];
     	$filesize=$_FILES['file']['size']/(1024*1024);
     	$url="../files/$filename";
$data="";

if(!empty($subject) && !empty($filename) && !empty($userid))
{
     	if($filesize>10){
$data.="
<div class='alert alert-warning'>
<strong>Failed:</strong>
File size must be less than 10 mb.
</div>
";
     	}
     	else{
     		$secretkey=mt_rand(1000,9999);
    send_files($subject,$filename,$filesize,$senderid,$userid,$secretkey,$url,$file_tmpname);
     	}
}
else{
	$data.="
<div class='alert alert-warning'>
<strong>Failed:</strong>
Fill up data
</div>
	";
}
echo $data;
     }
 ?>


				<form action="send_files.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
								<label for="user">Select User</label>
<?php get_user();?>
						</div>


						<div class="form-group">
								<label for="subject">Subject</label>
								<input type="text" name="subject" class="form-control">
						</div>

						<div class="form-group">
							<label for="file">File</label>
							<input type="file" name="file" class="form-control">
						</div>

						<div class="form-group">
							<center><input type="submit" name="send_file" value="Send" class="my-2 btn btn-primary"></center>
						</div>
				</form>


			</div>
	 </div>
	</div>

</body>
</html>
