<?php
include '../../../config.php';
$city_id = $_POST['city_id'];
if($city_id != ''){
	$query = "select entry_id, excursion_name from excursion_master_tariff where city_id='$city_id'";
}
else{
	$query = "select entry_id, excursion_name from excursion_master_tariff where 1";
}
$sq_act = mysqlQuery($query);
?>
<option value=''>Activity Name</option>
<?php
while($row_act = mysqli_fetch_assoc($sq_act)){
?>
	<option value="<?php echo $row_act['entry_id'] ?>"><?php echo $row_act['excursion_name'] ?></option>
<?php } ?>