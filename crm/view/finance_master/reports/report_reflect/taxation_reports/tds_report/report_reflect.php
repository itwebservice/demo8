<?php include "../../../../../../model/model.php"; 
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$role = $_POST['role'];
$branch_admin_id = $_POST['branch_admin_id'];
$array_s = array();
$temp_arr = array();

	
	$count = 1;
	//Hotel
	$query = "select * from hotel_booking_master where 1 ";
	if($from_date != '' && $to_date != ''){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$query .= " and DATE(created_at) between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysqlQuery($query);

	while($row_query = mysqli_fetch_assoc($sq_query)){

		$date = $row_query['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];
		//Total hotels count
		$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

		//Cancelled hotels count
		$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

		if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
		{
			$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
			if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
				$cust_name = $sq_cust['company_name'];
			}else{
				$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
			}
			$tds_on_amount = $row_query['sub_total'] + $row_query['service_charge'];
			if($row_query['tds'] != '0'){
				
					$temp_arr = array( "data" => array(
						(int)($count++),
						get_hotel_booking_id($row_query['booking_id'],$year),
						get_date_user($row_query['created_at']),
						$cust_name ,
						($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'],
						number_format($tds_on_amount,2) ,
						number_format($row_query['tds'],2) 

					), "bg" =>$bg);
				array_push($array_s,$temp_arr);
			}
		} 
	}
	//Flight
	$tds_on_amount = 0;
	$query = "select * from ticket_master where 1 ";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and DATE(created_at) between '$from_date' and '$to_date'"; 		
	}
	include "../../../../../../model/app_settings/branchwise_filteration.php";
	$sq_query = mysqlQuery($query);
	while($row_query = mysqli_fetch_assoc($sq_query)){

		$date = $row_query['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];

		//Total passenger count
		$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as booking_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]'"));

		//Cancelled passenger count
		$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as cancel_count from ticket_master_entries where ticket_id ='$row_query[ticket_id]' and status ='Cancel'"));
		if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
		{
			$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
			if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
				$cust_name = $sq_cust['company_name'];
			}else{
				$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
			}
			$tds_on_amount = $row_query['basic_cost'] + $row_query['yq_tax'] + $row_query['service_charge'] - $row_query['basic_cost_discount'];	
			if($row_query['tds'] != '0'){
				
				$temp_arr = array( "data" => array(
					(int)($count++),
					get_ticket_booking_id($row_query['ticket_id'],$year) ,
					get_date_user($row_query['created_at']),
					$cust_name ,
					($sq_cust['pan_no'] == '') ? 'NA' : $sq_cust['pan_no'],
					number_format($tds_on_amount,2) ,
					number_format($row_query['tds'],2) 

				), "bg" =>$bg);
			array_push($array_s,$temp_arr);
			} 
		}
	} 
	//Other Income
	$query = "select * from other_income_master where 1 ";
	if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and DATE(created_at) between '$from_date' and '$to_date'"; 		
	}
	$sq_query = mysqlQuery($query);
	while($row_query = mysqli_fetch_assoc($sq_query))
	{		 
		$date = $row_query['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];
		if($row_query['tds'] != '0'){
			$temp_arr = array( "data" => array(
				(int)($count++),
				get_other_income_payment_id($row_query['income_id'],$year),
				get_date_user($row_query['created_at']),
				$row_query['receipt_from'] ,
				($row_query['pan_no'] == '') ? 'NA' : strtoupper($row_query['pan_no']),
				number_format($row_query['amount'],2) ,
				number_format($row_query['tds'],2) 

			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		}
	}
	echo json_encode($array_s);
	?>	
