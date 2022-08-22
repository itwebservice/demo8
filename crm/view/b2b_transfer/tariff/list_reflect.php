<?php
include "../../../model/model.php";

$array_s = array();
$temp_arr = array();
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$query = "select * from b2b_transfer_tariff where 1 ";
if($from_date != '' && $to_date != ''){
	$from_date1 = date('Y-m-d', strtotime($from_date));
	$to_date1 = date('Y-m-d', strtotime($to_date));
	$query .= "  and (created_at>='$from_date1' and created_at<='$to_date1') ";
}
$query .= ' order by tariff_id desc';
$sq_query = mysqlQuery($query);

$count = 0;
while($row_req = mysqli_fetch_assoc($sq_query)){
	$sq_veh = mysqli_fetch_assoc(mysqlQuery("select vehicle_name from b2b_transfer_master where entry_id='$row_req[vehicle_id]'"));
	$sq_currency = mysqli_fetch_assoc(mysqlQuery("select * from currency_name_master where id='$row_req[currency_id]'"));
	$taxation = json_decode($row_req['taxation']);
	$tax = $taxation[0]->taxation_type.'('.$taxation[0]->service_tax.')';
	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_date_user($row_req['created_at']),
		$sq_veh['vehicle_name'],
		$sq_currency['currency_code'],

		'<button style="display:inline-block" id="edit-'.$row_req['tariff_id'].'" data-toggle=tooltip" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="tredit_modal(\''.$row_req['tariff_id'].'\')" data-toggle="tooltip" title="Edit Details"></i></button>
		<button style="display:inline-block" id="view-'.$row_req['tariff_id'].'" class="btn btn-info btn-sm" onclick="view_modal(\''.$row_req['tariff_id'].'\')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>
		
		'), "bg" => '');
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);	
?>	