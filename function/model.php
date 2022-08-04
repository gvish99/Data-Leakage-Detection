<?php
require_once("connect.php");
$conn=connect();

function register($username,$email,$password){
	global $conn;
$data="<br>";

$sql="SELECT * FROM user WHERE email='$email'";
$result=mysqli_query($conn,$sql);
if($result){
       if(mysqli_num_rows($result)>0){
           $data.="
			<div class='alert alert-info'>
				<strong>Failed:</strong>
				This email id already exist.
			</div>
           ";
       }
       else{
               $date_time=date("Y-m-d");
       		$sql1="INSERT INTO user(username,email,password,date_time)VALUES('$username','$email','$password','$date_time')";
       		$result1=mysqli_query($conn,$sql1);
       		if($result1){
$data.="
<div class='alert alert-success'>
		<strong>Success:</strong>
		Successfully Registered.
</div>
";
       		}
       		else{
       				$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror
</div>
       				";
       		}

       }
}
else{
$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror
</div>
";
}
echo $data;
}

function login($email,$password){
	global $conn;
$data="<br>";

$sql="SELECT * FROM user WHERE email='$email' AND password='$password'";
$result=mysqli_query($conn,$sql);
if($result){
       if(mysqli_num_rows($result)>0){
                       while($rows=mysqli_fetch_array($result)){
                       	$userid=$rows['userid'];
                       	$username=$rows['username'];
                       	$usertype=$rows['usertype'];
                       	$admin_active=$rows['admin_active'];
if($admin_active=="0"){
	$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		You registeration in review to admin. it will activated by admin very soon.
</div>
";
}
else if($admin_active=="1"){
	    session_start();
	    $_SESSION['usertype']=$usertype;
	    $_SESSION['userid']=$userid;
	    if($usertype=="user"){
	    		$url="../user/user_dashboard.php";
	    }
	    else if($usertype=="admin"){
$url="../admin/admin_dashboard.php";
	    }
	    else if($usertype=="distributor"){
	$url="../distributor/distributor_dashboard.php";
}
	    header("Location:$url");
	    exit();
}




                       }
       }
       else{
       	$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		This email id not registered yet.
</div>
";
       }
}
else{
	$error=mysqli_error($conn);
$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror:$error
</div>
";
}
echo $data;
}

function forget_password($email){
	global $conn;
	$data="<br>";
$sql="SELECT * FROM user WHERE email='$email' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   if(mysqli_num_rows($result)>0){

            while($rows=mysqli_fetch_array($result)){
            	$password=$rows['password'];
            	$data.="
<div class='alert alert-success'>
		<strong>Password Recovered Successfully:</strong>
		$password
</div>
            	";
            }
   }
   else{
$data.="
<div class='alert alert-info'>
		<strong>Failed:</strong>
		Invalid email id.
</div>
";
   }
}
else{
$error=mysqli_error($conn);
$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror:$error
</div>
";
}
echo $data;
}

function get_profile($userid){
	global $conn;
$data="<br>";

$sql="SELECT * FROM user WHERE userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
     if(mysqli_num_rows($result)>0){

        while($rows=mysqli_fetch_array($result)){
        	$userid=$rows['userid'];
        	$username=$rows['username'];
        	$password=$rows['password'];
        }

$data.="
<br>
 <center><h3>Edit Profile</h3></center>
<form action='edit_profile.php' method='post'>
  <div class='form-group'>
  <input type='hidden' name='userid' value='$userid'>
									<label for='username'>User Name</label>
		<input type='text' name='username' class='form-control' value='$username'>
							</div>

							<div class='form-group'>
									<label for='password'>Password</label>
				<input type='text' name='password' class='form-control' value='$password'>
							</div>

							<div class='form-group'>
									<label for='cpassword'>Confirm Password</label>
									<input type='text' name='cpassword' class='form-control'>
							</div>

							<div class='form-group'>
									<center><input type='submit' name='edit_profile' value='Save Changes' class='btn btn-primary my-3'></center>
							</div>
</form>
";



     }
     else{
$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		No record found
</div>
";
     }
}
else{
 	$error=mysqli_error($conn);
$data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror:$error
</div>
";
}
echo $data;
}


function save_changes($userid,$username,$password){
	 global $conn;
	 $data="<br>";
$sql="UPDATE user SET username='$username',password='$password' WHERE userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
       $data.="
<div class='alert alert-success'>
		<strong>Success:</strong>
		Successfully updated.
</div>
";
}
else{
	$error=mysqli_error($conn);
 $data.="
<div class='alert alert-danger'>
		<strong>Failed:</strong>
		dberror:$error
</div>
";
}
	 echo $data;
}


 ?>
