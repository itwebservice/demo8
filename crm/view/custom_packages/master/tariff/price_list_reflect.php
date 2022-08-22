<?php
include "../../../../model/model.php";

$dest_id = $_POST['dest_id'];
$array_s = array();
$temp_arr = array();
$count = 0;

$query = "select * from custom_package_master where package_id in (select distinct package_id from custom_package_tariff where 1) "; 
if($dest_id != '') { 
	$query .= " and dest_id = '$dest_id'";
}
$query .= ' order by package_id desc';
$sq_query_login = mysqlQuery($query);

while($row_req = mysqli_fetch_assoc($sq_query_login)){

	$temp_arr = array( "data" => array(
		(int)(++$count),
		$row_req['package_name'].'('.$row_req['package_code'] .')',
		$row_req['total_days'].'D/'.$row_req['total_nights'].'N',
		'<button style="display:inline-block" class="btn btn-info btn-sm" onclick="view_modal(\''.$row_req['package_id'].'\')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>
		<form style="display:inline-block" action="tariff/update/index.php" id="frm_booking_'.$count.'" method="POST">
			<input style="display:inline-block" type="hidden" id="package_id" name="package_id" value="'.$row_req['package_id'].'">
			<button style="display:inline-block" data-toggle=tooltip" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" title="Update Details"></i></button>
		</form>
		'), "bg" => $bg);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);	
?>	