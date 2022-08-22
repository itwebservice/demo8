<?php
include "../../../model/model.php";
$estimate_type = $_POST['estimate_type'];
$estimate_type_id = $_POST['estimate_type_id'];
$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];

$sq_estimate_count = mysqli_num_rows(mysqlQuery("select * from vendor_estimate where estimate_type='$estimate_type' and estimate_type_id='$estimate_type_id' and vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'"));
if($sq_estimate_count > 0){
	echo $sq_estimate_count;
}
?>        