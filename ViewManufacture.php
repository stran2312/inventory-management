<?php
require_once('connection.php');
$manufacture = $_REQUEST['manufacture'];
	if($manufacture == NULL){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: Invalid Data";
		$output[]="MSG: manufacture must be not be blank.";
		$output[]="";
		$responseData=json_encode($output);
		echo $responseData;
		die();
	} else {
		$sql="Select * from `device_table` where `manufacturer`='$manufacture' limit 10";
		$result=$dblink->query($sql) or
			die("Something went wrong with $sql");
		if ($result->num_rows>0)
		{
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: OK";
			$output[]="MSG: ";
			$data[]="";
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
			$output[]="MSG: Manufacture: $manufacture not in database";
			$data[]="";
			$output[]=$data;
			$responseData=json_encode($output);
			echo $responseData;
		}
	}
?>