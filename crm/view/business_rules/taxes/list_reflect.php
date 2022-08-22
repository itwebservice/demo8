<?php
include "../../../model/model.php";
$status = $_POST['status'];
$array_s = array();
$temp_arr = array();
$query = "select * from tax_master where 1 ";
if($status != ""){
	$query .= " and status='$status'";
}
$count = 0;
$sq_taxes = mysqlQuery($query);
while($row_taxes = mysqli_fetch_assoc($sq_taxes)){
	$bg = ($row_taxes['status']=="Inactive") ? "danger" : "";
	$rate = ($row_taxes['rate_in'] == "Percentage") ? $row_taxes['rate'].'(%)': $row_taxes['rate'];
	$temp_arr = array("data" =>array(
		(int)($row_taxes['entry_id']).'<input type="hidden" id="'.$row_taxes['entry_id'].'" value="'.$row_taxes['name'].'" />',
		$row_taxes['code'],$row_taxes['name'],$rate,
		'<button class="btn btn-info btn-sm" onclick="update_modal('.$row_taxes['entry_id'] .')" data-toggle="tooltip" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
		<button class="btn btn-info btn-sm" onclick="update_rulemodal('.$row_taxes['entry_id'] .')" data-toggle="tooltip" title="Add Tax Rules"><i class="fa fa-pencil-square-o"></i></button>
		'), "bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>