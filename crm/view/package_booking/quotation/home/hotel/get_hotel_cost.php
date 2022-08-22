<?php
include_once('../../../../../model/model.php');
//Get selected currency rate
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'] ?: 1;  //1 is need to stop Uncaught DivisionByZeroError

$hotel_id_arr = $_POST['hotel_id_arr'] ?: [];
$room_cat_arr = $_POST['room_cat_arr'];
$check_in_arr = $_POST['check_in_arr'];
$check_out_arr = $_POST['check_out_arr'];
$total_rooms_arr = $_POST['total_rooms_arr'];
$extra_bed_arr = $_POST['extra_bed_arr'];
$child_with_bed = $_POST['child_with_bed'];
$child_without_bed = $_POST['child_without_bed'];
$adult_count = $_POST['adult_count'];
$package_id_arr = $_POST['package_id_arr'];
$checked_arr = $_POST['checked_arr'];

$hotel_arr = array();

for($i=0;$i<sizeof($hotel_id_arr);$i++){

	$hotel_cost_arr = array();
	$hotel_cost = 0;
	$adult_cost = 0;
	$cwb_cost = 0;
	$cwob_cost = 0;
	$room_cost = 0;
	$cwb_cost = 0;
	$cwob_cost = 0;
	$extra_bed_cost = 0;
	//Array of Check-in and Check-out date
	$checkDate_array = array();
	$check_in = strtotime($check_in_arr[$i]);
	$check_out =strtotime($check_out_arr[$i]);
	for ($i_date=$check_in; $i_date<=$check_out; $i_date+=86400){
		array_push($checkDate_array,date("Y-m-d", $i_date));  
	}
	if($checked_arr[$i] === 'true'){

		$row_tariff_count = mysqli_num_rows(mysqlQuery("select * from hotel_vendor_price_master where 1 and hotel_id='$hotel_id_arr[$i]' order by pricing_id desc"));
		if($row_tariff_count > 0){

			$row_tariff_master1 = mysqlQuery("select * from hotel_vendor_price_master where 1 and hotel_id='$hotel_id_arr[$i]' order by pricing_id desc");
			while($row_tariff_master = mysqli_fetch_assoc($row_tariff_master1)){

				$currency_id = $row_tariff_master['currency_id'];
				$sq_from = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];

				for($i_date=0; $i_date<sizeof($checkDate_array)-1; $i_date++){

					$blackdated_count = mysqli_num_rows(mysqlQuery("select * from hotel_blackdated_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]')"));
					$day = date("l", strtotime($checkDate_array[$i_date]));
					$weekenddated_count = mysqli_num_rows(mysqlQuery("select * from hotel_weekend_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and day='$day'"));
					$contracted_count = mysqli_num_rows(mysqlQuery("select * from hotel_contracted_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]')"));
					if($blackdated_count>0){
									
						$sq_tariff = mysqli_fetch_assoc(mysqlQuery("select * from hotel_blackdated_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]') "));
						$arr = array(
							'room_cost' =>  ($from_currency_rate / $to_currency_rate) * $sq_tariff['double_bed'],
							'child_with_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['child_with_bed'],
							'child_without_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['child_without_bed'],
							'extra_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['extra_bed'],
						);
						array_push($hotel_cost_arr, $arr);
					}
					else if($weekenddated_count>0){
									
						$sq_tariff = mysqli_fetch_assoc(mysqlQuery("select * from hotel_weekend_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and day='$day' "));
						$arr = array(
							'room_cost' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['double_bed'],
							'child_with_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['child_with_bed'],
							'child_without_bed' =>($from_currency_rate / $to_currency_rate) *  $sq_tariff['child_without_bed'],
							'extra_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['extra_bed'],
						);
						array_push($hotel_cost_arr, $arr);
					}
					else if($contracted_count>0){
									
						$sq_tariff =mysqli_fetch_assoc(mysqlQuery("select * from hotel_contracted_tarrif where pricing_id='$row_tariff_master[pricing_id]' and room_category = '$room_cat_arr[$i]' and (from_date <='$checkDate_array[$i_date]' and to_date>='$checkDate_array[$i_date]') "));
						$arr = array(
							'room_cost' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['double_bed'],
							'child_with_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['child_with_bed'],
							'child_without_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['child_without_bed'],
							'extra_bed' => ($from_currency_rate / $to_currency_rate) * $sq_tariff['extra_bed'],
						);
						array_push($hotel_cost_arr, $arr);
					}
					else{
						break;
					}
				}
				$hotel_cost_arr = $hotel_cost_arr ? $hotel_cost_arr : [];
				if(sizeof($hotel_cost_arr) >0){
					for($j=0;$j<sizeof($hotel_cost_arr);$j++){
						$room_cost = $room_cost + $hotel_cost_arr[$j]['room_cost'];
						$cwb_cost = $cwb_cost + $hotel_cost_arr[$j]['child_with_bed'];
						$cwob_cost = $cwob_cost + $hotel_cost_arr[$j]['child_without_bed'];
						$extra_bed_cost = $extra_bed_cost + $hotel_cost_arr[$j]['extra_bed'];
					}
					$total_rooms_arr[$i] = ($total_rooms_arr[$i] == '') ? 0 : $total_rooms_arr[$i];
					$child_with_bed = ($child_with_bed == '') ? 0 : $child_with_bed;
					$child_without_bed = ($child_without_bed == '') ? 0 : $child_without_bed;
					$extra_bed_arr[$i] = ($extra_bed_arr[$i] == '') ? 0 : $extra_bed_arr[$i];
					if($total_rooms_arr[$i]!=0){

						//Group Costing
						$hotel_cost = ($total_rooms_arr[$i] * $room_cost) + ($child_without_bed * $cwob_cost) + ($child_with_bed * $cwb_cost) + ($extra_bed_arr[$i] * $extra_bed_cost);
						//Per Person costing
						$adult_cost = ($adult_count != 0) ? $adult_cost + (($total_rooms_arr[$i] * $room_cost) + ($extra_bed_arr[$i] * $extra_bed_cost)) / ($adult_count) : 0;
						$cwb_cost = ($child_with_bed != 0) ?($child_with_bed * $cwb_cost) / $child_with_bed :0;
						$cwob_cost = ($child_without_bed != 0) ?($child_without_bed * $cwob_cost) / $child_without_bed :0;
					}
				}
				if($blackdated_count > 0 || $weekenddated_count > 0 || $contracted_count > 0){
					array_push($hotel_arr,
						array(
							'hotel_id'=>$hotel_id_arr[$i],
							'hotel_cost'=>$hotel_cost,
							'adult_cost'=>$adult_cost,
							'child_with_bed'=>$cwb_cost,
							'child_without_bed'=>$cwob_cost,
							'package_id'=>$package_id_arr[$i],
							'flag'=>'true'
						)
					);
					break;
				}else{
					array_push($hotel_arr,
						array(
							'hotel_id'=>$hotel_id_arr[$i],
							'hotel_cost'=>0,
							'adult_cost'=>0,
							'child_with_bed'=>0,
							'child_without_bed'=>0,
							'package_id'=>$package_id_arr[$i],
							'flag'=>'false'
						)
					);
					break;
				}
			}
		}else{
			array_push($hotel_arr,
			array(
				'hotel_id'=>$hotel_id_arr[$i],
				'hotel_cost'=>0,
				'adult_cost'=>0,
				'child_with_bed'=>0,
				'child_without_bed'=>0,
				'package_id'=>$package_id_arr[$i],
				'flag'=>'false'
			)
			);
		}
	}else{
		array_push($hotel_arr,
		array(
			'hotel_id'=>$hotel_id_arr[$i],
			'hotel_cost'=>0,
			'adult_cost'=>0,
			'child_with_bed'=>0,
			'child_without_bed'=>0,
			'package_id'=>$package_id_arr[$i],
			'flag'=>'false'
		)
		);
	}
}

echo json_encode($hotel_arr);
exit;
?>