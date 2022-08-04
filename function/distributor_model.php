<?php
require_once("../function/connect.php");
$conn=connect();


function send_files($subject,$filename,$filesize,$senderid,$userid,$secretkey,$url,$file_tmpname){

    $filename=md5(mt_rand(1,10000))."-".$filename;
    $url="../files/$filename";

$date_time=date("Y-m-d H:i:s");
global $conn;
$data="<br>";
$sql="INSERT INTO data_file(
subject,
filename,
filesize,
senderid,
userid,
secretkey,
date_time
)VALUES
(
  '$subject',
  '$filename',
  '$filesize',
  '$senderid',
  '$userid',
  '$secretkey',
  '$date_time'
)
";

$result=mysqli_query($conn,$sql);
if($result){

if(move_uploaded_file($file_tmpname,$url)){
$data.="
<div class='alert alert-success'>
 <strong>Success:</strong>
 File Successfully send.
</div>
";
}
else{
    $sql1="DELETE FROM send_files WHERE filename='$filename' AND userid='$userid' AND date_time='$date_time' LIMIT 1";
    $resutl1=mysqli_query($conn,$sql1);
    if($result1){
         $data.="
<div class='alert alert-success'>
 <strong>Failed:</strong>
 File upload failed:
</div>
";
    }
    else{
        	$error=mysqli_error($conn);
$data.="
<div class='alert alert-success'>
 <strong>Failed:</strong>
 dberror: $error
</div>
";
    }
}

}
else{
	$error=mysqli_error($conn);
$data.="
<div class='alert alert-success'>
 <strong>Failed:</strong>
 dberror: $error
</div>
";
}

echo $data;
}

function get_user(){
$data="";
global $conn;
$self=$_SESSION['userid'];
$sql="SELECT * FROM user WHERE admin_active='1' AND userid<>'$self' ORDER BY userid ASC";
$result=mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result)>0){

           $data.="<select name='userid' class='form-control'>
					<option></option>
           ";

           	while($rows=mysqli_fetch_array($result)){
           		$userid=$rows['userid'];;
           		$username=$rows['username'];
           		$data.="<option value='$userid'>$username</option>";
           	}

           $data.="</select>";
    }
    else{
    $data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>
not found
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

function key_request(){
$data="<br>";
global $conn;
$self=$_SESSION['userid'];
$sql="SELECT * FROM request WHERE requestto='$self'";
$result=mysqli_query($conn,$sql);
if($result){
     if(mysqli_num_rows($result)>0){
           $data.="
<table class='table table-dark table-striped'>
<thead>
  <tr>
     <th>Sr No</th>
     <th>Request By</th>
     <th>File</th>
     <th>Confirm</th>
     <th>Date_time</th>
  </tr>
</thead>
<tbody>
           ";
$n=0;
        while($rows=mysqli_fetch_array($result)){
     $n++;
            $requestby=$rows['requestby'];
            $fileid=$rows['fileid'];
            $request_label=$rows['request_label'];
            $date_time=$rows['date_time'];

     $username=getusername($requestby);
     $file_detail=getfiledetail($fileid);

 if($request_label=="1"){
        $confirmdata="
         <form action='key_request.php' method='post'>
              <input type='hidden' name='fileid' value='$fileid'>
              <input type='submit' name='share_key' value='Share Key' class='btn btn-primary'>
         </form>
         <hr>
         <form action='key_request.php' method='post'>
              <input type='hidden' name='fileid' value='$fileid'>
              <input type='hidden' name='requestby' value='$requestby'>
              <input type='submit' name='decline' value='Decline' class='btn btn-primary'>
         </form>

        ";


 }
 else if($request_label=="2"){
  $confirmdata="Confirmed";
 }
 else if($request_label=="3"){
     $confirmdata="Canceled";
 }



          $data.="
<tr>
    <td>$n</td>
    <td>$username</td>
    <td>$file_detail</td>
    <td>$confirmdata</td>
    <td>$date_time</td>
 </tr>
          ";
        }


           $data.="</tbody></table>";
     }
     else{

  $data.="
<div class='alert alert-danger'>
<strong>Failed:</strong>
Not found any key request
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


function getusername($userid){
    global $conn;
  $data="";
$sql="SELECT * FROM user WHERE userid='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   if(mysqli_num_rows($result)>0){
            while($rows=mysqli_fetch_array($result)){
              $username=$rows['username'];
              $data.="$username";
            }
   }
   else{
    $data.="not found";
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
  return $data;
}

function getfiledetail($fileid){
global $conn;
  $data="";
$sql="SELECT * FROM data_file WHERE fileid='$fileid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   if(mysqli_num_rows($result)>0){
            while($rows=mysqli_fetch_array($result)){
               $subject=$rows['subject'];
               $filename=$rows['filename'];
               $f=$rows['filesize'];
               $filesize=round($rows['filesize'],2)."Mb";

               if($filesize==0){
                $filesize=round(($f*1024),3)."Kb";
               }
               $data.="
      <strong>Subject:</strong> $subject <br>
      <strong>File Name:</strong> $filename <br>
      <strong>File Size:</strong> $filesize
               ";
            }
   }
   else{
    $data.="not found";
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
  return $data;
}

function share_key($fileid){
  $data="<br>";
global $conn;

$sql="UPDATE request SET request_label='2' WHERE request_label='1' AND fileid='$fileid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
    $data.="
<div class='alert alert-primary'>
  <strong>Success:</strong>
  Successfully share secretkey.
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


function users_send_list()
{
  global $conn;
  $data="<br>";
$self=$_SESSION['userid'];
$sql="SELECT * FROM data_file WHERE senderid='$self'";
$result=mysqli_query($conn,$sql);
if($result){
   if(mysqli_num_rows($result)>0){

$data.="<table class='table table-bordered'>
<thead>
 <tr>
    <th>Sr No</th>
    <th>Subject</th>
    <th>Filename</th>
    <th>filesize</th>
    <th>User</th>
    <th>Date Time</th>
 </tr>
</thead>
<tbody>
";
$n=0;
   while($rows=mysqli_fetch_array($result)){
$n++;
$subject=$rows['subject'];
$filename=$rows['filename'];
$filesize=$rows['filesize'];
$userid=$rows['userid'];
$date_time=$rows['date_time'];
$user=getusername($userid);
$data.="
<tr>
  <td>$n</td>
  <td>$subject</td>
  <td>$filename</td>
  <td>$filesize</td>
  <td>$user</td>
  <td>$date_time</td>
</tr>
";

   }


$data.="
</tbody>
</table>";

   }
   else{

    $data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
  No users found.
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


function decline($fileid,$requestby)
{
    global $conn;
    $data="";

    $sql="UPDATE request SET request_label='3' WHERE fileid='$fileid' AND requestby='$requestby' LIMIT 1";
    $result=mysqli_query($conn,$sql);
    if($result){
        $data.="Decline successfully";
    }
    else{
        $data.="error:".mysqli_error($conn);
    }

    echo $data;
}



 ?>
