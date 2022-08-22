<?php
include "../../../model/model.php";

$array_s = array();
$temp_arr = array();
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$query = "select * from bike_tariff where 1 ";
if($from_date != '' && $to_date != ''){
	$from_date1 = date('Y-m-d', strtotime($from_date));
	$to_date1 = date('Y-m-d', strtotime($to_date));
	$query .= "  and (created_at>='$from_date1' and created_at<='$to_date1') ";
}
$query .= ' order by entry_id desc';
$sq_query = mysqlQuery($query);

$count = 0;
while($row_req = mysqli_fetch_assoc($sq_query)){

	$sq_currency = mysqli_fetch_assoc(mysqlQuery("select currency_code from currency_name_master where id='$row_req[currency_id]'"));
	$sq_veh = mysqli_fetch_assoc(mysqlQuery("select bike_name,bike_type from bike_master where entry_id='$row_req[bike_id]'"));
	$sq_type = mysqli_fetch_assoc(mysqlQuery("select bike_type from bike_type_master where entry_id='$sq_veh[bike_type]'"));
	
	$temp_arr = array( "data" => array(
		(int)(++$count),
		$sq_veh['bike_name'].'('.$sq_type['bike_type'].')',
		$sq_currency['currency_code'],

		'<button style="display:inline-block" data-toggle=tooltip" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="tredit_modal(\''.$row_req['entry_id'].'\')" data-toggle="tooltip" title="Edit Details"></i></button>
		<button style="display:inline-block" class="btn btn-info btn-sm" onclick="view_modal(\''.$row_req['entry_id'].'\',\''.$row_req['bike_id'].'\')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>
		
		'), "bg" => '');
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);	
?>	