<?php
include '../../../config.php';
$dest_id = $_POST['dest_id'];
if($dest_id != ''){
	$query = "select package_id, package_name,total_nights,total_days from custom_package_master where dest_id = '$dest_id' and status!='Inactive'";
}
else{
	$query = "select package_id, package_name,total_nights,total_days from custom_package_master where 1 and status!='Inactive'";
}
$sq_tours = mysqlQuery($query);
?>
<option value=''>Tour Name</option>
<?php
while($row_tours = mysqli_fetch_assoc($sq_tours)){
?>
	<option value="<?php echo $row_tours['package_id'] ?>"><?php echo $row_tours['package_name']." (". $row_tours['total_nights']."N /".$row_tours['total_days']."D)" ?></option>
<?php } ?>