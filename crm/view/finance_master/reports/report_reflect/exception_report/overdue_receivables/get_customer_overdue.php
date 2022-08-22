<?php
include "../../../../../../model/model.php";
$customer_id = $_POST['party_name'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$array_s = array();
$temp_arr = array();
$till_date = date('Y-m-d');
$till_date1 = get_date_user($till_date);
$count = 1;
$total_footer_due = 0;
//FIT
$query = "select * from package_tour_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0;
		$booking_amt=$row_package['net_total'];
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
		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Package Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Visa
$query = "select * from visa_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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
		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Visa Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Miscellaneous
$query = "select * from miscellaneous_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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
		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Miscellaneous Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////
//Flight Ticket
$query = "select * from ticket_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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

		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Flight Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
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
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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

		if($pending_amt>'0'){		
			$due_date = ($row_package['payment_due_date']);
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Train Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
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
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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

		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Hotel Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Bus
$query = "select * from bus_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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

		if($pending_amt>'0'){		
			$due_date = ($row_package['created_at']);
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Bus Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Car Rental
$query = "select * from car_rental_booking where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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


		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Car Rental Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	 
	}
} 
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Forex
$query = "select * from forex_booking_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from forex_booking_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['net_total'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from forex_booking_payment_master where booking_id='$row_package[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
		$total_paid = $total_pay['sum'];
		$pending_amt=$booking_amt-$total_paid;
		

		if($pending_amt>'0'){		
			$due_date = ($row_package['created_at']);
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Forex Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Group
$query = "select * from tourwise_traveler_details where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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
		$booking_fee =0; $pending_amt=0; $total_paid = 0; $cancel_amount2 = 0; $cancel_amount = 0; $cancel_amount1 = 0; $total_outstanding = 0;
		$booking_fee=$row_package['net_total'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(amount) as sum from payment_master where tourwise_traveler_id='$row_package[id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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

		if($pending_amt>'0'){		
			$due_date = ($row_package['balance_due_date']);
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Group Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 


///////////////////////////////////////////////////////////////////////////////////////////////////////
//Passport
$query = "select * from passport_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
	$due_date_arr = array();

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}
	else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];	
	}
	$sq_pacakge = mysqlQuery("select * from passport_master where customer_id='$row_booking[customer_id]' ");
	while($row_package = mysqli_fetch_assoc($sq_pacakge))
	{
		$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_outstanding = 0;
		$booking_amt=$row_package['passport_total_cost'];
		$total_pay=mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from passport_payment_master where passport_id='$row_package[passport_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
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


		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Passport Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////
//Excursion
$query = "select * from excursion_master where 1 ";
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
	}	
	elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
    }
} 
$query .= ' group by customer_id';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking))
{	
	$booking_amt =0; $pending_amt=0; $total_paid = 0; $cancel_est = 0; $total_due = 0;
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


		if($pending_amt>'0'){		
			$due_date = $row_package['due_date'];
			if(strtotime($till_date1) > strtotime($due_date)) {
				$total_due += $pending_amt;
				array_push($due_date_arr, $due_date);
			}
		}
	}

	if($total_due>'0'){
		sort($due_date_arr);
        $total_footer_due += $total_due;
		$temp_arr = array( "data" => array(
			(int)($count++),
			$customer_name,
			"Activity Booking",
			number_format($total_due,2),
			get_date_user($due_date_arr[0])
			
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	
	}
}
$footer_data = array("footer_data" => array(
	'total_footers' => 5,
	
	'foot0' => '',
	'col0' => 0,
	'class0' =>"",

	'foot1' => '',
	'col1' => 0,
	'class1' =>"",

	'foot2' => 'Total AMOUNT :',
	'col2' => 0,
	'class2' =>"",

	'foot3' => number_format($total_footer_due,2),
	'col3' => 1,
	'class3' =>"text-right info",

	'foot4' => '',
	'col4' => 0,
	'class4' =>"",
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>