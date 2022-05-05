<?php
require_once('connection.php');
$uploadDir="/var/www/html/files";
$did=$_REQUEST['did'];
move_uploaded_file($tmpName, $location);
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
	if($fileName == NULL){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: File name cannot be null";
		$output[]="MSG: ";
		$output[]="";
		$responseData=json_encode($output);
		echo $responseData;
	} else {
		$fileName=$_FILES['userfile2']['name'];
		$tmpName=$_FILES['userfile2']['tmp_name'];
		$file_size=$_FILES['userfile2']['size'];
		$file_type=$_FILES['userfile2']['type'];
		$location="$uploadDir/$fileName";
		move_uploaded_file($tmpName, $location);
		$sql="INSERT INTO `files_link` (`file_name`, `file_type`, `file_size`, `location`, `device`) VALUES";
		$sql.= " ('$fileName', '$file_type','$file_size', '$location', '$auto_id')";
		$result = $dblink->query($sql) or die("Something went wrong with $sql");
		if ($result == true)
		{
			header('Content-Type: application/json');
			header('HTTP/1.1 200 OK');
			$output[]="Status: OK";
			$output[]="MSG: Successfully uploaded";
			$output[]="";
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
}
?>