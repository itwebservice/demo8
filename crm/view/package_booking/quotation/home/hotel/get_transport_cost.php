<?php
include_once('../../../../../model/model.php');

//Get selected currency rate
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$transport_id_arr = $_POST['transport_id_arr'] ?: [];
$travel_date_arr = $_POST['travel_date_arr'];
$pickup_arr = $_POST['pickup_arr'];
$drop_arr = $_POST['drop_arr'];
$pickup_id_arr = $_POST['pickup_id_arr'];
$drop_id_arr = $_POST['drop_id_arr'];
$vehicle_count_arr = $_POST['vehicle_count_arr'];
$ppackage_id_arr = $_POST['ppackage_id_arr'];
$ppackage_name_arr = $_POST['ppackage_name_arr'];

$transport_info_arr = array();
$transport_info_arr1 = array();
for($i=0;$i<sizeof($transport_id_arr);$i++){
	
	$count=0;
	$from_date = get_date_db($travel_date_arr[$i]);
	$q_transport = mysqli_fetch_assoc(mysqlQuery("select vehicle_name,entry_id from b2b_transfer_master where entry_id='$transport_id_arr[$i]'"));

	$tariffc = mysqli_num_rows(mysqlQuery("select tariff_id from b2b_transfer_tariff where vehicle_id='$transport_id_arr[$i]' order by tariff_id desc"));
	if($tariffc != 0){

		$row_tariff_master1 = mysqlQuery("select tariff_id,currency_id from b2b_transfer_tariff where vehicle_id='$transport_id_arr[$i]' order by tariff_id desc");	
		$vt_count = 0;
		while($row_tariff_master = mysqli_fetch_assoc($row_tariff_master1)){
			
			$tariff_count = mysqli_num_rows(mysqlQuery("select tariff_entries_id from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$pickup_id_arr[$i]' and drop_type = '$drop_id_arr[$i]' and pickup_location = '$pickup_arr[$i]' and drop_location = '$drop_arr[$i]' and (from_date <='$from_date' and to_date>='$from_date') order by tariff_entries_id desc"));
			if($tariff_count != 0){

				$vt_count++;
				$sq_tariff1 = mysqlQuery("select tariff_data from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$pickup_id_arr[$i]' and drop_type = '$drop_id_arr[$i]' and pickup_location = '$pickup_arr[$i]' and drop_location = '$drop_arr[$i]' and (from_date <='$from_date' and to_date>='$from_date') order by tariff_entries_id desc");
				while($sq_tariff = mysqli_fetch_assoc($sq_tariff1)){
					

					$currency_id = $row_tariff_master['currency_id'];
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$tariff_data = json_decode($sq_tariff['tariff_data']);
					$total_cost = ((floatval($from_currency_rate) / floatval($to_currency_rate)) * floatval($tariff_data[0]->total_cost)) * floatval($vehicle_count_arr[$i]);
					$arr1 = array(
						'total_cost'=> $total_cost,
						'skip'=>false
					);
					array_push($transport_info_arr, $arr1);
				}
			}
			else{
				$arr1 = array(
					'total_cost'=> 0,
					'skip'=>true
				);
				array_push($transport_info_arr, $arr1);
			}
		}
		if($vt_count == 0){
			
			$arr1 = array(
				'total_cost'=> 0,
				'skip'=>false
			);
			array_push($transport_info_arr, $arr1);
		}
	}
	else{
		$arr1 = array(
			'total_cost'=> 0,
			'skip'=>false
		);
		array_push($transport_info_arr, $arr1);
	}
}
foreach ($transport_info_arr as $key => $element) {
    if (!$element['skip']) {
		array_push($transport_info_arr1, $transport_info_arr[$key]);
    }
}
echo json_encode($transport_info_arr1);
?>