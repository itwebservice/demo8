<?php
include "../../model/model.php";

$tour_type_filter = $_POST['tour_type'];
$emp_id_filter = $_POST['emp_id'];
$from_date_filter = $_POST['from_date'];
$to_date_filter = $_POST['to_date'];
$branch_status = $_POST['branch_status'];

$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$array_s = array();
$temp_arr = array();
function dateSort($a,$b){
    $dateA = strtotime($a['booking_date']);
    $dateB = strtotime($b['booking_date']);
    return ($dateA-$dateB);
}

$group_booking_arr = array();
$query = "select * from tourwise_traveler_details where 1 and tour_group_status != 'Cancel' ";
if($emp_id_filter!=""){
	$query .= " and emp_id='$emp_id_filter' ";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(form_date) between '$from_date_filter' and '$to_date_filter' ";
}

include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(form_date) asc";
$sq_group_bookings = mysqlQuery($query);
while($row_group_bookings = mysqli_fetch_assoc($sq_group_bookings)){

	$date = $row_group_bookings['form_date'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id = '$row_group_bookings[traveler_group_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id = '$row_group_bookings[traveler_group_id]' and status='Cancel'"));

	if($sq_pass_count != $sq_pass_cancel)
	{
		$tourwise_traveler_id = $row_group_bookings['id'];			
		$emp_id = $row_group_bookings['emp_id'];			
		$tour_id = $row_group_bookings['tour_id'];
		$tour_group_id = $row_group_bookings['tour_group_id'];
		$booking_date = get_date_db($row_group_bookings['form_date']);
		$tour_type = "Group Tour";
		$file_no = get_group_booking_id($row_group_bookings['id'],$year);

		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}

		$sq_tour = mysqli_fetch_assoc( mysqlQuery("select tour_name from tour_master where tour_id='$tour_id'") );
		$tour_name = $sq_tour['tour_name'];

		$sq_tour_group = mysqli_fetch_assoc( mysqlQuery("select from_date, to_date from tour_groups where tour_id='$tour_id' and group_id='$tour_group_id'") );
		$tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date']));
		$booking_amount = $row_group_bookings['net_total'] ;

		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_group_bookings[tour_group_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){		
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$array1 = array(	
			'booking_date' => $booking_date,
			'other' => array(
							'booking_id' => $tourwise_traveler_id,
							'emp_id' => $emp_id,
							'booker_name' => $booker_name,
							'tour_type' => $tour_type,
							'file_no' => $file_no,
							'tour_name' => $tour_name,
							'tour_date' => $tour_group,		
							'booking_amount' => $booking_amount,	
							'total_purchase' => $total_purchase,						
					)
				);
		array_push($group_booking_arr, $array1);
	}			
}


$package_booking_arr = array();

$query = "select * from package_tour_booking_master where 1  and tour_status != 'Cancel'";
if($emp_id_filter!=""){
	$query .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(booking_date) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(booking_date) asc ";
$sq_package_booking = mysqlQuery($query);
while($row_package_booking = mysqli_fetch_assoc($sq_package_booking)){
	$date = $row_package_booking['booking_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id = '$row_package_booking[booking_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id = '$row_package_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_package_booking['booking_id'];
		$emp_id = $row_package_booking['emp_id'];
		$tour_name = $row_package_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_package_booking['tour_from_date']));
		$booking_date = get_date_db($row_package_booking['booking_date']);
		$tour_type = "Package Tour";
		$file_no = get_package_booking_id($row_package_booking['booking_id'],$year);
		$booking_amount = $row_package_booking['net_total'] ;

		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id='$row_package_booking[booking_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}

		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
							'booking_id' => $booking_id,
							'emp_id' => $emp_id,
							'booker_name' => $booker_name,
							'tour_type' => $tour_type,
							'file_no' => $file_no,							
							'tour_name' => $tour_name,
							'tour_date' => $tour_date,		
							'booking_amount' => $booking_amount,	
							'total_purchase' => $total_purchase,				
						)
					);

		array_push($package_booking_arr, $array1);	
	}
}
// Hotel booking
$hotel_booking_arr = array();

$query = "select * from hotel_booking_master where 1 ";
if($emp_id_filter!=""){
	$query .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";
$sq_hotel_booking = mysqlQuery($query);
while($row_hotel_booking = mysqli_fetch_assoc($sq_hotel_booking)){
	$date = $row_hotel_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id = '$row_hotel_booking[booking_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id = '$row_hotel_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_hotel_booking['booking_id'];
		$emp_id = $row_hotel_booking['emp_id'];
		$tour_name = $row_hotel_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_hotel_booking['tour_from_date']));
		$booking_date = $row_hotel_booking['created_at'];
		$tour_type = "Hotel Booking";
		$file_no = get_hotel_booking_id($row_hotel_booking['booking_id'],$year);
		$booking_amount = $row_hotel_booking['total_fee'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Hotel Booking' and estimate_type_id='$row_hotel_booking[booking_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($hotel_booking_arr, $array1);	
	}
}
// Bus Booking
$bus_booking_arr = array();

$query = "select * from bus_booking_master where 1 ";
if($emp_id_filter!=""){
	$query .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";
$sq_bus_booking = mysqlQuery($query);
while($row_bus_booking = mysqli_fetch_assoc($sq_bus_booking)){
	$date = $row_bus_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id = '$row_bus_booking[booking_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id = '$row_bus_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_bus_booking['booking_id'];
		$emp_id = $row_bus_booking['emp_id'];
		$tour_name = $row_bus_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_bus_booking['tour_from_date']));
		$booking_date = $row_bus_booking['created_at'];
		$tour_type = "Bus Booking";
		$file_no = get_bus_booking_id($row_bus_booking['booking_id'],$year);
		$booking_amount = $row_bus_booking['net_total'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Bus Booking' and estimate_type_id='$row_bus_booking[booking_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($bus_booking_arr, $array1);	
	}
}
// Car Rental Booking
$car_booking_arr = array();

$query = "select * from car_rental_booking where 1  and status!='Cancel'";
if($emp_id_filter!=""){
	$query .= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";
$sq_car_booking = mysqlQuery($query);
while($row_car_booking = mysqli_fetch_assoc($sq_car_booking)){
	$date = $row_car_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from car_rental_booking where booking_id = '$row_car_booking[booking_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from car_rental_booking where booking_id = '$row_car_booking[booking_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_car_booking['booking_id'];
		$emp_id = $row_car_booking['emp_id'];
		$tour_name = $row_car_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_car_booking['tour_from_date']));
		$booking_date = $row_car_booking['created_at'];
		$tour_type = "Car Rental";
		$file_no = get_car_rental_booking_id($row_car_booking['booking_id'],$year);
		$booking_amount = $row_car_booking['total_fees'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car_booking[booking_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($car_booking_arr, $array1);	
	}
}
//Excursion Rental Booking
$exc_booking_arr = array();

$query = "select * from excursion_master where 1  ";
if($emp_id_filter!=""){
	$query.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";
$sq_exc_booking = mysqlQuery($query);
while($row_exc_booking = mysqli_fetch_assoc($sq_exc_booking)){
	$date = $row_exc_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries	where exc_id = '$row_exc_booking[exc_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id = '$row_exc_booking[exc_id]' and status='Cancel'"));
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_exc_booking['exc_id'];
		$emp_id = $row_exc_booking['emp_id'];
		$tour_name = $row_exc_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_exc_booking['tour_from_date']));
		$booking_date = $row_exc_booking['created_at'];
		$tour_type = "Activity Booking";
		$file_no = get_exc_booking_id($row_exc_booking['exc_id'],$year);
		$booking_amount = $row_exc_booking['exc_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Activity Booking' and estimate_type_id='$row_exc_booking[exc_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($exc_booking_arr, $array1);	
	}
}
//Misc Rental Booking
$misc_booking_arr = array();

$query = "select * from miscellaneous_master where 1  ";
if($emp_id_filter!=""){
	$query.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";

$sq_misc_booking = mysqlQuery($query);
while($row_misc_booking = mysqli_fetch_assoc($sq_misc_booking)){
	$date = $row_misc_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries	where misc_id = '$row_misc_booking[misc_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries
	where misc_id = '$row_misc_booking[misc_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_misc_booking['misc_id'];
		$emp_id = $row_misc_booking['emp_id'];
		$tour_name = $row_misc_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_misc_booking['tour_from_date']));
		$booking_date = $row_misc_booking['created_at'];
		$tour_type = "Miscellaneous Booking";
		$file_no = get_misc_booking_id($row_misc_booking['misc_id'],$year);
		$booking_amount = $row_misc_booking['misc_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Miscellaneous Booking' and estimate_type_id='$row_misc_booking[misc_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($misc_booking_arr, $array1);	
	}
}
//Ticket  Booking
$ticket_booking_arr = array();

$query = "select * from ticket_master where 1  ";
if($emp_id_filter!=""){
	$query.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";

$sq_ticket_booking = mysqlQuery($query);
while($row_ticket_booking = mysqli_fetch_assoc($sq_ticket_booking)){
	$booking_date = $row_ticket_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id = '$row_ticket_booking[ticket_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id = '$row_ticket_booking[ticket_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_ticket_booking['ticket_id'];
		$emp_id = $row_ticket_booking['emp_id'];
		$tour_name = $row_ticket_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_ticket_booking['tour_from_date']));
		$tour_type = "Ticket Booking";
		$file_no = get_ticket_booking_id($row_ticket_booking['ticket_id'],$year);
		$booking_amount = $row_ticket_booking['ticket_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id='$row_ticket_booking[ticket_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($ticket_booking_arr, $array1);	
	}
}
//Train Ticket Booking
$train_booking_arr = array();
$query = "select * from train_ticket_master where 1  ";
if($emp_id_filter!=""){
	$query.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";

$sq_misc_booking1 = mysqlQuery($query);
while($row_train_booking = mysqli_fetch_assoc($sq_misc_booking1)){
	$date = $row_train_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from train_ticket_master_entries where train_ticket_id = '$row_train_booking[train_ticket_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from train_ticket_master_entries	where train_ticket_id = '$row_train_booking[train_ticket_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_train_booking['train_ticket_id'];
		$emp_id = $row_train_booking['emp_id'];
		$tour_name = $row_train_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_train_booking['tour_from_date']));
		$booking_date = $row_train_booking['created_at'];
		$tour_type = "Train Ticket Booking";
		$file_no = get_train_ticket_booking_id($row_train_booking['train_ticket_id'],$year);
		$booking_amount = $row_train_booking['net_total'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Train Ticket Booking' and estimate_type_id='$row_train_booking[train_ticket_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );
		 
		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
								  )
					   );
		array_push($train_booking_arr, $array1);	
	}
}
//Visa Booking
$visa_booking_arr = array();

$query = "select * from visa_master where 1  ";
if($emp_id_filter!=""){
	$query.= " and emp_id='$emp_id_filter'";	
}
if($from_date_filter!="" && $to_date_filter!=""){
	$from_date_filter = date('Y-m-d', strtotime($from_date_filter));
	$to_date_filter = date('Y-m-d', strtotime($to_date_filter));

	$query .= " and date(created_at) between '$from_date_filter' and '$to_date_filter' ";
}
include "../../model/app_settings/branchwise_filteration.php";
$query .= " order by date(created_at) asc ";
$sq_visa_booking = mysqlQuery($query);
while($row_visa_booking = mysqli_fetch_assoc($sq_visa_booking)){
	$booking_date = $row_visa_booking['created_at'];
    $yr = explode("-", $date);
	$year =$yr[0];
	$sq_pass_count = mysqli_num_rows(mysqlQuery("select * from visa_master_entries	where visa_id = '$row_visa_booking[visa_id]'"));
	$sq_pass_cancel = mysqli_num_rows(mysqlQuery("select * from visa_master_entries
	where visa_id = '$row_visa_booking[visa_id]' and status='Cancel'"));
	
	if($sq_pass_count != $sq_pass_cancel)
	{
		$booking_id = $row_visa_booking['visa_id'];
		$emp_id = $row_visa_booking['emp_id'];
		$tour_name = $row_visa_booking['tour_name'];
		$tour_date = date('d-m-Y', strtotime($row_visa_booking['tour_from_date']));
		$tour_type = "Visa Booking";
		$file_no = get_visa_booking_id($row_visa_booking['visa_id'],$year);
		$booking_amount = $row_visa_booking['visa_total_cost'];
		/////// Purchase ////////
		$total_purchase = 0;
		$purchase_amt = 0;
		$i=0;
		$p_due_date = '';
		$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Visa Booking' and estimate_type_id='$row_visa_booking[visa_id]'");
		while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
			$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
			$total_purchase = $total_purchase + $purchase_amt;
		}
		$sq_booker = mysqli_fetch_assoc( mysqlQuery("select first_name, last_name from emp_master where emp_id='$emp_id'") );

		if($sq_booker['first_name']==''){
			$booker_name = 'Admin';
		}
		else{
			$booker_name = $sq_booker['first_name'].' '.$sq_booker['last_name'];;
		}
		$array1 = array(
						'booking_date' => $booking_date,
						'other' => array(
										'booking_id' => $booking_id,
										'emp_id' => $emp_id,
										'booker_name' => $booker_name,
										'tour_type' => $tour_type,
										'file_no' => $file_no,							
										'tour_name' => $tour_name,
										'tour_date' => $tour_date,		
										'booking_amount' => $booking_amount,	
										'total_purchase' => $total_purchase,				
						)
			);
		array_push($visa_booking_arr, $array1);	
	}
}

if($tour_type_filter=="Group Tour"){
	$booking_array = $group_booking_arr;
}
if($tour_type_filter=="Package Tour"){
	$booking_array = $package_booking_arr;
}
if($tour_type_filter=="Hotel Booking"){
	$booking_array = $hotel_booking_arr;
}
if($tour_type_filter=="Bus Booking"){
	$booking_array = $bus_booking_arr;
}
if($tour_type_filter=="Car Rental Booking"){
	$booking_array = $car_booking_arr;
}
if($tour_type_filter=="Activity Booking"){
	$booking_array = $exc_booking_arr;
}
if($tour_type_filter=="Miscellaneous Booking"){
	$booking_array = $misc_booking_arr;
}
if($tour_type_filter=="Ticket Booking"){
	$booking_array = $ticket_booking_arr;
}
if($tour_type_filter=="Train Booking"){
	$booking_array = $train_booking_arr;
}
if($tour_type_filter=="Visa Booking"){
	$booking_array = $visa_booking_arr;
}
if($tour_type_filter==""){
	$booking_array = array_merge($group_booking_arr,$hotel_booking_arr,$package_booking_arr,$bus_booking_arr,$car_booking_arr,$exc_booking_arr,$forex_booking_arr,$misc_booking_arr,$passport_booking_arr,$ticket_booking_arr,$train_booking_arr,$visa_booking_arr);
	usort($booking_array, 'dateSort');
}
$incentive_total = 0; $paid_amount = 0; $balance_amount = 0;
?>

	
		<?php 
		foreach($booking_array as $booking_array_item){

			$other_data_arr = $booking_array_item['other'];

			$emp_id = $other_data_arr['emp_id'];

			if($other_data_arr['tour_type']=="Group Tour"){ $row_bg = "warning"; }
			if($other_data_arr['tour_type']=="Package Tour"){ $row_bg = "info"; }

			
			$booking_id = $other_data_arr['booking_id'];
			$incentive_count = mysqli_num_rows(mysqlQuery("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id' and service_type='$other_data_arr[tour_type]'"));

			if($incentive_count!=0){
				$sq_incentive = mysqli_fetch_assoc(mysqlQuery("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id' and service_type='$other_data_arr[tour_type]'"));	
				$incentive_amount = ($other_data_arr['tour_type'] != 'Group Tour') ? $sq_incentive['incentive_amount']:'0';
			}else{
				$incentive_amount = 0;
			}
			$incentive_total = $incentive_total + $incentive_amount;
			if($role== 'Admin' || $role=='Branch Admin' || $role=='Accountant'){ 
				$booking_id = $other_data_arr['booking_id'];
				$incentive_count = mysqli_num_rows(mysqlQuery("select * from booker_sales_incentive where booking_id='$booking_id' and emp_id='$emp_id'  and service_type='$other_data_arr[tour_type]'"));
				if($incentive_count==0 && ($role== 'Admin' || $role=='Branch Admin' || $role=='Accountant')){
					$edit='<a href="javascript:void(0)" onclick="incentive_edit_modal(\''.$other_data_arr['booking_id'] .'\',\''. $other_data_arr['emp_id'] .'\',\''.$other_data_arr['tour_type'].'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit this Incentive"><i class="fa fa-pencil-square-o"></i></a>';
					
				}else{
					$edit = 'NA';
				}
			}
			$temp_arr = array( "data" => array(
				(int)(++$count),
				$other_data_arr['booker_name'],
				($other_data_arr['tour_type'] != '')?$other_data_arr['tour_type']:'NA',
				$other_data_arr['file_no'],
				($other_data_arr['tour_name']!='')? $other_data_arr['tour_name'] : 'NA',
				(date('Y-m-d', strtotime($other_data_arr['tour_date'])) == '1970-01-01') ? 'NA' : date('d-m-Y', strtotime($other_data_arr['tour_date'])),
				date('d-m-Y', strtotime($booking_array_item['booking_date'])),
				number_format($other_data_arr['booking_amount'],2),
				($other_data_arr['tour_type'] != 'Group Tour') ? number_format($other_data_arr['total_purchase'],2) : 'NA',
				($other_data_arr['tour_type'] != 'Group Tour') ? number_format($other_data_arr['booking_amount'] - $other_data_arr['total_purchase'],2):'NA',
				($other_data_arr['tour_type'] != 'Group Tour') ? number_format($incentive_amount,2):'NA',
				$edit
				
				), "bg" =>$bg);
			array_push($array_s,$temp_arr); 
					
		}
		$footer_data = array("footer_data" => array(
			'total_footers' => 1,
					
			'foot0' => "Total Incentive :".number_format($incentive_total, 2),
			'col0' => 11,
			'class0' => "text-right"		
			)
		);
		array_push($array_s, $footer_data);
		echo json_encode($array_s);
		
		?>