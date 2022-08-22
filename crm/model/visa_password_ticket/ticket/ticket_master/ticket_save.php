<?php
$flag = true;
class ticket_save{

public function pnr_check(){

	$airlin_pnr_arr = $_POST['airlin_pnr_arr'];
	$type = $_POST['type'];
	$entry_id = $_POST['entry_id'];

	for($i=0; $i<sizeof($airlin_pnr_arr); $i++){
		if($type=='save'){
			$sq_count = mysqli_num_rows(mysqlQuery("select * from ticket_trip_entries where airlin_pnr='$airlin_pnr_arr[$i]' and airlin_pnr!=''"));
		}else{
			$sq_count = mysqli_num_rows(mysqlQuery("select * from ticket_trip_entries where airlin_pnr='$airlin_pnr_arr[$i]' and airlin_pnr!=''  and entry_id!='$entry_id[$i]'"));
		}
	}
}
public function ticket_master_save(){

	$row_spec = "sales";
	$customer_id = $_POST['customer_id'];
	$emp_id = $_POST['emp_id'];
	$tour_type = $_POST['tour_type'];
	$type_of_tour = $_POST['type_of_tour'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$financial_year_id = $_POST['financial_year_id'];

	$adults = $_POST['adults'];
	$childrens = $_POST['childrens'];
	$infant = $_POST['infant'];
	$adult_fair = $_POST['adult_fair'];
	$children_fair = $_POST['children_fair'];
	$infant_fair = $_POST['infant_fair'];
	$basic_cost = $_POST['basic_cost'];
	$discount = $_POST['discount'];
	$yq_tax = $_POST['yq_tax'];
	$other_taxes = $_POST['other_taxes'];
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$due_date = $_POST['due_date'];
	$booking_date = $_POST['booking_date'];
	$ticket_total_cost = $_POST['ticket_total_cost'];
	$quotation_id = $_POST['quotation_id'];
	$ticket_reissue = $_POST['ticket_reissue'];

	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$first_name_arr = $_POST['first_name_arr'];
	$middle_name_arr = $_POST['middle_name_arr'];
	$last_name_arr = $_POST['last_name_arr'];
	$adolescence_arr = $_POST['adolescence_arr'];
	$seat_no_arr = $_POST['seat_no_arr'];
	$ticket_no_arr = $_POST['ticket_no_arr'];
	$gds_pnr_arr = $_POST['gds_pnr_arr'];
	$baggage_info_arr = $_POST['baggage_info_arr'];
	$from_city_id_arr = $_POST['from_city_id_arr'];
	$main_ticket_arr = $_POST['main_ticket_arr'];

	$arrival_terminal_arr = $_POST['arrival_terminal_arr'];
	$departure_terminal_arr = $_POST['departure_terminal_arr'];
	$canc_policy = mysqlREString($_POST['canc_policy']);
	$departure_datetime_arr = $_POST['departure_datetime_arr'];
	$to_city_id_arr = $_POST['to_city_id_arr'];
	$arrival_datetime_arr = $_POST['arrival_datetime_arr'];
	$airlines_name_arr = $_POST['airlines_name_arr'];
	$class_arr = $_POST['class_arr'];
	$flightClass_arr = $_POST['flightClass_arr'];
	$flight_no_arr = $_POST['flight_no_arr'];
	$airlin_pnr_arr = $_POST['airlin_pnr_arr'];
	$departure_city_arr = $_POST['departure_city_arr'];
	$arrival_city_arr = $_POST['arrival_city_arr'];
	$meal_plan_arr = $_POST['meal_plan_arr'];
	$luggage_arr = $_POST['luggage_arr'];
	$special_note_arr = $_POST['special_note_arr'];
	$roundoff = $_POST['roundoff'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
	$control = $_POST['control'];
	$entryidArray = $_POST['entryidArray'];

	$sub_category_arr = $_POST['sub_category_arr'];
	$no_of_pieces_arr = $_POST['no_of_pieces_arr'];
	$aircraft_type_arr = $_POST['aircraft_type_arr'];
	$operating_carrier_arr = $_POST['operating_carrier_arr'];
	$frequent_flyer_arr = $_POST['frequent_flyer_arr'];
	$ticket_status_arr = $_POST['ticket_status_arr'];
	$guest_name = $_POST['guest_name'];
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	
	foreach($bsmValues[0] as $key => $value){

		switch($key){
			case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
			case 'discount' : $discount = ($value != "") ? $value : $discount;break;
		}
	}
	$reflections = json_encode($_POST['reflections']);
	$due_date = get_date_db($due_date);
	$payment_date = get_date_db($payment_date);
	$booking_date = get_date_db($booking_date);

	if($payment_mode == "Cheque" || $payment_mode == "Credit Card"){
		$clearance_status = "Pending"; }
	else {  $clearance_status = ""; }
	$financial_year_id = $_SESSION['financial_year_id'];

	begin_t();
    //Get Customer id
    if($customer_id == '0'){
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
		$customer_id = $sq_max['max'];
    }
	//***Booking information
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(ticket_id) as max from ticket_master"));
	$ticket_id = $sq_max['max'] + 1;

    //Invoice number reset to one in new financial year
    $sq_count = mysqli_num_rows(mysqlQuery("select entry_id from invoice_no_reset_master where service_name='flight' and financial_year_id='$financial_year_id'"));
    if($sq_count > 0){ // Already having bookings for this financial year
    
		$sq_invoice = mysqli_fetch_assoc(mysqlQuery("select max_booking_id from invoice_no_reset_master where service_name='flight' and financial_year_id='$financial_year_id'"));
		$invoice_pr_id = $sq_invoice['max_booking_id'] + 1;
		$sq_invoice = mysqlQuery("update invoice_no_reset_master set max_booking_id = '$invoice_pr_id' where service_name='flight' and financial_year_id='$financial_year_id'");
    }
    else{ // This financial year's first booking
		// Get max entry_id of invoice_no_reset_master here
		$sq_entry_id = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as entry_id from invoice_no_reset_master"));
		$max_entry_id = $sq_entry_id['entry_id'] + 1;
		
		// Insert booking-id(1) for new financial_year only for first the time
		$sq_invoice = mysqlQuery("insert into invoice_no_reset_master(entry_id ,service_name, financial_year_id ,max_booking_id) values ('$max_entry_id','flight','$financial_year_id','1')");
		$invoice_pr_id = 1;
    }

	$bsmValues = json_encode($bsmValues);
	$sq_ticket = mysqlQuery("INSERT INTO ticket_master (ticket_id,quotation_id, ticket_reissue,customer_id, branch_admin_id,financial_year_id, tour_type, type_of_tour, adults, childrens, infant, adult_fair, children_fair, infant_fair, basic_cost, markup, basic_cost_discount, yq_tax, other_taxes, service_charge , service_tax_subtotal, service_tax_markup, tds, due_date, ticket_total_cost, created_at,emp_id, reflections,roundoff,bsm_values, canc_policy,guest_name,invoice_pr_id) VALUES ('$ticket_id','$quotation_id' ,'$ticket_reissue','$customer_id','$branch_admin_id','$financial_year_id', '$tour_type', '$type_of_tour', '$adults', '$childrens', '$infant', '$adult_fair', '$children_fair', '$infant_fair', '$basic_cost','$markup', '$discount', '$yq_tax', '$other_taxes', '$service_charge', '$service_tax_subtotal', '$service_tax_markup' , '$tds', '$due_date', '$ticket_total_cost', '$booking_date','$emp_id','$reflections','$roundoff','$bsmValues', '$canc_policy','$guest_name','$invoice_pr_id')");

	if(!$sq_ticket){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, information not saved!";
	}

	//***Member information
	for($i=0; $i<sizeof($first_name_arr); $i++){
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from ticket_master_entries"));
		$entry_id = $sq_max['max'] + 1;

		$first_name_arr[$i]    =  mysqlREString($first_name_arr[$i]);
		$middle_name_arr[$i]   =  mysqlREString($middle_name_arr[$i]);
		$last_name_arr[$i]     =  mysqlREString($last_name_arr[$i]);
		$baggage_info_arr[$i]  =  mysqlREString($baggage_info_arr[$i]);

		$sq_entry = mysqlQuery("insert into ticket_master_entries(entry_id, ticket_id, first_name, middle_name, last_name, adolescence,ticket_no, gds_pnr,baggage_info,seat_no,main_ticket,meal_plan) values('$entry_id', '$ticket_id', '$first_name_arr[$i]','$middle_name_arr[$i]','$last_name_arr[$i]', '$adolescence_arr[$i]', '$ticket_no_arr[$i]', '$gds_pnr_arr[$i]','$baggage_info_arr[$i]','$seat_no_arr[$i]','$main_ticket_arr[$i]','$meal_plan_arr[$i]')");

		if(!$sq_entry){
			$GLOBALS['flag'] = false;
			echo "error--Error in member information!";
		}
	}
	//***Trip information***
	for($i=0; $i<sizeof($departure_datetime_arr); $i++){

		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from ticket_trip_entries"));
		$entry_id = $sq_max['max'] + 1;

		$sq_count = mysqli_num_rows(mysqlQuery("select * from ticket_trip_entries where airlin_pnr='$airlin_pnr_arr[$i]' and airlin_pnr!=''"));

		$departure_datetime_arr[$i] = get_datetime_db($departure_datetime_arr[$i]);
		$arrival_datetime_arr[$i] = get_datetime_db($arrival_datetime_arr[$i]);

		$special_note1 = addslashes($special_note_arr[$i]);
		$sq_entry = mysqlQuery("insert into ticket_trip_entries(entry_id, ticket_id, departure_datetime, arrival_datetime, airlines_name, class, flight_class,flight_no, airlin_pnr, from_city, to_city, departure_city, arrival_city,meal_plan,luggage, special_note, arrival_terminal, departure_terminal,sub_category,no_of_pieces,aircraft_type,operating_carrier,frequent_flyer,ticket_status) values('$entry_id', '$ticket_id', '$departure_datetime_arr[$i]', '$arrival_datetime_arr[$i]', '$airlines_name_arr[$i]', '$class_arr[$i]', '$flightClass_arr[$i]','$flight_no_arr[$i]', '$airlin_pnr_arr[$i]', '$from_city_id_arr[$i]', '$to_city_id_arr[$i]', '$departure_city_arr[$i]', '$arrival_city_arr[$i]', '', '$luggage_arr[$i]', '$special_note1', '$arrival_terminal_arr[$i]','$departure_terminal_arr[$i]','$sub_category_arr[$i]','$no_of_pieces_arr[$i]','$aircraft_type_arr[$i]','$operating_carrier_arr[$i]','$frequent_flyer_arr[$i]','$ticket_status_arr[$i]' )");

		$dep = explode('(',$departure_city_arr[$i]);
		$arr = explode('(',$arrival_city_arr[$i]);
		if($i == 0)
			$sector = str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		if($i>0)
			$sector = $sector.','.str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		if(!$sq_entry){
			$GLOBALS['flag'] = false;
			echo "error--Error in ticket information!";
		}
	}

	//***Payment Information
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(payment_id) as max from ticket_payment_master"));
	$payment_id = $sq_max['max'] + 1;

	$sq_payment = mysqlQuery("insert into ticket_payment_master (payment_id, ticket_id, financial_year_id,branch_admin_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$ticket_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");

	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Payment not saved!";
	}
	//Update customer credit note balance
	$payment_amount1 = $payment_amount;
	$sq_credit_note = mysqlQuery("select * from credit_note_master where customer_id='$customer_id'");
	$i=0;
	while($row_credit = mysqli_fetch_assoc($sq_credit_note)) {

		if($row_credit['payment_amount'] <= $payment_amount1 && $payment_amount1 != '0'){
			$payment_amount1 = $payment_amount1 - $row_credit['payment_amount'];
			$temp_amount = 0;
		}
		else{
			$temp_amount = $row_credit['payment_amount'] - $payment_amount1;
			$payment_amount1 = 0;
		}
		$sq_credit = mysqlQuery("update credit_note_master set payment_amount ='$temp_amount' where id='$row_credit[id]'");

	}
	//Get Particular
	$pax = $adults + $childrens;
	$particular = $this->get_particular($customer_id,$pax,$sector,$ticket_no_arr[0],$airlin_pnr_arr[0]);
	//Finance save
	$this->finance_save($ticket_id, $payment_id, $row_spec, $branch_admin_id,$particular);
	//Bank and Cash Book Save
	if($payment_mode != 'Credit Note'){
		$this->bank_cash_book_save($ticket_id, $payment_id, $branch_admin_id,$particular);
	}

	if($GLOBALS['flag']){

		commit_t();
		//Ticket Booking email send
		$this->ticket_booking_email_send($ticket_id,$payment_amount);
        $this->booking_sms($ticket_id, $customer_id, $booking_date);

		//Ticket payment email send
		$ticket_payment_master  = new ticket_payment_master;
		$ticket_payment_master->payment_email_notification_send($ticket_id, $payment_amount, $payment_mode, $payment_date);

		//Ticket payment sms send
		if($payment_amount != 0){
			$ticket_payment_master->payment_sms_notification_send($ticket_id, $payment_amount, $payment_mode);
		}

		echo "Flight Ticket Booking has been successfully saved-".$ticket_id;
		if($control == 'Airfile'){
			foreach($entryidArray as $entryid){
				mysqlQuery("UPDATE `ticket_master_entries_airfile` SET `status` = 'Cleared' WHERE `entry_id` = ".$entryid);
			}
		}
		exit;
	}
	else{
		rollback_t();
		exit;
	}
}

function get_particular($customer_id,$pax,$sector,$ticket_no,$pnr){
	$sq_ct = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
	return $cust_name.' * '.$pax.' travelling for '.$sector.' against ticket no '.$ticket_no.'/PNR No '.$pnr;
}

public function finance_save($ticket_id, $payment_id, $row_spec, $branch_admin_id,$particular)
{
	$customer_id = $_POST['customer_id'];
	$tour_type = $_POST['tour_type'];
	$basic_cost = $_POST['basic_cost'];
	$markup = $_POST['markup'];
	$discount = $_POST['discount'];
	$yq_tax = $_POST['yq_tax'];
	$service_charge = $_POST['service_charge'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$other_taxes = $_POST['other_taxes'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$ticket_total_cost = $_POST['ticket_total_cost'];
    $booking_date = $_POST['booking_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$reflections = json_decode(json_encode($_POST['reflections']));
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
			case 'discount' : $discount = ($value != "") ? $value : $discount;break;
		}
	}
	$roundoff = $_POST['roundoff'];
	$booking_date = date('Y-m-d', strtotime($booking_date));
	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
	$year2 = explode("-", $payment_date1);
	$yr2 =$year2[0];

	$total_sale = floatval($basic_cost) + floatval($yq_tax) + floatval($other_taxes);
	$payment_amount1 = floatval($payment_amount1) + floatval($credit_charges);

	//Get Customer id
    if($customer_id == '0'){
    	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
	    $customer_id = $sq_max['max'];
    }

    //Getting customer Ledger
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT';}
    else{
	    $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
		$pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
    }

    global $transaction_master;
	$sale_gl = ($tour_type == 'Domestic') ? 50 : 174;

    ////////////Sales/////////////
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $total_sale;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = $sale_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Service Charge////////
	$module_name = "Air Ticket Booking";
	$module_entry_id = $ticket_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
	$gl_id = ($reflections[0]->flight_sc != '') ? $reflections[0]->flight_sc : 187;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	/////////Service Charge Tax Amount////////
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->flight_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

		$service_tax = explode(':',$service_tax_subtotal[$i]);
		$tax_amount = $service_tax[2];
		$ledger = $tax_ledgers[$i];

		$module_name = "Air Ticket Booking";
		$module_entry_id = $ticket_id;
		$transaction_id = "";
		$payment_amount = $tax_amount;
		$payment_date = $booking_date;
		$payment_particular = $particular;
		$ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
		$gl_id = $ledger;
		$payment_side = "Credit";
		$clearance_status = "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}

	///////////Markup//////////
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $markup;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = ($reflections[0]->flight_markup != '') ? $reflections[0]->flight_markup : 199;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Markup Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_markup = explode(',',$service_tax_markup);
    $tax_ledgers = explode(',',$reflections[0]->flight_markup_taxes);
    for($i=0;$i<sizeof($service_tax_markup);$i++){

		$service_tax = explode(':',$service_tax_markup[$i]);
		$tax_amount = $service_tax[2];
		$ledger = $tax_ledgers[$i];

		$module_name = "Air Ticket Booking";
		$module_entry_id = $ticket_id;
		$transaction_id = "";
		$payment_amount = $tax_amount;
		$payment_date = $booking_date;
		$payment_particular = $particular;
		$ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
		$gl_id = $ledger;
		$payment_side = "Credit";
		$clearance_status = "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}

    /////////TDS////////
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = ($reflections[0]->flight_tds != '') ? $reflections[0]->flight_tds : 127;
    $payment_side = "Debit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Discount////////
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $discount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = 36;
    $payment_side = "Debit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	////////Customer Amount//////
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $ticket_total_cost;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	////Roundoff Value
    $module_name = "Air Ticket Booking";
    $module_entry_id = $ticket_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Flight Ticket Sales');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){

		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Air Ticket Booking";
			$module_entry_id = $ticket_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_ticket_booking_id($ticket_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Air Ticket Booking";
			$module_entry_id = $ticket_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_ticket_booking_id($ticket_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr1),$bank_id,$transaction_id1);
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
			$finance_charges = number_format($finance_charges,2);
			$credit_company_amount = $payment_amount1 - $finance_charges;

			//////Finance charges ledger///////
			$module_name = "Air Ticket Booking";
			$module_entry_id = $ticket_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_ticket_booking_id($ticket_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit company amount///////
			$module_name = "Air Ticket Booking";
			$module_entry_id = $ticket_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_ticket_booking_id($ticket_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Air Ticket Booking";
			$module_entry_id = $ticket_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $payment_amount1;
			$payment_date = $payment_date1;
			$payment_particular = $particular;
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $pay_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}

		//////Customer Payment Amount///////
		$module_name = "Air Ticket Booking";
		$module_entry_id = $ticket_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_ticket_booking_id($ticket_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
}

public function bank_cash_book_save($ticket_id, $payment_id, $branch_admin_id){

	global $bank_cash_book_master;

	$customer_id = $_POST['customer_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysqli_fetch_assoc(mysqlQuery("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year2 = explode("-", $payment_date);
	$yr2 =$year2[0];

	//Get Customer id
    if($customer_id == '0'){
		$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(customer_id) as max from customer_master"));
		$customer_id = $sq_max['max'];
    }

	$module_name = "Air Ticket Booking";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_ticket_booking_payment_id($payment_id,$yr2), $payment_date, $payment_amount, $customer_id, $payment_mode, get_ticket_booking_id($ticket_id,$yr2),$bank_id,$transaction_id);
	$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);
}





public function ticket_booking_email_send($ticket_id,$payment_amount)
{
	global $currency_logo,$encrypt_decrypt,$secret_key;

	$link = BASE_URL.'view/customer';

	$sq_ticket = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$ticket_id'"));

	$date = $sq_ticket['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
	$customer_name = ($sq_customer['type'] == 'Corporate' || $sq_customer['type'] == 'B2B') ? $sq_customer['company_name'] : $sq_customer['first_name'].' '.$sq_customer['last_name'];

	$subject = 'Booking confirmation acknowledgement! ( '.get_ticket_booking_id($ticket_id,$year). ' )';

	$username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$password = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);

	$balance_amount = $sq_ticket['ticket_total_cost'] - $payment_amount;

	$flDetails = mysqlQuery('SELECT * FROM `ticket_trip_entries` where ticket_id = '.$ticket_id);
	$content = '
	<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$customer_name.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sq_ticket['ticket_total_cost'],2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($payment_amount,2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($balance_amount,2).'</td></tr>
		</table>
	</tr>
	';
	while($rows = mysqli_fetch_assoc($flDetails)){
		$city_from = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id = ".$rows['from_city']));
		$city_to = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id = ".$rows['to_city']));
		$content .= '<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><th colspan=2>Flight Details</th></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Sector From</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_from['city_name'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Sector To</td>   <td style="text-align:left;border: 1px solid #888888;">'.$city_to['city_name'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Departure</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows['departure_city'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Arrival</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows['arrival_city'].'</td></tr>
		</table>
		</tr>';
	}

	$content .= mail_login_box($username, $password, $link);

	global $model,$backoffice_email_id;
	$model->app_email_send('16',$customer_name,$password, $content,$subject);
	if(!empty($backoffice_email_id))
	$model->app_email_send('16',"Admin",$backoffice_email_id, $content,$subject);


}
public function employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id)
{
	global $model;
	$link = BASE_URL.'view/customer';
	$content = mail_login_box($username, $password, $link);
	$subject ='Welcome aboard!';

	$model->app_email_send('2',$first_name,$email_id, $content,$subject,'1');
}

public function booking_sms($booking_id, $customer_id, $created_at){

    global $encrypt_decrypt, $secret_key,$app_contact_no;
    $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
	$mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);

    global $model;
	$message = "Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", your Air Ticket booking is confirmed. Ticket voucher details will send you shortly. Please contact for more details ".$app_contact_no."";
    $model->send_message($mobile_no, $message);
}
public function whatsapp_send(){
	global $app_contact_no, $encrypt_decrypt, $secret_key;

	$emp_id = $_POST['emp_id '];
	$booking_date = $_POST['booking_date'];
	$customer_id = $_POST['customer_id'];

	if($customer_id == '0'){
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT * FROM customer_master ORDER BY customer_id DESC LIMIT 1"));
	}
	else{
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
	}
	$mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);

	$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id= '$emp_id'"));
	if($emp_id == 0){
		$contact = $app_contact_no;
	}
	else{
		$contact = $sq_emp_info['mobile_no'];
	}

	$whatsapp_msg = rawurlencode('Hello Dear '.$sq_customer['first_name'].',
Hope you are doing great. This is to inform you that your booking is confirmed with us. We look forward to provide you a great experience.
*Booking Date* : '.get_date_user($booking_date).'

Please contact for more details : '.$contact.'
Thank you.');
	$link = 'https://web.whatsapp.com/send?phone='.$mobile_no.'&text='.$whatsapp_msg;
	echo $link;
}

}
?>
