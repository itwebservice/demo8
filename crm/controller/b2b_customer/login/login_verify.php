<?php
include "../../../model/model.php";
global $secret_key, $encrypt_decrypt;
$password=mysqlREString($_POST['password']);
$username=mysqlREString($_POST['username']);
$agent_code=mysqlREString($_POST['agent_code']);

$username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
$password = $encrypt_decrypt->fnEncrypt($password, $secret_key);

$row_count=mysqli_num_rows(mysqlQuery("select * from b2b_registration where username='$username' and password='$password' and agent_code='$agent_code' and active_flag='Active' and approval_status='Approved'"));
if($row_count>0){

	$sq = mysqli_fetch_assoc(mysqlQuery("select * from b2b_registration where username='$username' and password='$password' and agent_code='$agent_code' and active_flag='Active' and approval_status='Approved'"));
	$register_id = $sq['register_id'];
	$customer_id = $sq['customer_id'];

	$_SESSION['b2b_agent_code'] = $agent_code;
	$_SESSION['b2b_username'] = $username;
	$_SESSION['b2b_password'] = $password;
	$_SESSION['register_id'] = $register_id; 
	$_SESSION['company_name'] = $sq['company_name'];
	$_SESSION['customer_id'] = $customer_id;
	global $currency;
	$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
	$to_currency_rate = $sq_to['currency_rate'];

	//Get Approved Credit Limit Amount
	$sq_credit = mysqli_fetch_assoc(mysqlQuery("select credit_amount from b2b_creditlimit_master where register_id='$register_id' and approval_status='Approved' order by entry_id desc"));
	//Get Booking + Payment amount to calculate outstanding amount
	$sq_booking = mysqlQuery("select * from b2b_booking_master where customer_id='$customer_id' and status!='Cancel'");
	$net_total = 0;
	$paid_amount = 0;
	$servie_total = 0;
	while($row_booking = mysqli_fetch_assoc($sq_booking)){

		$cart_checkout_data = ($row_booking['cart_checkout_data']!='' && $row_booking['cart_checkout_data'] != 'null')?json_decode($row_booking['cart_checkout_data']):[];
		$hotel_total = 0;
		$transfer_total = 0;
		$activity_total = 0;
		$tours_total = 0;
		$ferry_total = 0;
		for($i=0;$i<sizeof($cart_checkout_data);$i++){

			if($cart_checkout_data[$i]->service->name == 'Hotel'){
				$tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
				for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
					$room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
					$room_cost = $room_types[2];
					$h_currency_id = $room_types[3];
					$tax_amount = 0;
				
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
						if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
						}
					}
					$total_amount = $room_cost + $tax_amount;
					//Convert into default currency
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$total_amount = ($to_currency_rate!='0') ? ($from_currency_rate / $to_currency_rate * $total_amount):0;
					
					$hotel_total += $total_amount;
				}
			}
			if($cart_checkout_data[$i]->service->name == 'Transfer'){
		
				$services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
				for($j=0;$j<count(array($services));$j++){
					$tax_amount = 0;
					$tax_arr = explode(',',$services->service_arr[$j]->taxation);
					$transfer_cost = explode('-',$services->service_arr[$j]->transfer_cost);
					$room_cost = $transfer_cost[0];
					$h_currency_id = $transfer_cost[1];
					
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
					if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
						$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
						$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
					}
					}
					$total_amount = $room_cost + $tax_amount;
		
					//Convert into default currency
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$total_amount = ($to_currency_rate!='0') ? ($from_currency_rate / $to_currency_rate * $total_amount):0;
				
					$transfer_total += $total_amount;
				}
			}
			if($cart_checkout_data[$i]->service->name == 'Activity'){
				$services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
				for($j=0;$j<count(array($services));$j++){
					$tax_amount = 0;
					$tax_arr = explode(',',$services->service_arr[$j]->taxation);
					$transfer_cost = explode('-',$services->service_arr[$j]->transfer_type);
					$room_cost = $transfer_cost[1];
					$h_currency_id = $transfer_cost[2];
					
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
						if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] === "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
						}
					}
					$total_amount = $room_cost + $tax_amount;
	
					//Convert into default currency
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$total_amount = ($to_currency_rate!='0') ? ($from_currency_rate / $to_currency_rate * $total_amount):0;
				
					$activity_total += $total_amount;
				}
			}
			if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			
				$services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
				for($j=0;$j<count(array($services));$j++){
				
					$tax_amount = 0;
					$tax_arr = explode(',',$services->service_arr[$j]->taxation);
					$package_item = explode('-',$services->service_arr[$j]->package_type);
					$room_cost = $package_item[1];
					$h_currency_id = $package_item[2];
					
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
						if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
						}
					}
					$total_amount = $room_cost + $tax_amount;
	
					//Convert into default currency
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$total_amount = ($to_currency_rate!='0') ? ($from_currency_rate / $to_currency_rate * $total_amount):0;
				
					$tours_total += $total_amount;
				}
			}
			if($cart_checkout_data[$i]->service->name == 'Ferry'){
			
				$services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
				for($j=0;$j<count(array($services));$j++){
				
					$tax_amount = 0;
					$tax_arr = explode(',',$services->service_arr[$j]->taxation);
					$package_item = explode('-',$services->service_arr[$j]->total_cost);
					$room_cost = $package_item[0];
					$h_currency_id = $package_item[1];
					
					$tax_arr1 = explode('+',$tax_arr[0]);
					for($t=0;$t<sizeof($tax_arr1);$t++){
						if($tax_arr1[$t]!=''){
						$tax_arr2 = explode(':',$tax_arr1[$t]);
						if($tax_arr2[2] == "Percentage"){
							$tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
						}else{
							$tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
						}
						}
					}
					$total_amount = $room_cost + $tax_amount;
	
					//Convert into default currency
					$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
					$from_currency_rate = $sq_from['currency_rate'];
					$total_amount = ($to_currency_rate!='0') ? ($from_currency_rate / $to_currency_rate * $total_amount):0;
				
					$ferry_total += $total_amount;
				}
			}
		}
		$net_total += $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
		if($row_booking['coupon_code'] != ''){
			$sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
			$sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_booking[coupon_code]'"));
			if($sq_hotel_count > 0){
				$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_booking[coupon_code]'"));
			}else if($sq_exc_count > 0){
				$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_booking[coupon_code]'"));
			}else{
				$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$row_booking[coupon_code]'"));
		}
		if($sq_coupon['offer']=="Flat"){
			$net_total = $net_total - $sq_coupon['offer_amount'];
		}else{
			$net_total = $net_total - ($net_total*$sq_coupon['offer_amount']/100);
		}
		}
        // Paid Amount
        $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
        $payment_amount = $sq_payment_info['sum'];
        $paid_amount +=$sq_payment_info['sum'];

	}
	$outstanding =  $net_total - $paid_amount;
	$available_credit = $sq_credit['credit_amount'] - $outstanding;
	$available_credit = ($available_credit < 0)? 0.00 : $available_credit;
	$_SESSION['credit_amount'] = $available_credit;

	$cart_data = ($sq['cart_data']!='')?json_encode($sq['cart_data']):json_encode([]);
	echo "valid--".$cart_data;
}	
else{
	echo "Invalid Login Credentials!--";
}
?>