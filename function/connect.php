<?php 
function connect(){
  $server="localhost";
  $user="root";
  $password="";
  $database="dataleakage";
  $conn=mysqli_connect($server,$user,$password,$database);
  if($conn){

$sql="
CREATE TABLE IF NOT EXISTS user(
userid INT(10) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
usertype VARCHAR(255) DEFAULT 'user',
admin_active VARCHAR(255) DEFAULT '0',
date_time DATETIME NOT NULL
)";
mysqli_query($conn, $sql);

$sql="
CREATE TABLE IF NOT EXISTS data_file(
fileid INT(10) AUTO_INCREMENT PRIMARY KEY,
subject VARCHAR(255) NOT NULL,
filename VARCHAR(255) NOT NULL,
filesize VARCHAR(255) NOT NULL,
senderid VARCHAR(255) NOT NULL,
userid  VARCHAR(255) NOT NULL,
secretkey VARCHAR(255) NOT NULL,
date_time DATETIME NOT NULL
)";
mysqli_query($conn, $sql);

$sql="
CREATE TABLE IF NOT EXISTS request(
requestid INT(10) AUTO_INCREMENT PRIMARY KEY,
requestby VARCHAR(255) NOT NULL,
requestto VARCHAR(255) NOT NULL,
fileid VARCHAR(255) NOT NULL,
askkey VARCHAR(255) NOT NULL,
request_label VARCHAR(255) DEFAULT '0',
date_time DATETIME NOT NULL
)";
mysqli_query($conn, $sql);

$sql="
CREATE TABLE IF NOT EXISTS leaker(
leakerid INT(10) AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(255) NOT NULL,
subject VARCHAR(255) NOT NULL,
fileid VARCHAR(255) NOT NULL,
secretkey VARCHAR(255) NOT NULL,
date_time DATETIME NOT NULL
)";
mysqli_query($conn, $sql);
    
    $sql='INSERT INTO user(username,email,password,usertype,admin_active,date_time)VALUES
        ("admin","admin@gmail.com","12345","admin","1","2021-12-22")';
    $result=mysqli_query($conn, $sql);
    
  	return $conn;
  }
  else{
  	echo "connection error:";
  }
}
 ?>
