<?php
$count = 1;
//B2C
$query = "select * from b2c_sale where 1 and customer_id='$customer_id' ";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;
$sq_b2c = mysqlQuery($query);
while($row_b2c = mysqli_fetch_assoc($sq_b2c)){

	$costing_data = json_decode($row_b2c['costing_data']);
	$net_total = $costing_data[0]->net_total;

	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum,sum(`credit_charges`) as sumc from b2c_payment_master where booking_id='$row_b2c[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$paid_amount = $sq_payment_info['sum'];
	//Consider sale cancel amount
	if($row_b2c['status'] == 'Cancel'){ 			
		if($cancel_est['cancel_amount'] <= $total_pay['sum']){
			$pending_amt = 0;
		}
		else{
			$pending_amt =  $cancel_est['cancel_amount'] - $total_pay['sum'] - $total_pay['sumc'];
		}
	}
	else{
		$pending_amt= floatval($net_total) - floatval($paid_amount);
	}
	if($pending_amt>'0'){
	?>
	<tr>
		<td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "B2C Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_b2c['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $pending_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php 
	}
}

//B2B
$query = "select * from b2b_booking_master where 1 and customer_id='$customer_id' and status!='Cancel'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$sq_b2b = mysqlQuery($query);
while($row_b2b = mysqli_fetch_assoc($sq_b2b)){
	$hotel_total = 0;
	$transfer_total = 0;
	$activity_total = 0;
	$tours_total = 0;
	$ferry_total = 0;
	$servie_total = 0;
	$cart_checkout_data = ($row_b2b['cart_checkout_data'] != '' && $row_b2b['cart_checkout_data'] != 'null') ? json_decode($row_b2b['cart_checkout_data']) : [];
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
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
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
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
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
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$activity_total += $total_amount;
			}
		}
		if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			$services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
			for($j=0;$j<count(array($services));$j++){
				$tax_amount = 0;
				$taxation_arr = explode(',',$services->service_arr[$j]->taxation);
				$package_item = explode('-',$services->service_arr[$j]->package_type);
				$room_cost = $package_item[1];
				$h_currency_id = $package_item[2];
				
				$tax_arr1 = explode('+',$taxation_arr[0]);
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
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
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
							$tax_amount = $tax_amount + ($room_cost + $tax_arr2[1]);
						}
					}
				}
				$total_amount = $room_cost + $tax_amount;

				//Convert into default currency
				$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
			
				$ferry_total += $total_amount;
			}
		}
	}

	$servie_total = $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
	if($row_b2b['coupon_code'] != ''){

		$sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_b2b[coupon_code]'"));
		$sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_b2b[coupon_code]'"));
		
		if($sq_hotel_count > 0){
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_b2b[coupon_code]'"));
		}else if($sq_exc_count > 0){
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_b2b[coupon_code]'"));
		}else{
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$row_b2b[coupon_code]'"));
    	}
		if($sq_coupon['offer']=="Flat"){
			$servie_total = $servie_total - $sq_coupon['offer_amount'];
		}else{
			$servie_total = $servie_total - ($servie_total * $sq_coupon['offer_amount']/100);
		}
	}
	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_b2b[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum'];
	$bal_amt = $servie_total-$sq_payment_info['sum'];
   	if((int)$bal_amt>0){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "B2B Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_b2b['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= round($bal_amt,2) ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//FIT
	$query = "select * from package_tour_booking_master where 1 and customer_id='$customer_id' ";
	$booking_amt =0;
	$pending_amt=0;
	$sq_booking = mysqlQuery($query);
	while($row_booking = mysqli_fetch_assoc($sq_booking)){

		$cancel_est=mysqli_fetch_assoc(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_booking[booking_id]'"));
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum,sum(credit_charges) as sumc from package_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

		$booking_amt=$row_booking['net_total']+$total_pay['sumc'];
		$total_purches=$booking_amt;
		//Consider sale cancel amount
		if($cancel_est['cancel_amount'] != ''){ 			
			if($cancel_est['cancel_amount'] <= $total_pay['sum']){
				$pending_amt = 0;
			}
			else{
				$pending_amt =  $cancel_est['cancel_amount'] - $total_pay['sum'] - $total_pay['sumc'];
			}
		}
		else{
			$pending_amt=$total_purches-$total_pay['sum'] -$total_pay['sumc'];
		}
		if($pending_amt>'0'){
		?>
		<tr>
		    <td class="col-md-2"><?= $count++ ?></td>
			<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Package Booking" ?>" class="form-control" readonly></td>
			<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
			<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $pending_amt ?>" class="text-right form-control" readonly></td>
			<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
		</tr>
	<?php 
		}
	}
//visa
$query = "select * from visa_master where 1 and customer_id='$customer_id'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;

$sq_visa = mysqlQuery($query);
while($row_visa = mysqli_fetch_assoc($sq_visa)){	
	
	$sq_entries = mysqli_num_rows(mysqlQuery("select * from visa_master_entries where visa_id ='$row_visa[visa_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from visa_master_entries where visa_id ='$row_visa[visa_id]' and status='Cancel'"));  
   	//Get Total visa cost
	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from visa_payment_master where visa_id='$row_visa[visa_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
    $visa_total_amount=$row_visa['visa_total_cost']+$sq_payment_info['sumc'];	   
	//Get total refund amount
	$cancel_amount=$row_visa['cancel_amount'];	

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = 0;
		}
		else{
			$bal_amt =  $cancel_amount - $sq_payment_info['sum']-$sq_payment_info['sumc'];
		}
	}
	else{
		$bal_amt = $visa_total_amount-$sq_payment_info['sum']-$sq_payment_info['sumc']; 
	}
	if($bal_amt>'0' && $sq_entries != $sq_entries_cancel){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Visa Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_visa['visa_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Air Ticket
$query = "select * from ticket_master where 1 and customer_id='$customer_id' ";
$sq_ticket = mysqlQuery($query);
while($row_ticket = mysqli_fetch_assoc($sq_ticket)){

	$sq_entries = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id ='$row_ticket[ticket_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id ='$row_ticket[ticket_id]' and status='Cancel'"));  
	$sq_paid_amount = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from ticket_payment_master where ticket_id='$row_ticket[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

	$paid_amount = $sq_paid_amount['sum']+$sq_paid_amount['sumc'];
	$sale_amount = $row_ticket['ticket_total_cost']+$sq_paid_amount['sumc'];

	//Consider sale cancel amount
	if($row_ticket['cancel_amount'] != '0'){ 
		if($row_ticket['cancel_amount'] <= $paid_amount){
			$bal_amount = '0';
		}
		else{
			$bal_amount =  $row_ticket['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$bal_amount = $sale_amount - $paid_amount;
	}

	if($bal_amount>'0' && $sq_entries != $sq_entries_cancel){
	?>		
	<tr>
		<td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Air Ticket Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ticket['ticket_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amount ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
<?php
}
}
//Train ticket
$query = "select * from train_ticket_master where 1 and customer_id='$customer_id'";
$sq_ticket = mysqlQuery($query);
while($row_ticket = mysqli_fetch_assoc($sq_ticket)){
	
	$sq_entries = mysqli_num_rows(mysqlQuery("select * from train_ticket_master_entries where train_ticket_id ='$row_ticket[train_ticket_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from train_ticket_master_entries where train_ticket_id ='$row_ticket[train_ticket_id]' and status='Cancel'"));  
	$sq_payment = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum_pay,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$row_ticket[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

	$paid_amount = $sq_payment['sum_pay'] + $sq_payment['sumc'];
	$sale_amount = $row_ticket['net_total'] + $sq_payment['sumc'];	

	//Consider sale cancel amount
	if($row_ticket['cancel_amount'] != '0'){ 
		if($row_ticket['cancel_amount'] <= $paid_amount){
			$bal = '0';
		}
		else{
			$bal =  $row_ticket['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$bal = $sale_amount - $paid_amount;
	}
	if($bal>'0' && $sq_entries != $sq_entries_cancel){
	?>		
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Train Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ticket['train_ticket_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Hotel 
$query = "select * from hotel_booking_master where 1 and customer_id='$customer_id' ";
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){

	$sq_entries = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id ='$row_booking[booking_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id ='$row_booking[booking_id]' and status='Cancel'"));  
	$sq_payment_total = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$paid_amount = $sq_payment_total['sum'];			
	$total_paid += $sq_payment_total['sum'];
	$sale_bal = $row_booking['total_fee'];
	
	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $paid_amount){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $paid_amount;
		}
	}
	else{
		$total_bal = $sale_bal - $paid_amount;
	}
	if($total_bal>'0' && $sq_entries != $sq_entries_cancel){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Hotel Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Bus
$query = "select * from bus_booking_master where 1 and customer_id='$customer_id' ";

$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){

	$sq_entries = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id ='$row_booking[booking_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id ='$row_booking[booking_id]' and status='Cancel'"));  
	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from bus_booking_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_purchase = $row_booking['net_total']+$sq_payment_info['sumc'];

	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
	
	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $sq_payment_info['sum']){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $sq_payment_info['sum']-$sq_payment_info['sumc'];
		}
	}
	else{
		$total_bal=$total_purchase-$sq_payment_info['sum']-$sq_payment_info['sumc'];
	}
	if($total_bal>'0' && $sq_entries != $sq_entries_cancel){	
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Bus Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Car Rental
$query = "select * from car_rental_booking where 1 and customer_id='$customer_id' and status!='Cancel'";
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{
	$total_purchase=$row_booking['total_fees'];

	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from car_rental_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum'];

	//Consider sale cancel amount
	if($row_booking['cancel_amount'] != '0'){ 
		if($row_booking['cancel_amount'] <= $sq_payment_info['sum']){
			$total_bal = '0';
		}
		else{
			$total_bal =  $row_booking['cancel_amount'] - $sq_payment_info['sum'];
		}
	}
	else{
		$total_bal=$total_purchase-$sq_payment_info['sum'];	
	}

	if($total_bal>'0'){
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Car Rental Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_booking['booking_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $total_bal ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Group
$cancel_amount = 0;
$query = "select * from tourwise_traveler_details where 1 and customer_id='$customer_id'";
$sq1 =mysqlQuery($query);
while($row1 = mysqli_fetch_assoc($sq1))
{
	$tourwise_id = $row1['id'];
	$sale_total_amount = $row1['net_total'];
	$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
	$paid_amount = $query['sum'];
	$paid_amount = ($paid_amount == '')?'0':$paid_amount;

	if($row1['tour_group_status'] == 'Cancel'){
		//Group Tour cancel
		$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
		if($cancel_tour_count2 >= '1'){
			$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$tourwise_id'"));
			$cancel_amount2 = $cancel_tour['cancel_amount'];
		}
		else{ $cancel_amount2 = 0; }

		if($cancel_esti_count1 >= '1'){
			$cancel_amount = $cancel_amount1;
		}else{
			$cancel_amount = $cancel_amount2;
		}	
	}
	else{
		// Group booking cancel
		$cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_id'"));
		if($cancel_esti_count1 >= '1'){
			$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_id'"));
			$cancel_amount = $cancel_esti1['cancel_amount'];
		}
		else{ $cancel_amount = 0; }

	}

	$cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;

	if($row1['tour_group_status'] == 'Cancel'){
		if($cancel_amount > $paid_amount){
			$balance_amount = $cancel_amount - $paid_amount;
		}
		else{
			$balance_amount = 0;
		}
	}
	else{
		if($cancel_esti_count1 >= '1'){
			if($cancel_amount > $paid_amount){
				$balance_amount = $cancel_amount - $paid_amount;
			}
			else{
				$balance_amount = 0;
			}
		}
		else{
			$balance_amount = $sale_total_amount - $paid_amount;
		}
	}
	if($row1['tour_group_status'] != 'Cancel' && $cancel_esti_count1 == 0)
	if($balance_amount>'0'){
	?>
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Group Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $tourwise_id ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $balance_amount ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php	
	}
}
//Excursion
$query = "select * from excursion_master where 1 and customer_id='$customer_id'";
$sq_ex = mysqlQuery($query);
while($row_ex= mysqli_fetch_assoc($sq_ex)){

	$sq_entries = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id ='$row_ex[exc_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id ='$row_ex[exc_id]' and status='Cancel'"));
    //Get Total cost
    $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from exc_payment_master where exc_id='$row_ex[exc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum'];

    $ex_total_amount=$row_ex['exc_total_cost'];
    
	//Get total refund amount
	$cancel_amount=$row_ex['cancel_amount'];
	
    $total_ex_amount=$ex_total_amount;
    
    $total_amount=$total_amount+$ex_total_amount;

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = '0';
		}
		else{
			$bal_amt = $cancel_amount - $sq_payment_info['sum'];
		}
	}
	else{
    	$bal_amt = $total_ex_amount - $sq_payment_info['sum'];
	}
	if($bal_amt>'0' && $sq_entries != $sq_entries_cancel){
	?>		
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Excursion Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_ex['exc_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
//Miscellaneous
$query = "select * from miscellaneous_master where 1 and customer_id='$customer_id'";
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;

$sq_misc = mysqlQuery($query);
while($row_msc = mysqli_fetch_assoc($sq_misc)){
	
	$sq_entries = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries where misc_id ='$row_msc[misc_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries where misc_id ='$row_msc[misc_id]' and status='Cancel'"));
   //Get Total Miscellaneous cost
    $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_msc[misc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
	$total_paid +=$sq_payment_info['sum']+$sq_payment_info['sumc'];
    $misc_total_amount=$row_msc['misc_total_cost']+$sq_payment_info['sumc'];	   
	//Get total refund amount
	$cancel_amount=$row_msc['cancel_amount'];	

	//Consider sale cancel amount
	if($cancel_amount != '0'){ 
		if($cancel_amount <= $sq_payment_info['sum']){
			$bal_amt = 0;
		}
		else{
			$bal_amt =  $cancel_amount - $sq_payment_info['sum'] -$sq_payment_info['sumc'];
		}
	}
	else{
		$bal_amt = $misc_total_amount-$sq_payment_info['sum'] -$sq_payment_info['sumc']; 
	}
	if($bal_amt>'0' && $sq_entries != $sq_entries_cancel){
	?>	
	<tr>
	    <td class="col-md-2"><?= $count++ ?></td>
		<td class="col-md-4"><input type="text" id="pr_payment_type<?= $count ?>" name="pr_payment_type"  value="<?= "Miscellaneous Booking" ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_id<?= $count ?>" name="pr_payment_id"  value="<?= $row_msc['misc_id'] ?>" class="form-control" readonly></td>
		<td class="col-md-2"><input type="text" id="pr_payment_<?= $count ?>" name="pr_payment"  value="<?= $bal_amt ?>" class="text-right form-control" readonly></td>
		<td class="text-center col-md-2"><input type="checkbox" id="chk_pr_payment_<?= $count ?>" name="chk_pr_payment" class="form-control" onchange="calculate_total_purchase('<?= 'pr_payment_'.$count ?>','<?= 'chk_pr_payment_'.$count ?>')"></td>
	</tr>
	<?php
	}
}
?>