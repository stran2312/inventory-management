<?php
require_once('connection.php');
$did=$_REQUEST['did'];
$device_type = $_REQUEST['type'];
$manufacture = $_REQUEST['manufacture'];
$serial_number = $_REQUEST['serial_number'];
$status = $_REQUEST['status'];

if (!is_numeric($did) && $did!=NULL)
{
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]="Status: Invalid Data";
	$output[]="MSG: Device ID must be numbers only.";
	$output[]="";
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
elseif ($did==NULL)
{
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]="Status: Invalid Data";
	$output[]="MSG: Device ID must not be blank.";
	$output[]="";
	$responseData=json_encode($output);
	echo $responseData;
	die();
}
else
{
	$sql = "UPDATE `device_table` SET device_type = '$device_type', manufacturer = '$manufacturer', serial_number = '$serial_number', status = '$status' WHERE auto_id = '$did'";
	$result = $dblink->query($sql) or die("Something went wrong with $sql");
	$device=$result->fetch_array(MYSQLI_ASSOC);
	if ($result->num_rows>0)
	{
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: OK";
		$output[]="MSG: Update Successfully";
		$data[]='Maufacturer: '.$device['manufacturer'];
		$data[]='Device Type: '.$device['device_type'];
		$data[]='Serial Number: '.$device['serial_number'];
		$data[] = 'Status: '.$device['status'];
		$output[]=$data;
		$responseData=json_encode($output);
		echo $responseData;
	}
	else
	{
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: Not Found";
		$output[]="MSG: Device Id: $did not in database";
		$data[]="";
		$output[]=$data;
		$responseData=json_encode($output);
		echo $responseData;
	}
}
?>