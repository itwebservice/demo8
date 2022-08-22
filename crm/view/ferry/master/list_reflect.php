<?php 
include "../../../model/model.php";
$active_flag = $_POST['active_flag'];
$array_s = array();
$temp_arr = array();
$count = 0;
$ferry = "select * from ferry_master where 1";
if($active_flag != ''){
	$ferry .= " and active_flag='$active_flag'";
}
$sq_ferry = mysqlQuery($ferry);
while($row_ferry = mysqli_fetch_assoc($sq_ferry))
{
	$bg = ($row_ferry['active_flag']=="Inactive") ? "danger" : "";
	$temp_arr = array ("data"=>array(
		(int)(++$count),
		$row_ferry['ferry_type'],
		$row_ferry['ferry_name'],
		$row_ferry['seating_capacity'],
		'<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="edit_modal('.$row_ferry['entry_id'] .')" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>'),"bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>