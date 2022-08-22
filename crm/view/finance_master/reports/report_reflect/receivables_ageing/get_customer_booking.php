<?php
include "../../../../../model/model.php";
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$branch_status = $_POST['branch_status']; 	
$till_date = $_POST['till_date'];
$customer_id = $_POST['customer_id'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$till_date1 = get_date_user($till_date);
$array_s = array();
$temp_arr = array();

$count = 1;
$total_outstanding_total = 0; $not_due_total = 0; $total_due_total = 0;
$group1_total = 0; $group2_total = 0; $group3_total=0; $group4_total=0; $group5_total=0; $group6_total=0; $group7_total=0;

//FIT
$query = "select * from package_tour_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from package_tour_booking_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt = $row_package['net_total'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum from package_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];

		$cancel_est=mysqli_fetch_assoc(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_package[booking_id]'"));
		$cancel_est=$cancel_est['cancel_amount'];
		if($cancel_est != ''){	
			if($cancel_est <= $total_paid){
				$pending_amt = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$cancel_est = ($cancel_est == '') ? '0' : $cancel_est;
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($total_days_arr,'NA'); 
				array_push($not_due_arr,$pending_amt);
			}
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['booking_id']);
		array_push($due_date_arr,$row_package['due_date']); } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Package Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
} 
///////////////////////Visa///////////////////////////
$query = "select * from visa_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from visa_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['visa_total_cost'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from visa_payment_master where visa_id='$row_package[visa_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_amount = $row_package['cancel_amount'];

		$pass_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$row_package[visa_id]'"));
		$cancel_count = mysqli_num_rows(mysqlQuery("select * from  visa_master_entries where visa_id='$row_package[visa_id]' and status='Cancel'"));
		if($pass_count == $cancel_count){
			if($total_paid > 0){
				if($cancel_amount >0){
					if($total_paid > $cancel_amount){
						$pending_amt = 0;
					}else{
						$pending_amt = $cancel_amount - $total_paid;
					}
				}else{
				$pending_amt = 0;
				}
			}
			else{
				$pending_amt = $cancel_amount;
			}
		}
		else{
			$pending_amt = $booking_amt - $total_paid;
		}
		
		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['visa_id']);  
		array_push($due_date_arr,$row_package['due_date']); } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Visa Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}

/////////////////////////////Flight Ticket//////////////////////////////
$query = "select * from ticket_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from ticket_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['ticket_total_cost'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from ticket_payment_master where ticket_id='$row_package[ticket_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}
		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}  
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1 += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2 += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3 += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($not_due_arr,'0');
				array_push($total_days_arr,$total_days); 
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
			array_push($booking_id_arr,$row_package['ticket_id']);
			array_push($due_date_arr,$row_package['due_date']);
	    }
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;
		
		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Flight Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Train
$query = "select * from train_ticket_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from train_ticket_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['net_total'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$row_package[train_ticket_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['payment_due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1 += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2 += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3 += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4 += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5 += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6 += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
			array_push($booking_id_arr,$row_package['train_ticket_id']);  
			array_push($due_date_arr,$row_package['payment_due_date']);
	    } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Train Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Hotel
$query = "select * from hotel_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from hotel_booking_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['total_fee'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['booking_id']); 
		array_push($due_date_arr,$row_package['due_date']);} 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Hotel Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	 
	}
} 

/////////////Bus/////////////////////////////
$query = "select * from bus_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from bus_booking_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['net_total'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['created_at']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['booking_id']); 
		array_push($due_date_arr,$row_package['created_at']); } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Bus Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
} 
//////////////////////Car Rental
$query = "select * from car_rental_booking where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from car_rental_booking where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['total_fees'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from car_rental_payment where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
			array_push($booking_id_arr,$row_package['booking_id']); 
			array_push($due_date_arr,$row_package['due_date']); 
	    } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Car Rental Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 
/////////////////miscellaneous///////////////////
$query = "select * from miscellaneous_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from miscellaneous_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['misc_total_cost'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from miscellaneous_payment_master where misc_id='$row_package[misc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['misc_id']);  
		array_push($due_date_arr,$row_package['due_date']); } 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Miscellaneous Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}

//////////////Group/////////////////////
$query = "select * from tourwise_traveler_details where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0;
	$pending_amt=0; $total_paid = 0;
	$total_outstanding = 0;
	$not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from tourwise_traveler_details where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$pending_amt=0; $total_paid = 0; $cancel_amount2 = 0; $cancel_amount = 0; $cancel_amount1 = 0;
		$total_outstanding = 0;
		$booking_fee = $row_package['net_total'];
		$total_pay = mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum from payment_master where tourwise_traveler_id='$row_package[id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		if($row_package['tour_group_status'] == 'Cancel'){
			//Group Tour cancel
			$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_package[id]'"));
			if($cancel_tour_count2 >= '1'){
				$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_package[id]'"));
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
			$cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_package[id]'"));
			if($cancel_esti_count1 >= '1'){
				$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$row_package[id]'"));
				$cancel_amount = $cancel_esti1['cancel_amount'];
			}
			else{ $cancel_amount = 0; }
		}
		$cancel_amount = ($cancel_amount == '') ? '0' :$cancel_amount;
		if($row_package['tour_group_status'] == 'Cancel'){
			if($cancel_amount > $total_paid){
				$pending_amt = $cancel_amount - $total_paid;
			}
			else{
				$pending_amt = 0;
			}
		}
		else{
			if($cancel_esti_count1 >= '1'){
				if($cancel_amount > $total_paid){
					$pending_amt = $cancel_amount - $total_paid;
				}
				else{
					$pending_amt = 0;
				}
			}
			else{
				$pending_amt = $booking_fee - $total_paid;
			}
		}

		$due_date1 = get_date_user($row_package['balance_due_date']);
		if(strtotime($till_date1) < strtotime($due_date1)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date1);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}
		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
			array_push($booking_id_arr,$row_package['id']); 
			array_push($due_date_arr,$due_date1); 
	    }
	}

	if($total_outstanding>'0'){

		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;
		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Group Booking',
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}

//Excursion
$query = "select * from excursion_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../../../model/app_settings/branchwise_filteration.php";
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
	$total_outstanding = 0; $not_due = 0; $total_due = 0;
	$group1 = 0; $group2 = 0; $group3=0; $group4=0; $group5=0; $group6=0; $group7=0;

	$booking_id_arr = array();
	$pending_amt_arr = array();
	$total_days_arr = array();
	$not_due_arr = array();
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from excursion_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['exc_total_cost'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from exc_payment_master where exc_id='$row_package[exc_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$cancel_est = $row_package['cancel_amount'];

		//Consider sale cancel amount
		if($cancel_est != '0'){ 			
			if($cancel_est <= $total_paid){
				$pending_amt  = 0;
			}
			else{
				$pending_amt =  $cancel_est - $total_paid;
			}
		}
		else{
			$pending_amt=$booking_amt-$total_paid;
		}

		$due_date = get_date_user($row_package['due_date']);
		if(strtotime($till_date1) < strtotime($due_date)) {
			$not_due += $pending_amt;
		    $total_due = 0;		
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,'0'); 
				array_push($not_due_arr,$pending_amt);
				array_push($total_days_arr,'NA'); 
			}    
		}
		else{
			$not_due += 0;
		    //////get total days count////
		    $date1_ts = strtotime($till_date1);
			$date2_ts = strtotime($due_date);
			$diff = $date1_ts - $date2_ts;
			$total_days = round($diff / 86400);
		    //////////////////////////////
		    if($total_days>='0' && $total_days<='30') { $group1  += $pending_amt; } 
		    if($total_days>'30' && $total_days<='60') { $group2  += $pending_amt; } 
		    if($total_days>'60' && $total_days<='90') { $group3  += $pending_amt;} 
		    if($total_days>'90' && $total_days<='120') { $group4  += $pending_amt; } 
		    if($total_days>'120' && $total_days<='180') { $group5  += $pending_amt; }
		    if($total_days>'180' && $total_days<='360') { $group6  += $pending_amt; }
		    if($total_days>'360'){ $group7 += $pending_amt; } 
		    
			if($pending_amt>'0'){ 
				array_push($pending_amt_arr,$pending_amt); 
				array_push($total_days_arr,$total_days); 
				array_push($not_due_arr,'0');
		    }
		}

		$total_due = $group1 + $group2 + $group3 + $group4 + $group5 + $group6 + $group7;
		$total_outstanding += $total_due + $not_due;
		if($pending_amt>'0'){ 
		array_push($booking_id_arr,$row_package['exc_id']); 
		array_push($due_date_arr,$row_package['due_date']);} 
	}

	if($total_outstanding>'0'){
		$total_outstanding_total += $total_outstanding;
		$not_due_total += $not_due;
		$total_due_total += $total_due;
		$group1_total += $group1;
		$group2_total += $group2;
		$group3_total += $group3;
		$group4_total += $group4;
		$group5_total += $group5;
		$group6_total += $group6;
		$group7_total += $group7;

		$booking_id_arr = json_encode($booking_id_arr);
		$pending_amt_arr = json_encode($pending_amt_arr);
		$not_due_arr = json_encode($not_due_arr);
		$total_days_arr = json_encode($total_days_arr);
		$due_date_arr = json_encode($due_date_arr);
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			'Activity Booking' ,
			"<button class='btn btn-info btn-sm' onclick='view_modal($booking_id_arr,$pending_amt_arr, $not_due_arr,$total_days_arr,$due_date_arr)' data-toggle='tooltip' title='Ageing Information'><i class='fa fa-eye'></i></button>",
			number_format($total_outstanding,2),
			number_format($not_due,2) ,
			number_format($total_due,2),
			number_format($group1,2),
			number_format($group2,2),
			number_format($group3,2),
			number_format($group4,2),
			number_format($group5,2),
			number_format($group6,2),
			number_format($group7,2)

			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}
$footer_data = array("footer_data" => array(
	'total_footers' => 11,
	
	'foot0' => "TOTAL : ",
	'col0' => 4,
	'class0' =>"text-right",

	'foot1' => number_format($total_outstanding_total,2),
	'col1' => 1,
	'class1' =>"text-right",

	'foot2' => number_format($not_due_total,2),
	'col2' => 1,
	'class2' =>"text-right",

	'foot3' => number_format($total_due_total,2),
	'col3' => 1,
	'class3' =>"text-right",

	'foot4' => number_format($group1_total,2),
	'col4' => 1,
	'class4' =>"text-right",

	'foot5' => number_format($group2_total,2),
	'col5' => 1,
	'class5' =>"text-right",

	'foot6' => number_format($group3_total,2),
	'col6' => 1,
	'class6' =>"text-right",

	'foot7' => number_format($group4_total,2),
	'col57' => 1,
	'class7' =>"text-right",

	'foot8' => number_format($group5_total,2),
	'col8' => 1,
	'class8' =>"text-right",
	'foot9' => number_format($group6_total,2),
	'col9' => 1,
	'class9' =>"text-right",

	'foot10' => number_format($group7_total,2),
	'col10' => 1,
	'class10' =>"text-right"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
