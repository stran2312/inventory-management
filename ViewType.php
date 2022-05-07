<?php
require_once('connection.php');
$device_type = $dblink->real_escape_string($_REQUEST['type']);
	if($device_type == NULL){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: Invalid Data";
		$output[]="MSG: Device type must not be blank.";
		$output[]="";
		$responseData=json_encode($output);
		echo $responseData;
		die();
	} else {
		$sql="Select * from `device_table` where `device_type`='$device_type' limit 10";
		$result=$dblink->query($sql) or
			die("Something went wrong with $sql");
		if ($result->num_rows>0)
		{
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: OK";
			$output[]="MSG: ";
			foreach($result as $key => $value){
				$data[] = $value;
			}
			$output[]=$data;
			$responseData=json_encode($output);
			echo $responseData;
		}
		else
		{
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: Not Found";
			$output[]="MSG: Device type: $device_type not in database";
			$data[]="";
			$output[]=$data;
			$responseData=json_encode($output);
			echo $responseData;
		}
	}
?>