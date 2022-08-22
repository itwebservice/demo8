<?php 
$flag = true;
class b2b_refund{

public function refund_save()
{
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$created_at = date('Y-m-d H:i');

	if($refund_mode=="Cheque"){ 
    	$clearance_status = "Pending"; } 
    else {  $clearance_status = ""; } 
    
	$financial_year_id = $_SESSION['financial_year_id'];
	$branch_admin_id = $_SESSION['branch_admin_id'];

	$bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }    

	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(refund_id) as max from b2b_booking_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_payment = mysqlQuery("insert into b2b_booking_refund_master (refund_id, booking_id, financial_year_id, refund_date, refund_amount, refund_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$booking_id', '$financial_year_id', '$refund_date', '$refund_amount', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at') ");

	if($refund_mode == 'Credit Note'){
		$sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
		$customer_id = $sq_b2b_info['customer_id'];

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from credit_note_master"));
		$id = $sq_max['max'] + 1;

		$sq_payment = mysqlQuery("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$id', '$financial_year_id', 'B2B Booking', '$booking_id', '$customer_id','$refund_amount','$refund_id','$refund_date','$branch_admin_id') ");
	}

	if(!$sq_payment){
		rollback_t();
		echo "error--Sorry, Refund not saved!";
		exit;
	}
	else{

		for($i=0; $i<sizeof($entry_id_arr); $i++){

			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from b2b_booking_refund_entries"));
			$id= $sq_max['max'] + 1;;

			$sq_entry = mysqlQuery("insert into b2b_booking_refund_entries(id, refund_id, entry_id) values ('$id', '$refund_id', '$entry_id_arr[$i]')");
			if(!$sq_entry){
				$GLOBALS['flag'] = false;
				echo "error--Some entries not saved!";
				//exit;
			}

		}

		if($refund_mode != 'Credit Note'){
			//Finance save
	    	$this->finance_save($refund_id);

	    }
    	//Bank and Cash Book Save
		$this->bank_cash_book_save($refund_id);
		//refund email to customer
		
		if($refund_amount!=0){
			$this->refund_mail_send($booking_id,$refund_amount,$refund_date,$refund_mode,$transaction_id);
		}

		if($GLOBALS['flag']){
			commit_t();
			echo "Refund has been successfully saved.";
			exit;	
		}
		else{
			rollback_t();
			exit;
		}

	}
}


public function finance_save($refund_id)
{
	$row_spec = 'sales';
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];	
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year2 = explode("-", $refund_date);
  	$yr1 =$year2[0];

	global $transaction_master;

	$sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
  	$customer_id = $sq_b2b_info['customer_id'];
	$year = explode("-", $sq_b2b_info['created_at']);
	$yr =$year[0];

  	//Getting cash/Bank Ledger
    if($refund_mode == 'Cash') {  $pay_gl = 20; $type='CASH PAYMENT'; }
    else{ 
	    $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
     } 

  	//Getting customer Ledger
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

	////////Refund Amount//////
    $module_name = "B2B Booking Refund Paid";
    $module_entry_id = $booking_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = get_refund_paid_particular(get_b2b_booking_id($booking_id,$yr), $refund_date, $refund_amount, $refund_mode,get_b2b_booking_refund_id($refund_id,$yr1));
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

	////////Refund Amount//////
    $module_name = "B2B Booking Refund Paid";
    $module_entry_id = $booking_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = get_refund_paid_particular(get_b2b_booking_id($booking_id,$yr), $refund_date, $refund_amount, $refund_mode,get_b2b_booking_refund_id($refund_id,$yr1));
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

}


public function bank_cash_book_save($refund_id)
{
	$booking_id = $_POST['booking_id'];
	$refund_charges = $_POST['refund_charges'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year2 = explode("-", $refund_date);
	$yr1 =$year2[0];
	  
	$sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
	$year = explode("-", $sq_b2b_info['created_at']);
	$yr =$year[0];
  

	global $bank_cash_book_master;

	$module_name = "B2B Booking Refund Paid";
	$module_entry_id = $refund_id;
	$payment_date = $refund_date;
	$payment_amount = $refund_amount;
	$payment_mode = $refund_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_refund_paid_particular(get_b2b_booking_id($booking_id,$yr), $refund_date, $refund_amount, $refund_mode, get_b2b_booking_refund_id($refund_id,$yr1));
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}

public function refund_mail_send($booking_id,$refund_amount,$refund_date,$refund_mode,$transaction_id){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$encrypt_decrypt,$secret_key,$currency_logo;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   
  $sq_b2b_info = mysqli_fetch_assoc(mysqlQuery("select * from b2b_booking_master where booking_id='$booking_id'"));
  $cust_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_b2b_info[customer_id]'"));
  $email_id = $encrypt_decrypt->fnDecrypt($cust_email['email_id'], $secret_key);
  $date = $sq_b2b_info['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];

	$sq_ref_pay_total = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

	$sq_pay = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id'"));
	$sq_ref_pen_total = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status='Pending'"));
	$sq_ref_can_total = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from b2b_booking_refund_master where booking_id='$booking_id' and clearance_status='Cancelled'"));

	$paid_amount = $sq_ref_pay_total['sum'];

	$hotel_list_arr = array();
	$transfer_list_arr = array();
	$activity_list_arr = array();
	$tours_list_arr = array();
	$ferry_list_arr = array();
	
	$cart_checkout_data = ($sq_b2b_info['cart_checkout_data'] != '' && $sq_b2b_info['cart_checkout_data'] != 'null') ? json_decode($sq_b2b_info['cart_checkout_data']) : [];
	
	for($i=0;$i<sizeof($cart_checkout_data);$i++){
		if($cart_checkout_data[$i]->service->name == 'Hotel'){
			array_push($hotel_list_arr,$cart_checkout_data[$i]);
		}
		if($cart_checkout_data[$i]->service->name == 'Transfer'){
			array_push($transfer_list_arr,$cart_checkout_data[$i]);
		}
		if($cart_checkout_data[$i]->service->name == 'Activity'){
			array_push($activity_list_arr,$cart_checkout_data[$i]);
		}
		if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
			array_push($tours_list_arr,$cart_checkout_data[$i]);
		}
		if($cart_checkout_data[$i]->service->name == 'Ferry'){
			array_push($ferry_list_arr,$cart_checkout_data[$i]);
		}
	}
	global $currency;
	$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
	$to_currency_rate = $sq_to['currency_rate'];
	$main_total = 0;
	$main_tax_total = 0;
	if(sizeof($hotel_list_arr)>0){
		$tax_total = 0;
		$hotel_total = 0;
		for($i=0;$i<sizeof($hotel_list_arr);$i++){
				
			$tax_arr = explode(',',$hotel_list_arr[$i]->service->hotel_arr->tax);
			$tax_amount = 0;
			for($j=0;$j<sizeof($hotel_list_arr[$i]->service->item_arr);$j++){
				
				$room_types = explode('-',$hotel_list_arr[$i]->service->item_arr[$j]);
				$room_no = $room_types[0];
				$room_cat = $room_types[1];
				$room_cost = $room_types[2];
				$h_currency_id = $room_types[3];
				
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
				$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
				$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
			
				$hotel_total += $room_cost1;
				$tax_total += $tax_amount1;
			} 
		}
	}
	
	if(sizeof($transfer_list_arr)>0){
		$trtax_total = 0;
		$transfer_total = 0;
		for($i=0;$i<sizeof($transfer_list_arr);$i++){

			$tax_amount = 0;
			$services = ($transfer_list_arr[$i]->service!='') ? $transfer_list_arr[$i]->service : [];
			for($j=0;$j<count(array($services));$j++){
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
				//Convert into default currency
				$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
				$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
			
				$transfer_total += $room_cost1;
				$trtax_total += $tax_amount1;
			}
		} 
	}
	
	if(sizeof($activity_list_arr)>0){
		$acttax_total = 0;
		$activity_total = 0;
		for($i=0;$i<sizeof($activity_list_arr);$i++){
			$tax_amount = 0;
			$tax_arr = explode(',',$activity_list_arr[$i]->service->service_arr[0]->taxation);
			$transfer_types = explode('-',$activity_list_arr[$i]->service->service_arr[0]->transfer_type);
			$transfer = $transfer_types[0];
			$room_cost = $transfer_types[1];
			$h_currency_id = $transfer_types[2];
			
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
			//Convert into default currency
			$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
			$from_currency_rate = $sq_from['currency_rate'];
			$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
			$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
		
			$activity_total += $room_cost1;
			$acttax_total += $tax_amount1;
		}
	}
	if(sizeof($tours_list_arr)>0){
		$tourstax_total = 0;
		$tours_total = 0;
		for($i=0;$i<sizeof($tours_list_arr);$i++){
			$tax_amount = 0;
			$tax_arr = explode(',',$tours_list_arr[$i]->service->service_arr[0]->taxation);
			$package_item = explode('-',$tours_list_arr[$i]->service->service_arr[0]->package_type);
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
			//Convert into default currency
			$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
			$from_currency_rate = $sq_from['currency_rate'];
			$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
			$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);
		
			$tours_total += $room_cost1;
			$tourstax_total += $tax_amount1;
		}
	}
	if(sizeof($ferry_list_arr)>0){
		$ferrytax_total = 0;
		$ferry_total = 0;
		for($i=0;$i<sizeof($ferry_list_arr);$i++){
			//Applied Tax
			$services = ($ferry_list_arr[$i]->service!='') ? $ferry_list_arr[$i]->service : [];
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

				//Convert into default currency
				$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$room_cost1 = ($from_currency_rate / $to_currency_rate * $room_cost);
				$tax_amount1 = ($from_currency_rate / $to_currency_rate * $tax_amount);

				$ferry_total += $room_cost1;
				$ferrytax_total += $tax_amount1;
			}
		}
	}
	
	$main_total += $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
	$main_tax_total += $tax_total + $trtax_total + $acttax_total + $tourstax_total + $ferrytax_total;
	$final_total = $main_total + $main_tax_total;
	
	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	
	$paid_amount = $sq_payment_info['sum'];
	$sale_amount = $final_total;
	$cancel_amount = $sq_b2b_info['cancel_amount'];
	// $refund_amount = $sq_b2b_info['total_refund_amount'];
	
	$content = '
	<tr>
	<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Selling Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sale_amount,2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($paid_amount,2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Cancellation Charges</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($cancel_amount,2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($refund_amount,2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Refund Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Refund Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
	</table>
	</tr>';

	$content .= '</tr>';
	$subject = 'B2B Cancellation Refund ( '.get_b2b_booking_id($booking_id,$year).' )';
	global $model;
	$model->app_email_send('39',$cust_email['company_name'],$email_id, $content,$subject);
	}
}
?>