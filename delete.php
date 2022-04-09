<?php
require_once('connection.php');
	
if(isset($_REQUEST['delete'])){
	$auto_id = $dblink->real_escape_string($_REQUEST['delete']);
	$sql = "DELETE FROM `device_table` WHERE auto_id = '$auto_id'";
	$result = $dblink->query($sql);
	if($result == true){
		echo '<h2 class="container mt-2 text-center text-success">Data deleted successfully!</h2>';
	}else{
		echo '<h2 class="container mt-2 text-center text-danger">Data failed to delete!</h2>';
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