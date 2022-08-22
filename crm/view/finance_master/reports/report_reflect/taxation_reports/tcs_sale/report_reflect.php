<?php
include "../../../../../../model/model.php";
include_once('../gst_sale/sale_generic_functions.php');

$branch_status = $_POST['branch_status'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$array_s = array();
$temp_arr = array();
$tax_total = 0;
$markup_tax_total = 0;
$count = 1;

$sq_setting = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id='1'"));
$sq_supply = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_setting[state_id]'"));

//GIT Booking
$query = "select * from tourwise_traveler_details where 1 and tcs_tax!='0'  ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and DATE(form_date) between '$from_date' and '$to_date' ";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as booking_count from travelers_details where traveler_group_id ='$row_query[id]'"));

	//Cancelled count
	$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as cancel_count from travelers_details where traveler_group_id ='$row_query[id]' and status ='Cancel'"));
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'] && $row_query['tour_group_status']!="Cancel")
	{
		$sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
		$hsn_code = get_service_info('Group Tour');

		$tax_total += $row_query['tcs_tax'];
		
		$yr = explode("-",$row_query['form_date']);
		$temp_arr = array( "data" => array(
			(int)($count++),
			"Group Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_group_booking_id($row_query['id'],$yr[0]) ,
			get_date_user($row_query['form_date']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			number_format($row_query['net_total'],2) ,
			$row_query['tcs_per'].' %',
			number_format($row_query['tcs_tax'],2),
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}
//FIT Booking
$query = "select * from package_tour_booking_master where 1 and tcs_tax!='0'  ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and booking_date between '$from_date' and '$to_date' ";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
	//Total count
	$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as booking_count from package_travelers_details where booking_id ='$row_query[booking_id]'"));
	//Cancelled count
	$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as cancel_count from package_travelers_details where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
    	$sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
    	$hsn_code = get_service_info('Package Tour');  	

		$tax_total += $row_query['tcs_tax'];

		$yr = explode("-",$row_query['booking_date']);
		$temp_arr = array( "data" => array(
			(int)($count++),
			"Package Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_package_booking_id($row_query['booking_id'],$yr[0]) ,
			get_date_user($row_query['booking_date']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			number_format($row_query['net_total'],2) ,
			$row_query['tcs_per'].' %',
			number_format($row_query['tcs_tax'],2),
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}

//Hotel Booking
$query = "select * from hotel_booking_master where 1 and tcs_tax!='0' ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and created_at between '$from_date' and '$to_date' ";
}	
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
	//Total count
 	$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

 	//Cancelled count
 	$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));
 	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
	{
    	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
    	if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
    		$cust_name = $sq_cust['company_name'];
    	}else{
    		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    	}
    	$hsn_code = get_service_info('Hotel / Accommodation');
    	$sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
		$yr = explode("-",$row_query['created_at']);
		
		$tax_total += $row_query['tcs_tax'];
		
		$temp_arr = array( "data" => array(
			(int)($count++),
			"Hotel Booking",
			$hsn_code ,
			$cust_name,
			($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'] ,
			($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'] ,
			get_hotel_booking_id($row_query['booking_id'],$yr[0]) ,
			get_date_user($row_query['created_at']),
			($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered',
			($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'] ,
			$row_query['total_fee'] ,
			$row_query['tcs_per'].' %',
			number_format($row_query['tcs_tax'],2),
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
}

$footer_data = array("footer_data" => array(
	'total_footers' => 2,
	
	'foot0' => 'Total TCS TAX :',
	'col0' => 12,
	'class0' =>"info text-right",

	'foot1' => number_format($tax_total,2),
	'col1' => 1,
	'class1' =>"info text-left"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	