<?php
require_once('connection.php');

$sql1 = "SELECT DISTINCT `device_type` FROM `device_table` limit 10000";
$resultDeviceType = $dblink->query($sql1) or die("Something went wrong with $sql1");

$sql2 = "SELECT DISTINCT `manufacturer` FROM `device_table` limit 10000";
$resultManufacturer = $dblink->query($sql2) or die("Something went wrong with $sql2");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  </head>
  <body>
  	<div class="container mb-5">
  		<h3 class="mt-2">Please select a option to query:</h3>
	    <br>
	    <form action="index.php" method="GET">
	    	<div class="row">
	    		<div class="col-md-3">
	    			<h6 style="margin-right: 22px;">Device type: 
				      	<br>
				      	<br>
				      	<select class="custom-select" name="device_type" id="">
				          <option value="">--</option>
				          <?php
				          	foreach ($resultDeviceType as $key => $value){
								echo '<option value="'.trim($value['device_type']).'"';
								if(isset($_REQUEST['device_type']) && trim($_REQUEST['device_type']) == trim($value['device_type'])){
									echo ' selected';
								}
								echo '>'.trim($value['device_type']).'</option>';
							}
				          ?>
				        </select>
				      </h6>
	    		</div>
	    		<div class="col-md-3">
	    			<h6 style="margin-right: 22px;">Manufacturer: 
	    				<br>
	    				<br>
				      	<select class="custom-select" name="manufacturer" id="">
				          <option value="">--</option>
				          	<?php
					          	foreach ($resultManufacturer as $key => $value){
									echo '<option value="'.trim($value['manufacturer']).'"';
									if(isset($_REQUEST['manufacturer']) && trim($_REQUEST['manufacturer']) == trim($value['manufacturer'])){
										echo ' selected';
									}
									echo '>'.trim($value['manufacturer']).'</option>';
								}
				          	?>
				        </select>
				      </h6>
	    		</div>
	    		<div class="col-md-3">
	    			<h6>Serial number: 
	    				<br>
	    				<br>
				      	<input type="text" name="serial_number">
				      </h6>
	    		</div>
	    	</div>
	      <br>
	      <button type="submit" class="btn btn-primary btn-lg mr-2">Search</button>
	      <a href="index.php" class="btn btn-outline-primary btn-lg mr-2">Clear all</a>
	      <a href="manage.php" class="btn btn-primary btn-lg ">Add</a>
	    </form>
	    <br>
	    
	    <table class="table">
		  <thead>
		    <tr>
		      <th scope="col">Auto id</th>
		      <th scope="col">Device type</th>
		      <th scope="col">Manufacturer</th>
		      <th scope="col">Serial number</th>
		      <th scope="col">Status</th>
		      <th scope="col">Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php
		  	if(!isset($_GET['page'])){  
		        $page_number = 1;
		    }else{
		        $page_number = $_GET['page'];
		    }

			$limit = 100;  
			$initial_page = ($page_number-1) * $limit;
			$getQuery = "SELECT COUNT(*) AS total FROM `device_table`";
		  	$sql4 = "SELECT * FROM `device_table`";

			if(isset($_REQUEST['device_type']) || isset($_REQUEST['manufacturer']) || isset($_REQUEST['serial_number'])){
				$s = '';
				if($_REQUEST['device_type'] != ''){
					if($s != ''){
						$s .= " AND device_type='".$_REQUEST['device_type']."'";
					}else{
						$s .= " device_type='".$_REQUEST['device_type']."'";
					}
				}
				if($_REQUEST['manufacturer'] != ''){
					if($s != ''){
						$s .= " AND manufacturer='".$_REQUEST['manufacturer']."'";
					}else{
						$s .= " manufacturer='".$_REQUEST['manufacturer']."'";
					}
				}
				if($_REQUEST['serial_number'] != ''){
					if($s != ''){
						$s .= " AND serial_number='".$_REQUEST['serial_number']."'";
					}else{
						$s .= " serial_number='".$_REQUEST['serial_number']."'";
					}
				}
				$getQuery .= " WHERE " . $s;
				$sql4 .= " WHERE " . $s;
			}

		    $resultRows = $dblink->query($getQuery);  
		    $resultRowsS = $resultRows->fetch_object(); 
		    $total_rows = $resultRowsS->total; 
			$total_pages = ceil ($total_rows / $limit);

		  	$sql4 .= " LIMIT " . $initial_page . ',' . $limit;
			$result = $dblink->query($sql4) or die("Something went wrong with $sql4");
			foreach ($result as $key => $value) {
				?>
				<tr>
			      <th scope="row"><?php echo $value['auto_id'];?></th>
			      <td><?php echo htmlentities($value['device_type']);?></td>
			      <td><?php echo htmlentities($value['manufacturer']);?></td>
			      <td><?php echo htmlentities($value['serial_number']);?></td>
				  <td><?php echo htmlentities($value['status']);?></td>
			      <td><a class="mr-3" href="manage.php?auto_id=<?php echo $value['auto_id'];?>">Edit</a></td>
				  <td><a class="text-danger" href="delete.php?delete=<?php echo $value['auto_id'];?>" onclick="deleteThis(this, event);">Delete</a></td>		
			    </tr>
				<?php
			}
		  	?>
		  </tbody>
		</table>
		<nav aria-label="Page navigation example">
		  <ul class="pagination justify-content-center">
		    <?php
		    for($i = 1; $i <= $total_pages; $i++) {  
		        echo '<li class="page-item';
		        if($i == $page_number){
		        	echo ' active';
		        }
		        echo '"><a class="page-link" href="?page=' . $i;
		        if(isset($_REQUEST['device_type']) || isset($_REQUEST['manufacturer']) || isset($_REQUEST['serial_number'])){
		        	if(isset($_REQUEST['page'])){
		        		$u = explode('&', explode('?', $_SERVER['REQUEST_URI'])[1]);
		        		echo str_replace($u[0], '', explode('?', $_SERVER['REQUEST_URI'])[1]);
		        	}else{
		        		echo '&' . explode('?', $_SERVER['REQUEST_URI'])[1];
		        	}
		        }
		        echo '">' . $i . ' </a></li>';  
		    }
		    ?>
		  </ul>
		</nav>
  	</div>
  	<script>
  		function deleteThis(btn, e){
  			e.preventDefault();

		    var choice = confirm('Are you sure to delete this item?');

		    if (choice) {
		        window.location.href = btn.getAttribute('href');
		    }
  		}
  	</script>
</body>
</html>