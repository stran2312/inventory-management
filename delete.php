<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

<?php
require_once('connection.php');
	
if(isset($_REQUEST['delete'])){
	$auto_id = $dblink->real_escape_string($_REQUEST['delete']);
	$sql = "DELETE FROM `device_table` WHERE auto_id = '$auto_id'";
	$result = $dblink->query($sql);
	if($result == true){
		echo '<h2 class="container mt-2 text-center text-success">Data deleted successfully!</h2>';
		echo '<a href="index.php" class="btn btn-primary">Home</a>';
	}else{
		echo '<h2 class="container mt-2 text-center text-danger">Data failed to delete!</h2>';
		echo '<a href="index.php" class="btn btn-primary">Home</a>';
	}
	
}
?>
<script>
  		function deleteThis(btn, e){
  			e.preventDefault();

		    var choice = confirm('Are you sure to delete this item?');

		    if (choice) {
		        window.location.href = btn.getAttribute('href');
		    }
  		}

</script>