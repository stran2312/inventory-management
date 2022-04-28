<?php
require_once('connection.php');
$sql = "SELECT * FROM `device_table`";
$result = $dblink->query($sql) or die("Something went wrong with $sql");
header('Content-Type: application/json');
header('HTTP/1.1 200 OK');
$output[]="Status: OK";
$output[]="MSG: ";
$output[]="";
$responseData=json_encode($output);
echo $responseData;
?>