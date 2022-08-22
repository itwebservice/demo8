<?php 
include "../../../model/model.php";
$active_flag = $_POST['active_flag'];

$array_s = array();
$temp_arr = array();
$count = 0;
$query = "select * from bike_master where 1 ";
if($active_flag != ''){
	$query .= " and active_flag='$active_flag'";
}
$sq_vehicle = mysqlQuery($query);
while($row_vehicle = mysqli_fetch_assoc($sq_vehicle))
{
	$bg = ($row_vehicle['active_flag']=="Inactive") ? "danger" : "";
	$sq_bike_type = mysqli_fetch_assoc(mysqlQuery("select * from bike_type_master where entry_id='$row_vehicle[bike_type]' "));

	$temp_arr = array ("data"=>array(
		(int)(++$count),
		$sq_bike_type['bike_type'],
		$row_vehicle['bike_name'],
		$row_vehicle['manufacturer'].'('.$row_vehicle['model_name'].')',
		$row_vehicle['seating_capacity'],
		'<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="edit_modal('.$row_vehicle['entry_id'] .')" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>'),"bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>