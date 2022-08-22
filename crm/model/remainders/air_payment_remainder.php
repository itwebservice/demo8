<?php
include_once('../model.php');
$due_date=date('Y-m-d');
global $secret_key,$encrypt_decrypt;
$sq_air = mysqli_num_rows(mysqlQuery("select * from ticket_master where due_date='$due_date'"));

if($sq_air>0){

	$sq_air_details = mysqlQuery("select * from ticket_master where due_date='$due_date'");
	while ($row_air = mysqli_fetch_assoc($sq_air_details)) {

		$air_id = $row_air['ticket_id'];

		$date = $row_air['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];
		$ticket_id = get_ticket_booking_id($air_id,$year);
		
		$air_total_cost = $row_air['ticket_total_cost'];
		$tour_name = 'NA';
		$customer_id = $row_air['customer_id'];

		$sq_cust = mysqlQuery("select * from customer_master where customer_id='$customer_id'");

		while ($row_cust = mysqli_fetch_assoc($sq_cust)) {

			$email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
			if($row_cust['type'] == 'Corporate'||$row_cust['type'] == 'B2B'){
				$customer_name = $row_cust['company_name'];
			}else{
				$customer_name = $row_cust['first_name'].' '.$row_cust['last_name'];
			}

			$sq_total_paid = mysqlQuery("select sum(payment_amount) as sum from ticket_payment_master where ticket_id='$air_id' and (clearance_status='Cleared' or clearance_status='')");

			while ($row_paid = mysqli_fetch_assoc($sq_total_paid)) {

			$paid_amount = $row_paid['sum'];
			$balance_amount = $air_total_cost - $paid_amount;

			if($balance_amount>0){
				$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'air_payment_pending_remainder' and date='$due_date' and status='Done'"));
					if($sq_count==0)
					{
						$subject = 'Flight payment Reminder !';
						global $model;
						$model->generic_payment_remainder_mail('83', $customer_name,$balance_amount, $tour_name, $ticket_id, $customer_id, $email_id, $subject,$air_total_cost,$due_date);
					}
				}
			}
		}
	}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','air_payment_pending_remainder','$due_date','Done')");
?>