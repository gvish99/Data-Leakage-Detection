<?php 
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Dashboard- Leakage Files</title>
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
        <div class="col-sm-6">
        	
             <?php 
             require_once("../function/user_model.php");
             leakage_file();
             ?>

        </div>
        <div class="col-sm-3"></div>
	 </div>
	</div>

</body>
</html>