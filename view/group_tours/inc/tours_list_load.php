<?php
include '../../../config.php';
$dest_id = $_GET['dest_id'];
if($dest_id != ''){
	$query = "select tour_id,tour_name from tour_master where dest_id = '$dest_id' and active_flag!='Inactive' order by tour_name asc";
}
$sq_tours = mysqlQuery($query);
?>
<option value=''>Tour Name</option>
<?php
while($row_tours = mysqli_fetch_assoc($sq_tours)){
	echo "<option value='$row_tours[tour_id]'>".$row_tours['tour_name']."</option>";
} ?>