<?php 
require_once("connect.php");
$conn=connect();

function load_user_request(){
	$data="<br>";
global $conn;

$sql="SELECT * FROM user WHERE usertype='user' OR usertype='distributor' ORDER BY userid DESC";
$result=mysqli_query($conn,$sql);
if($result){
       if(mysqli_num_rows($result)>0){
       			$data.="
<table class='table table-bordered'>
<thead>
  <tr>
		<th>Sr No</th>
		<th>User Name</th>
		<th>Email Id</th>
		<th>Activate account</th>		
  </tr>
</thead>
<tbody>
       			";
$i=0;
       				while($rows=mysqli_fetch_array($result)){
       					$i++;
       					$userid=$rows['userid'];
       					$username=$rows['username'];
       					$email=$rows['email'];
       					$admin_active=$rows['admin_active'];
       					$usertype=$rows['usertype'];

if($admin_active=="0"){
$admin="
<form action='user_request.php' method='post'>
		<input type='hidden' name='userid' value='$userid'>
		<input type='submit' name='activate' value='Activate' class='btn btn-success'>
</form>
";
}
else{
	$admin="
<form action='user_request.php' method='post'>
		<input type='hidden' name='userid' value='$userid'>
		<input type='submit' name='deactivate' value='Deactivate' class='btn btn-danger'>
</form>
	";
}





$data.="
<tr>
<td>$i</td>
<td>$username</td>
<td>$email</td>
<td>$admin</td>
</tr>
";


       				}

$data.="</tbody></table>";

       }
       else{
       	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>No request found
</div>
       	";
       }
}
else{
	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>dberror
</div>
	";
}

	echo $data;
}


function activate_user($userid,$action){
	$data="<br>";
	global $conn;
$sql="UPDATE user SET admin_active='1' WHERE admin_active='0' AND userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   $data.="
<div class='alert alert-success'>
<strong>Success:</strong>Activate
</div>
	";
}
else{
	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>dberror
</div>
	";
}
	echo $data;
}


function deactivate_user($userid,$action){
	$data="<br>";
	global $conn;
$sql="UPDATE user SET admin_active='0' WHERE admin_active='1' AND userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   $data.="
<div class='alert alert-success'>
<strong>Success:</strong>Deactivate
</div>
	";
}
else{
	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>dberror
</div>
	";
}
	echo $data;
}


function create_user($userid,$action){
	$data="<br>";
	global $conn;
$sql="UPDATE user SET usertype='user' WHERE userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   $data.="
<div class='alert alert-success'>
<strong>Success:</strong> Updated to user
</div>
	";
}
else{
	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>dberror
</div>
	";
}
	echo $data;
}


function create_distributor($userid,$action){
	$data="<br>";
	global $conn;
$sql="UPDATE user SET usertype='distributor' WHERE userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   $data.="
<div class='alert alert-success'>
<strong>Success:</strong> Updated to distributor
</div>
	";
}
else{
	$data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>dberror
</div>
	";
}
	echo $data;
}

 ?>