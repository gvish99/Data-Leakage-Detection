/*

user:

userid
username
email
password
usertype  admin, user , distributor
admin_active
date_time

data_file:

fileid
subject
filename
filesize
senderid (sender)
userid  (receiver)
secretkey (key to download file)
date_time

request:

requestid
requestby (userid)
requestto (senderid which send files)
fileid (for which secret key ask)
askkey
request_label (1- request send, 2- request confirm)
date_time


leaker:


leakerid
userid (user which will leak a file)
subject
fileid 
secretkey
date_time

*/

CREATE TABLE IF NOT EXISTS user(
userid INT(10) AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
usertype VARCHAR(255) DEFAULT 'user',
admin_active VARCHAR(255) DEFAULT '0',
date_time DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS data_file(
fileid INT(10) AUTO_INCREMENT PRIMARY KEY,
subject VARCHAR(255) NOT NULL,
filename VARCHAR(255) NOT NULL,
filesize VARCHAR(255) NOT NULL,
senderid VARCHAR(255) NOT NULL,
userid  VARCHAR(255) NOT NULL,
secretkey VARCHAR(255) NOT NULL,
date_time DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS request(
requestid INT(10) AUTO_INCREMENT PRIMARY KEY,
requestby VARCHAR(255) NOT NULL,
requestto VARCHAR(255) NOT NULL,
fileid VARCHAR(255) NOT NULL,
askkey VARCHAR(255) NOT NULL,
request_label VARCHAR(255) DEFAULT '0',
date_time DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS leaker(
leakerid INT(10) AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(255) NOT NULL,
subject VARCHAR(255) NOT NULL,
fileid VARCHAR(255) NOT NULL,
secretkey VARCHAR(255) NOT NULL,
date_time DATETIME NOT NULL
);

