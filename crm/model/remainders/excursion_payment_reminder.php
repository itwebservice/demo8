<?php
include_once('../model.php');
global $secret_key,$encrypt_decrypt;
$due_date=date('Y-m-d');
$sq_air = mysqli_num_rows(mysqlQuery("select * from excursion_master where due_date='$due_date'"));
if($sq_air>0){

	$sq_air_details = mysqlQuery("select * from excursion_master where due_date='$due_date'");
	while($row_air = mysqli_fetch_assoc($sq_air_details)){

		$air_id = $row_air['exc_id'];
		$date = $row_air['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];
		$exc_id = get_exc_booking_id($air_id,$year);

		$exc_total_cost = $row_air['exc_total_cost'];
		$tour_name = 'NA';
		$customer_id = $row_air['customer_id'];

		$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
		if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
			$customer_name = $sq_cust['company_name'];
		}else{
			$customer_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
		}
	
		$email_id = $encrypt_decrypt->fnDecrypt($sq_cust['email_id'], $secret_key);
		$sq_total_paid = mysqlQuery("select sum(payment_amount) as sum from exc_payment_master where exc_id='$air_id' and (clearance_status='Cleared' or clearance_status='')");
		while($row_paid = mysqli_fetch_assoc($sq_total_paid)){

			$paid_amount = $row_paid['sum'];
    		$balance_amount = $exc_total_cost - $paid_amount;
			if($balance_amount>0){
				$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'excursion_payment_pending_remainder' and date='$due_date' and status='Done'"));
				if($sq_count==0){
					global $model;
					$subject = 'Excursion Payment Reminder !';
					$model->generic_payment_remainder_mail('89',$customer_name,$balance_amount, $tour_name, $exc_id, $customer_id, $email_id,$subject,$exc_total_cost,$due_date);
				}
			}
		}
	}
}

$row = mysqlQuery("SELECT max(id) as max from remainder_status");
$value = mysqli_fetch_assoc($row);
$max = $value['max']+1;
$sq_check_status = mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','excursion_payment_pending_remainder','$due_date','Done')");
?>