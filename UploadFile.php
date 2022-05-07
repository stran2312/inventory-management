<?php
require_once('connection.php');
$did=$_POST['did'];
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
	$fileName =$_POST['name'];
	$file_size=$_POST['size'];
	$file_type=$_POST['type'];
	$content=$_POST['content'];
	$content=addslashes($content);
	if($fileName == NULL){
		header('Content-Type: application/json');
		header('HTTP/1.1 200 OK');
		$output[]="Status: File name cannot be null";
		$output[]="MSG: ";
		$output[]="";
		$responseData=json_encode($output);
		echo $responseData;
		die();
	} else {
		$sql="INSERT INTO `files` (`file_name`, `file_type`, `file_size`,`content`, `device`) VALUES";
		$sql .= " ('$fileName', '$file_type', '$file_size', '$content', '$did')";
		$result = $dblink->query($sql) or die("Something went wrong with $sql");
		if ($result==true)
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