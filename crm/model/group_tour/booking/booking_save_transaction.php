<?php 
class booking_save_transaction
{
function finance_save($tourwise_traveler_id, $row_spec, $branch_admin_id,$particular)
{
  global $transaction_master;
  $row_spec = 'sales';
  $customer_id = $_POST['customer_id'];
  $form_date = $_POST['form_date'];

  //**tour details
  $service_tax = $_POST['service_tax'];
  $net_total = $_POST['net_total'];
  $tcs_tax = $_POST['tcs_tax'];    

  //**Payment details
  $payment_date = $_POST['payment_date'];
  $payment_amount = $_POST['payment_amount'];
  $transaction_id = $_POST['transaction_id'];
  $basic_amount = $_POST['basic_amount'];
  $roundoff = $_POST['roundoff'];
  $total_discount = $_POST['total_discount'];
  
  $booking_date = get_date_db($form_date);
	$year1 = explode("-", $booking_date);
  $reflections = json_decode(json_encode($_POST['reflections']));
  $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $basic_amount = ($value != "") ? $value : $basic_amount;break;
      }
    }

  $total_sale_amount = $basic_amount+$total_discount;
  
  //Getting customer Ledger
  $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  ////////////Sales/////////////

  $module_name = "Group Booking";
  $module_entry_id = $tourwise_traveler_id;
  $transaction_id = "";
  $payment_amount = $total_sale_amount;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Group Tour Sales');
  $gl_id = 59;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

  // Discount 
  $module_name = "Group Booking";
  $module_entry_id = $tourwise_traveler_id;
  $transaction_id = "";
  $payment_amount = $total_discount;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Group Tour Sales');
  $gl_id = 36;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

  /////////Service Charge Tax Amount////////
  // Eg. CGST:(9%):24.77, SGST:(9%):24.77
  $service_tax_subtotal = explode(',',$service_tax);
  $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
  for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Group Booking";
    $module_entry_id = $tourwise_traveler_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Group Tour Sales');
    $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
  }
  // TCS charge 
  $module_name = "Group Booking";
  $module_entry_id = $tourwise_traveler_id;
  $transaction_id = "";
  $payment_amount = $tcs_tax;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Group Tour Sales');
  $gl_id = 232;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

  ////Roundoff Value
  $module_name = "Group Booking";
  $module_entry_id = $tourwise_traveler_id;
  $transaction_id = "";
  $payment_amount = $roundoff;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Group Tour Sales');
  $gl_id = 230;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
  ////////Customer Amount//////
  $module_name = "Group Booking";
  $module_entry_id = $tourwise_traveler_id;
  $transaction_id = "";
  $payment_amount = $net_total;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Group Tour Sales');
  $gl_id = $cust_gl;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
}

public function payment_finance_save($booking_id, $payment_id, $payment_date, $payment_mode, $payment_amount, $transaction_id1, $bank_id, $branch_admin_id,$credit_charges,$credit_card_details)
{
  global $transaction_master;

  $customer_id = $_POST['customer_id'];
  $row_spec = 'sales';

  $payment_date = get_date_db($payment_date);
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];
  //Getting customer Ledger
  $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  //Getting cash/Bank Ledger
  if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
  else{ 
    $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
  } 

  $payment_amount1 = floatval($payment_amount) + floatval($credit_charges);
   //////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Group Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $booking_id;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $credit_charges, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Group Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $credit_charges, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 224;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Get Credit card company Ledger///////
			$credit_card_details = explode('-',$credit_card_details);
			$entry_id = $credit_card_details[0];
			$sq_cust1 = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$entry_id' and user_type='credit company'"));
			$company_gl = $sq_cust1['ledger_id'];
			//////Get Credit card company Charges///////
			$sq_credit_charges = mysqli_fetch_assoc(mysqlQuery("select * from credit_card_company where entry_id='$entry_id'"));
			//////company's credit card charges
			$company_card_charges = ($sq_credit_charges['charges_in'] =='Flat') ? $sq_credit_charges['credit_card_charges'] : ($payment_amount1 * ($sq_credit_charges['credit_card_charges']/100));
			//////company's tax on credit card charges
			$tax_charges = ($sq_credit_charges['tax_charges_in'] =='Flat') ? $sq_credit_charges['tax_on_credit_card_charges'] : ($company_card_charges * ($sq_credit_charges['tax_on_credit_card_charges']/100));
			$finance_charges = $company_card_charges + $tax_charges;
      $credit_company_amount = $payment_amount1 - $finance_charges;
      $finance_charges = number_format($finance_charges,2);

			//////Finance charges ledger///////
			$module_name = "Group Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $finance_charges, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Group Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{
			$module_name = "Group Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $payment_amount1;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $pay_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}

		//////Customer Payment Amount///////
		$module_name = "Group Booking";
		$module_entry_id = $booking_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date;
		$payment_particular = get_sales_paid_particular(get_group_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
}

public function bank_cash_book_save($booking_id, $payment_id, $payment_date, $payment_mode, $payment_amount, $transaction_id, $bank_name, $bank_id,$branch_admin_id)
{
  global $bank_cash_book_master;
  $payment_date = get_date_db($payment_date);
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

  $customer_id = $_POST['customer_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysqli_fetch_assoc(mysqlQuery("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}

  $module_name = "Group Booking";
  $module_entry_id = $payment_id;
  $payment_date = $payment_date;
  $payment_amount = $payment_amount;
  $payment_mode = $payment_mode;
  $bank_name = $bank_name;
  $transaction_id = $transaction_id;
  $bank_id = $bank_id;
  $particular = get_sales_paid_particular(get_group_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_group_booking_id($booking_id,$yr1),$bank_id,$transaction_id);
  $clearance_status = ($payment_mode=="Cheque" || $payment_mode=="Credit Card") ? "Pending" : "";
  $payment_side = "Debit";
  $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
  $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);

}
}
?>
