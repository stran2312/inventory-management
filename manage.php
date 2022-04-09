<?php 
require_once('connection.php');
if(isset($_REQUEST['add_device'])){
	$device_type = $dblink->real_escape_string($_REQUEST['device_type']);
	$manufacturer = $dblink->real_escape_string($_REQUEST['manufacturer']);
	$serial_number = $dblink->real_escape_string($_REQUEST['serial_number']);
	$sql = "INSERT INTO `device_table` (device_type, manufacturer, serial_number) VALUES ('$device_type', '$manufacturer', '$serial_number')";
	$result = $dblink->query($sql);
	if($result == true){
		echo '<h2 class="container mt-2 text-center text-success">Data added successfully!</h2>';
	}else{
		echo '<h2 class="container mt-2 text-center text-danger">Data failed to add!</h2>';
	}
}

if(isset($_REQUEST['edit_device'])){
	$device_type = $dblink->real_escape_string($_REQUEST['device_type']);
	$manufacturer = $dblink->real_escape_string($_REQUEST['manufacturer']);
	$serial_number = $dblink->real_escape_string($_REQUEST['serial_number']);
	$sql = "UPDATE `device_table` SET device_type = '$device_type', manufacturer = '$manufacturer', serial_number = '$serial_number' WHERE auto_id = '".$_REQUEST['auto_id']."'";
	$result = $dblink->query($sql);
	if($result == true){
		echo '<h2 class="container mt-2 text-center text-success">Data updated successfully!</h2>';
	}else{
		echo '<h2 class="container mt-2 text-center text-danger">Data failed to update!</h2>';
	}
}

if(isset($_POST["UploadAppDoc"]) && $_FILES['userfile']['size'] > 0){
					$start_time=microtime(true);
					$auto_id = $_POST['auto_id'];
					$uploadDir="/var/www/html/files";
					$tmpName=$_FILES['userfile']['tmp_name'];
					$fileSize=$_FILES['userfile']['size'];
					$fileType=$_FILES['userfile']['type'];
					$fp=fopen($tmpName, 'r');
					$content=fread($fp, filesize($tmpName));
					$content=addslashes($content);
					fclose($fp);
					$sql="INSERT INTO `files` (`file_name`, `file_type`, `file_size`,`content`, `device`) VALUES";
					$sql .= " ('$tmpName', '$file_size', '$file_type', '$content', '$auto_id')";
					$dblink->query($sql) or die("Something went wrong with $sql");
					$end_time=microtime(true);
					$execution_time = ($end_time - $start_time);
}

if(isset($_POST["UploadFileSys"]) && $_FILES['userfile2']['size']>0){
					$start_time=microtime(true);
					$uploadDir="/var/www/html/files";
					$auto_id=$_POST['auto_id'];
					$fileName=$_FILES['userfile2']['name'];
					$tmpName=$_FILES['userfile2']['tmp_name'];
					$file_size=$_FILES['userfile2']['size'];
					$file_type=$_FILES['userfile2']['type'];
					$location="$uploadDir/$fileName";
					move_uploaded_file($tmpName, $location);
					$sql="INSERT INTO `files_link` (`file_name`, `file_type`, `file_size`, `location`, `device`) VALUES";
					$sql.= " ('$fileName', '$file_type','$file_size', '$location', '$auto_id')";
					$dblink->query($sql) or die("Something went wrong with $sql");
					$end_time=microtime(true);
					$execution_time = ($end_time - $start_time);
}

if(isset($_REQUEST['execTime'])){
	$execution_time = $_REQUEST['execTime'];
	echo '<div class=alert alert-success alert-disissible role="alert">';
	echo '<button type="button" class="close" data-disiss="alert" arial-lable="Close"><span aria-hidden="true">&times;</span></button>';
	echo '<p>File was processed. Execution time is: '.$execution_time;
	echo '</div>';
	$auto_id = $_REQUEST['auto_id'];	
	$sql="SELECT * FROM `files` where `device`='$auto_id'";
	$result = $dblink->query($sql) or die("Something went wrong with $sql");
	if($result->num_rows>0){
		echo '<p>Device record files found on the data base: </p>';
		while ($data=$result->fetch_array(MYSQLI_ASSOC)){
			$name=str_replace(" ", "_",$data['file_name']);
			$fp=fopen("/var/www/html/files/$name","wb");
			fwrite($fp, $data['content']);
			fclose($fp);
			echo '<div><a class="btn btn-sm btn-primary" href="./files/'.$name.'" target="_blank">View Record</a></div>';
		}
	}
					
	$sql="SELECT * FROM `files_link` where `device`='$auto_id'";
	$result = $dblink->query($sql) or die("Something went wrong with $sql");
	if($result->num_rows>0){
		echo '<p>Device record files found on the file system: </p>';
		while ($data=$result->fetch_array(MYSQLI_ASSOC)) {
			echo '<p><a class="btn btn-sm btn-primary" href="./files/'.$data['file_name'].'" target="_blank">View Record</a></p>';
		}
	}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-3">
		<div class="card card-body">
			<?php
			if(isset($_REQUEST['auto_id']) && $_REQUEST['auto_id'] != ''){
				$sql = "SELECT * FROM `device_table` WHERE auto_id = '".$_REQUEST['auto_id']."'";
				$result = $dblink->query($sql) or die("Something went wrong with $sql");
				$row = $result->fetch_object();
				?>
				<form action="manage.php" method="POST" style="margin-bottom: 16px;">
					<input type="hidden" name="auto_id" value="<?php echo $row->auto_id;?>">
				  <div class="form-group">
				    <label for="device_type">Device type:</label>
				    <input type="text" name="device_type" value="<?php echo $row->device_type;?>" class="form-control" id="device_type" placeholder="Enter device type" required>
				  </div>
				  <div class="form-group">
				    <label for="manufacturer">Manufacturer:</label>
				    <input type="text" name="manufacturer" value="<?php echo $row->manufacturer;?>" class="form-control" id="manufacturer" placeholder="Enter manufacturer" required>
				  </div>
				  <div class="form-group">
				    <label for="serial_number">Serial number:</label>
				    <input type="text" name="serial_number" value="<?php echo $row->serial_number;?>" class="form-control" id="serial_number" placeholder="Enter serial number" required>
				  </div>
				  <button type="submit" name="edit_device" class="btn btn-primary btn-lg" style="margin-right: 6px;">Save</button>
				</form>
			 <?php
					$auto_id = $_REQUEST['auto_id'];	
					$sql="SELECT * FROM `files` where `device`='$auto_id'";
					$result = $dblink->query($sql) or die("Something went wrong with $sql");
					if($result->num_rows>0){
						echo '<p>Device record files found on the data base: </p>';
						while ($data=$result->fetch_array(MYSQLI_ASSOC)){
							$name=str_replace(" ", "_",$data['file_name']);
							$fp=fopen("/var/www/html/files/$name","wb");
							fwrite($fp, $data['content']);
							fclose($fp);
							echo '<div><a class="btn btn-sm btn-primary" href="./files/'.$name.'" target="_blank">View Record</a></div>';
						}
					}
					
					$sql="SELECT * FROM `files_link` where `device`='$auto_id'";
					$result = $dblink->query($sql) or die("Something went wrong with $sql");
					if($result->num_rows>0){
						echo '<p>Device record files found on the file system: </p>';
						while ($data=$result->fetch_array(MYSQLI_ASSOC)) {
							echo '<p><a class="btn btn-sm btn-primary" href="./files/'.$data['file_name'].'" target="_blank">View Record</a></p>';
						}
					}
				?>
			</div> <!--end card body-->
			<div class="card card-body mt-3">
				<div class="panel panel-primary">File Upload to Database</div>
				<form action="manage.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="uploadedBy" value="">
					<input type="hidden" name="MAX_FILE_SIZE" value="50000000">
					<div class="form-group">
						<label class="control-label col-lg-4">Select a file</label>
						<div class="fileupload" data-provides="fileupload">
							<input type="file" name="userfile">
							<a href="manage.php?auto_id=<?php echo $_REQUEST['auto_id'];?>" class="btn btn-danger" data-dismiss="fileupload">Clear</a>
						</div>
						<a href="manage.php?auto_id=<?php echo $_REQUEST['auto_id']; echo "&execTime='.$execution_time.'";?>" class="btn btn-success" name="UploadAppDoc" type="submit" value="UploadAppDoc">Upload</a> 
					</div>
				</form>
			</div>	<!--end card body-->
			<div class="card card-body mt-3">
				<form action="manage.php" method="POST" enctype="multipart/form-data">
					<div class="panel panel-primary">File Upload to Filesystem</div>
					<input type="hidden" name="uploadedBy" value="">
					<input type="hidden" name="MAX_FILE_SIZE" value="50000000">
					<div class="form-group">
						<label class="control-label col-lg-4">Select a file</label>
						<div class="fileupload" data-provides="fileupload">
							<input type="file" name="userfile2">
							<a href="manage.php?auto_id=<?php echo $_REQUEST['auto_id'];?>" class="btn btn-danger" data-dismiss="fileupload">Clear</a>
						</div>
						<a href="manage.php?auto_id=<?php echo $_REQUEST['auto_id']; echo "&execTime='.$execution_time.'";?>" class="btn btn-success" name="UploadFileSys" type="submit" value="UploadFileSys">Upload</a> 
					</div>					
				</form>
			</div>	<!--end card body-->	
				<?php
			}else{
				?>
				<form action="manage.php" method="POST">
				  <div class="form-group">
				    <label for="device_type">Device type:</label>
				    <input type="text" name="device_type" class="form-control" id="device_type" placeholder="Enter device type" required>
				  </div>
				  <div class="form-group">
				    <label for="manufacturer">Manufacturer:</label>
				    <input type="text" name="manufacturer" class="form-control" id="manufacturer" placeholder="Enter manufacturer" required>
				  </div>
				  <div class="form-group">
				    <label for="serial_number">Serial number:</label>
				    <input type="text" name="serial_number" class="form-control" id="serial_number" placeholder="Enter serial number" required>
				  </div>
				  <button type="submit" name="add_device" class="btn btn-primary btn-lg">Save</button>
				</form>			
				
				<?php

			}
			?>
	</div>
</body>
</html>