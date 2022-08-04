<?php
$filename = $_GET["file"];
$contenttype = "application/force-download";
header("Content-Type: " . $contenttype);
header("Content-Disposition: attachment; filename=\"" .$filename. "\";");
readfile("../files/".$filename);
exit();
?>