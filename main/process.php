<?php 
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Dashboard</title>
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
        	
        </div>
        <div class="col-sm-6"><br>
	
	<?php 
	require_once("../function/user_model.php");
                 if(isset($_POST['download'])){
                 	$data="<br>";
$fileid=$_POST['fileid'];
$secretkey=$_POST['secretkey'];
  if(!empty($fileid) && !empty($secretkey)){
              $x=proceed_download($fileid,$secretkey);

  }
  else{
  	 $data.="<div class='alert alert-danger'>
  	 <strong>Failed:</strong>
  	 Fill up data
</div>
  	 ";
  }
  echo $data;
                 }
	 ?>

	 <form action="process.php?fileid=<?php echo $_GET['fileid'];?>" method="post">
	 	<div class="form-group">
				<label for="secretkey">Enter Secret key to download File</label>
				<input type='hidden' name='fileid' value="<?php if(isset($_GET['fileid'])){echo $_GET['fileid'];}?>">
				<input type="text" name="secretkey" value="" class="form-control">
	 	</div>

	 	<div class="form-group">
	 		<input type="submit" name="download" value='Download' class='btn btn-primary'>
	 	</div>
	 </form>

        </div>
        <div class="col-sm-3"></div>
	 </div>
	</div>

</body>
</html>