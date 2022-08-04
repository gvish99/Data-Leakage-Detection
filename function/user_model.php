<?php
require_once("../function/connect.php");
$conn=connect();

function get_distributor_send_files($userid){
	$data="<br>";
	global $conn;
	$sql="SELECT * FROM data_file  ORDER BY fileid DESC";
	$result=mysqli_query($conn,$sql);
	if($result){
				if(mysqli_num_rows($result)>0){
$n=0;
               while($rows=mysqli_fetch_array($result)){
               	$n++;
                      $fileid=$rows['fileid'];
                      $subject=$rows['subject'];
                      $filename=$rows['filename'];
                      $filesize=$rows['filesize'];
                      $senderid=$rows['senderid'];                      
                      $secretkey=$rows['secretkey'];
                      $date_time=$rows['date_time'];


$secretdata=check_request($fileid,$userid,$senderid,$secretkey);
$sendername=getsendername($senderid);


$users_list=users_list($senderid);

$data.="
<div class='card my-3'>
  <div class='card-body'>
    <h4 class='card-title'>Sender: $sendername</h4>
    <p class='card-text'>Subject:$subject | File Name: $filename | File Size: $filesize</p>
    <a href='#' class='card-link text-decoration-none'>$secretdata</a>
    <a href='#' class='card-link text-decoration-none'>$date_time</a> <hr>
    <form action='distributor_files.php' method='post'>
    <input type='hidden' name='fileid' value='$fileid'>
                        <p>
                                <label for='users'>Select users</label>
                                $users_list
                        </p>
                <p>
                    <input type='submit' name='share_others' value='Share'>
                </p>
    </form>
  </div>
</div>
";
               }

$data.="<hr>";

				}
				else{
					$data.="
					<div class='alert alert-danger'>
						<strong>Failed:</strong>
						No file found
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


function users_list($senderid){
    $data="";
    global $conn;
    $myid=$_SESSION['userid'];
    $sql="SELECT * FROM user WHERE userid!='$myid' AND userid!='$senderid'";
    $result=mysqli_query($conn,$sql);
    if($result){
        $data.="<select name='userid'><option></option>";
                while($rows=mysqli_fetch_array($result)){
                    $userid=$rows["userid"];
                    $username=$rows["username"];
                    $data.="<option value='$userid'>$username</option>";
                }
                $data.="</select>";
    }
    else{

    }

    return $data;
}


function share_others($fileid,$userid){
    $data="asdfasdf";

    $filedata=get_file_data($fileid);

    $subject=$filedata["subject"];
    $filename=$filedata["filename"];
    $filesize=$filedata["filesize"];
    $senderid=$filedata["senderid"];
    $userid=$_SESSION["userid"];
    $secretkey=$filedata["secretkey"];

    $data.="$secretkey";


    echo $data;
}

function get_file_data($fileid){
    $data="";
    global $conn;
    $sql="SELECT * FROM data_file WHERE fileid='$fileid'";
    $result=mysqli_query($conn,$sql);
    if($result){
         $rows=mysqli_fetch_array($result);
         $data=$rows;
    }
    else{

    }
    return $data;
}



function check_request($fileid,$userid,$senderid,$secretkey){
	$data="";
		global $conn;
$sql="SELECT * FROM request WHERE fileid='$fileid' AND requestby='$userid' AND requestto='$senderid'";
$result=mysqli_query($conn,$sql);
if($result){
         if(mysqli_num_rows($result)>0){
                      while($rows=mysqli_fetch_array($result)){
                      	$request_label=$rows['request_label'];
                        $askkey=$rows['askkey'];
                      	if($request_label=="0"){
                    $data.="
					<form action='distributor_files.php' method='post'>
					<input type='hidden' name='requestby' value='$userid'>
					<input type='hidden' name='requestto' value='$senderid'>
					<input type='hidden' name='fileid' value='$fileid'>
					<input type='hidden' name='askkey' value='$secretkey'>
					<input type='hidden' name='request_label' value='1'>
					<input type='submit' name='send_request' value='Send Request' class='btn btn-primary btn-sm'>
					</form>
					<hr/>
					<a href='../main/process.php?fileid=$fileid'>
                    <button class='btn btn-primary btn-sm'>Proceed to Download=></button></a>
                          ";
                      	}
                      	else if($request_label=="1"){
                    $data.="<button type='button' class='btn btn-warning btn-sm'>Pending</button>
                                <hr/>
                            <a href='../main/process.php?fileid=$fileid'>
                             <button class='btn btn-primary btn-sm'>Proceed to Download=></button></a>
                          ";
                      	}
                      	else if($request_label==="2"){
                          $data.="
                          <button type='button' class='btn btn-success btn-sm'>Key Received ($askkey)</button>
                                      <hr/>
                            <a href='../main/process.php?fileid=$fileid'>
                            <button class='btn btn-primary btn-sm'>Proceed to Download=></button></a>
                          ";
                      	}
                      	else if($request_label==="3"){
                          $data.="
                         <button class='btn btn-danger'> Cancelled</button>

                          ";
                      	}
                      }
         }
         else{
         	$data.="
					<form action='distributor_files.php' method='post'>
					<input type='hidden' name='requestby' value='$userid'>
					<input type='hidden' name='requestto' value='$senderid'>
					<input type='hidden' name='fileid' value='$fileid'>
					<input type='hidden' name='askkey' value='$secretkey'>
					<input type='hidden' name='request_label' value='1'>
					<input type='submit' name='send_request' value='Send Request' class='btn btn-primary btn-sm'>
					</form>
					<br>
                    <a href='../main/process.php?fileid=$fileid'>
                    <button class='btn btn-primary btn-sm'>Proceed to Download=></button></a>
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


	return $data;
}





function getsendername($senderid){
	global $conn;
	$data="";
$sql="SELECT * FROM user WHERE userid='$senderid' LIMIT 1";
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


function send_request($requestby,$requestto,$fileid,$askkey,$request_label,$date_time){
       global $conn;
       $data="<br>";

       $sql="SELECT * FROM request WHERE fileid='$fileid' AND requestby='$requestby'";
       $result=mysqli_query($conn,$sql);
       if($result){
                 if(mysqli_num_rows($result)>0){
                      $data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
Request Already send.
</div>
  ";
                 }
                 else{
                        	$sql1="INSERT INTO request(requestby,requestto,fileid,askkey,request_label,date_time)VALUES(
'$requestby','$requestto','$fileid','$askkey','$request_label','$date_time'
       )";
       	$result1=mysqli_query($conn,$sql1);
       	if($result1){
  $data.="
<div class='alert alert-success'>
  <strong>Success:</strong>
Successfully secretkey request send.
</div>
  ";
       	}
       	else{
       		$error=mysqli_error($conn);
       		$data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
       		";
       	}
                 }
       }
       else{
           	$error=mysqli_error($conn);
       		$data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
       		";
       }




       echo $data;
}

function share_file($userid,$subject,$fileid,$secretkey,$date_time){
global $conn;
$data="<br>";
       	$sql1="INSERT INTO leaker(userid,subject,fileid,secretkey,date_time)VALUES(
		'$userid','$subject','$fileid','$secretkey','$date_time'
       )";
       	$result1=mysqli_query($conn,$sql1);
       	if($result1){
      $data.="
<div class='alert alert-success'>
  <strong>Success:</strong>
Successfully file shared.
</div>
  ";
       	}
       	else{
       		$error=mysqli_error($conn);
       		$data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
       		";
       	}



echo $data;
}

function proceed_download($fileid,$secretkey){
global $conn;
$data="";
        $sql="SELECT * FROM data_file WHERE fileid='$fileid' AND secretkey='$secretkey' LIMIT 1";
        $result=mysqli_query($conn,$sql);
        if($result){

          if(mysqli_num_rows($result)>0){

                while($rows=mysqli_fetch_array($result)){
                  $filename=$rows['filename'];
                  $subject=$rows['subject'];
                  $userid=$_SESSION['userid'];
                  $date_time=date("Y-m-d H:i:s");
                  isleaker($userid,$subject,$fileid,$secretkey,$date_time);

                  $url="download.php?file=$filename";
                  header("Location:$url");
                  exit();


                }

          }
          else{
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Invalid secret key.
</div>
          ";
          }

        }
        else{
          $error=mysqli_error($conn);
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
          ";
        }
echo  $data;
}


function isleaker($userid,$subject,$fileid,$secretkey,$date_time)
{
    global $conn;
    $data="";
    $sql="SELECT * FROM request WHERE fileid='$fileid' AND requestby='$userid'";
    $result=mysqli_query($conn,$sql);
    if($result){
         if(mysqli_num_rows($result)>0){

         }
         else{
             $sql2="SELECT * FROM leaker WHERE userid='$userid' AND fileid='$fileid' AND secretkey='$secretkey'";
             $result2=mysqli_query($conn,$sql2);
             if($result2){
                        if(mysqli_num_rows($result2)>0){

                        }
                        else{
                               $sql1="INSERT INTO leaker(userid,subject,fileid,secretkey,date_time)VALUES('$userid','$subject','$fileid','$secretkey','$date_time')";
             $result1=mysqli_query($conn,$sql1);
             if($result1){

             }
             else{
                  $error=mysqli_error($conn);
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
          ";
             }
                        }
             }
             else{
                   $error=mysqli_error($conn);
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
          ";
             }




         }
    }
    else{
         $error=mysqli_error($conn);
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
          ";
    }

echo $data;
}

function leakage_file(){
       $data="<br>";
       global $conn;
$sql="SELECT * FROM leaker ORDER BY leakerid DESC";
$result=mysqli_query($conn,$sql);
if($result){
     if(mysqli_num_rows($result)>0){

        $data.="<table class='table table-bordered'>
<thead>
   <tr>
        <th>Sr No</th>
        <th>File Details</th>
        <th>Download</th>
        <th>Shared By</th>
        <th>Date Time</th>
   </tr>
</thead>
        ";
$n=0;
        while($rows=mysqli_fetch_array($result)){
          $n++;
              $userid=$rows['userid'];
              $subject=$rows['subject'];
              $fileid=$rows['fileid'];
              $secretkey=$rows['secretkey'];
              $date_time=$rows['date_time'];
$user=getsendername($userid);
$file_detail=getfiledetail($fileid);
$download="<a href='../main/process.php?fileid=$fileid' class='white'>
<button type='button' class='btn btn-success'>
Download ($secretkey)
</a>";

          $data.="
              <tr>
                  <td>$n</td>
                  <td>$file_detail</td>
                  <td>$download</td>
                  <td>$user</td>
                  <td>$date_time</td>
              </tr>
          ";
        }

        $data.="</tbody></table>";

     }
     else{
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  Not found
</div>
          ";
     }
}
else{
  $error=mysqli_error($conn);
          $data.="<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
          ";
        }
       echo $data;
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


function share_with_others($userid,$fileid)
{
    $data="";
    global $conn;
    $filedata=filedata($fileid);

    $subject=$filedata["subject"];
    $filename=$filedata['filename'];
    $filesize=$filedata['filesize'];
    $senderid=$_SESSION['userid'];
    $user_id=$userid;
    $secretkey=$filedata["secretkey"];
    $date_time=date("Y-m-d H:i:s");
    $sql1="SELECT * FROM data_file WHERE userid='$user_id' AND senderid='$senderid'";
    $result1=mysqli_query($conn,$sql1);
    if($result1){
              if(mysqli_num_rows($result1)>0){
                  $data.="Already shared";
              }
              else{
                   $sql="INSERT INTO data_file(subject,filename,filesize,senderid,userid,secretkey,date_time)VALUES('$subject','$filename','$filesize','$senderid','$user_id','$secretkey','$date_time')";
    $result=mysqli_query($conn,$sql);
    if($result){
         echo "<div class='alert alert-primary'>Successfully shared</div>";
    }
    else{

    }
              }
    }
    else{

    }


    echo $data;
}


function filedata($fileid){
    $data="";
    global $conn;
    $sql="SELECT * FROM data_file WHERE fileid='$fileid' LIMIT 1";
    $result=mysqli_query($conn,$sql);
    if($result){
                if(mysqli_num_rows($result)>0){
                              $rows=mysqli_fetch_array($result);
                }
                $data=$rows;
    }
    else{

    }
    return $data;
}



 ?>
