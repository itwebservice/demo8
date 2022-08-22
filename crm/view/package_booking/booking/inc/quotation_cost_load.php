<?php
include "../../../../model/model.php";
$quotation_id = $_POST['quotation_id'];
$package_type = $_POST['package_type'];
$quot_info_arr = array();
$hotel_info_arr = array();

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));

$sq_costing = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id' and package_type='$package_type'"));

$quot_info_arr['tour_cost'] = $sq_costing['tour_cost'] + $sq_costing['transport_cost'] + $sq_costing['excursion_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'] + $sq_quotation['visa_cost'];
$quot_info_arr['markup_cost'] = $sq_costing['markup_subtotal'];
$quot_info_arr['taxation_id'] = $sq_costing['taxation_id'];
$quot_info_arr['service_charge'] = $sq_costing['service_charge'];

$quot_info_arr['tax_type'] =  '';
$quot_info_arr['tax_in_percentage'] = '';
$quot_info_arr['service_tax'] = $sq_costing['service_tax'];

$quot_info_arr['service_tax_subtotal'] = $sq_costing['service_tax_subtotal'];
$quot_info_arr['total_tour_cost'] = $sq_costing['total_tour_cost'] + $sq_quotation['guide_cost']+ $sq_quotation['misc_cost'];

$sq_hotel = mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id' and package_type='$package_type'");
while($row_hotel = mysqli_fetch_assoc($sq_hotel)){

	$sq_hotel_id = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id = '$row_hotel[hotel_name]'"));
	$hotel_name1 = $sq_hotel_id['hotel_name'];
	$sq_city_id = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id = '$row_hotel[city_name]'"));
	$city_name1 = $sq_city_id['city_name'];

	$arr2 = array(
		'city_id' => $row_hotel['city_name'],
		'city_name' => $city_name1,
		'from_date' => $quot_info_arr['from_date'],
		'to_date' => $quot_info_arr['to_date'],
		'hotel_id1' => $row_hotel['hotel_name'],
		'hotel_name1' => $hotel_name1,
		'total_rooms' => $row_hotel['total_rooms'],
		'check_in' => get_date_user($row_hotel['check_in']),
		'check_out' => get_date_user($row_hotel['check_out']),
		'room_category' => $row_hotel['room_category']
	);
	array_push($hotel_info_arr, $arr2);
}
$quot_info_arr['hotel_info_arr'] = $hotel_info_arr;

echo json_encode($quot_info_arr);
?>