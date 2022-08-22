<?php
include_once('../../../../model/model.php');
$adult_arr = $_POST['adult_arr'];
$child_arr = $_POST['child_arr'];
$childwo_arr = $_POST['childwo_arr'];
$infant_arr = $_POST['infant_arr'];
$exc_date_arr = $_POST['exc_date_arr'];
$exc_arr = $_POST['exc_arr'];
$transfer_arr = $_POST['transfer_arr'];
$amount_arr = array();

//Get selected currency rate
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'] ? 1 : 0; //1 is need to stop Uncaught DivisionByZeroError

for($i=0;$i<sizeof($exc_arr);$i++){

	$exc_date = date('Y-m-d',strtotime($exc_date_arr[$i]));
	$sq_excursion = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$exc_arr[$i]'"));
	
	$currency_id = $sq_excursion['currency_code'];
	$sq_from = mysqli_fetch_assoc(mysqlQuery("select currency_rate from roe_master where currency_id='$currency_id'"));
	$from_currency_rate = $sq_from['currency_rate'];

	$sq_costing = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff_basics where exc_id='$exc_arr[$i]' and transfer_option='$transfer_arr[$i]' and (from_date <='$exc_date' and to_date>='$exc_date')"));
	$child_cost = ($to_currency_rate!=0) ?($from_currency_rate / $to_currency_rate) * $sq_costing['child_cost'] : 0;

	//If adults are there
	$total_adult = $adult_arr[$i];
	if($total_adult != 0)
		$adult_cost = ($to_currency_rate!=0) ?($from_currency_rate / $to_currency_rate) * $sq_costing['adult_cost'] : 0;
	else
		$adult_cost = 0;
	//If infants are there
	$total_infant = $infant_arr[$i];
	if($total_infant != 0)
		$infant_cost = ($to_currency_rate!=0) ?($from_currency_rate / $to_currency_rate) * $sq_costing['infant_cost'] : 0;
	else
		$infant_cost = 0;
	//If child with bed are there
	$children_with_bed = $child_arr[$i];
	if($children_with_bed != 0)
		$child_cost1 = ($child_cost * $children_with_bed);
	else
		$child_cost1 = 0;
	//If child without bed are there
	$children_without_bed = $childwo_arr[$i];
	if($children_without_bed != 0)
		$child_costwo1 = ($child_cost * $children_without_bed);
	else
		$child_costwo1 = 0;

	$total_cost = ($adult_cost * $total_adult) + $child_cost1 + $child_costwo1 + ($infant_cost * $total_infant);

	$arr = array('total_cost' => floatval($total_cost),
				'adult_cost' => floatval($adult_cost) * intval($total_adult),
				'child_cost' => floatval($child_cost) * intval($children_with_bed),
				'childwo_cost' => floatval($child_cost) * intval($children_without_bed),
				'infant_cost' => floatval($infant_cost) * intval($total_infant));
    
	array_push($amount_arr, $arr);
}
echo json_encode($amount_arr);
?>