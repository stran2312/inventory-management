<?php
require_once('connection.php');
$did=$_REQUEST['did'];
$file_id = $_REQUEST['auto_id'];
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
	if (!is_numeric($file_id) && $file_id!=NULL){
	header('Content-Type: application/json');
	header('HTTP/1.1 200 OK');
	$output[]="Status: Invalid Data";
	$output[]="MSG: File ID must be numbers only.";
	$output[]="";
	$responseData=json_encode($output);
	echo $responseData;
	die();
	} else if ($file_id==NULL) {
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: Invalid Data";
		$output[]="MSG: File ID must not be blank.";
		$output[]="";
		$responseData=json_encode($output);
		echo $responseData;
		die();
	} else {
		$sql="SELECT * FROM `files` where `device`='$did'";
		$result = $dblink->query($sql) or die("Something went wrong with $sql");
		$device=$result->fetch_array(MYSQLI_ASSOC);
		if ($result->num_rows>0)
		{
			$sql2 = "SELECT * FROM `files` where `device`='$did' AND `auto_id` = '$file_id'";
			$result = $dblink->query($sql) or die("Something went wrong with $sql");
			$new_device = $result->fetch_array(MYSQLI_ASSOC);
			if($result->num_rows>0){
				header('Content-Type: application/json');
				header('HTTP/1.1 200 OK');
				$output[]="Status: OK";
				$output[]="MSG: ";
				$data[]='File Name: '.$new_device['file_name'];
				$data[]='File Size: '.$new_device['file_size'];
				$data[]='File link:   ./files/'.$new_device['file_name'].'';
				$output[]=$data;
				$responseData=json_encode($output);
				echo $responseData;
			} else {
				header('Content-Type: application/json');
				header('HTTP/1.1 200 OK');
				$output[]="Status: File Not Found";
				$output[]="MSG: File Id: $file_id not in database";
				$data[]="";
				$output[]=$data;
				$responseData=json_encode($output);
				echo $responseData;
			}
		} else {
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
}
?>