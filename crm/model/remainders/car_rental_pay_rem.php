<?php
include_once('../model.php');
$due_date=date('Y-m-d');
global $secret_key,$encrypt_decrypt;
$sq_car_rental= mysqli_num_rows(mysqlQuery("select * from car_rental_booking where due_date='$due_date' and status!='Cancel'"));

if($sq_car_rental>0){

	$sq_car_rental_details = mysqlQuery("select * from car_rental_booking where due_date='$due_date' and status!='Cancel'");
	while($row_car=mysqli_fetch_assoc($sq_car_rental_details)) {

		$booking_id = $row_car['booking_id'];
		$total_cost = $row_car['total_fees'];
		$tour_name = 'NA';
		$customer_id = $row_car['customer_id'];
		$date = $row_car['created_at'];
		$yr = explode("-", $date);
		$year = $yr[0];
		$car_id = get_car_rental_booking_id($booking_id, $year);

		$sq_cust = mysqlQuery("select * from customer_master where customer_id='$customer_id'");

		while($row_cust=mysqli_fetch_assoc($sq_cust)){
	
			$contact_no = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
			$customer_name = ($row_cust['type'] == 'Corporate' || $row_cust['type'] == 'B2B') ? $row_cust['company_name'] : $row_cust['first_name'].' '.$row_cust['last_name'];
			$sq_total_paid = mysqlQuery("select sum(payment_amount) as sum from car_rental_payment where booking_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");
			while ($row_paid=mysqli_fetch_assoc($sq_total_paid)) {
				
				$paid_amount = $row_paid['sum'];
				$balance_amount = $total_cost - $paid_amount;
				if($balance_amount>0){

					$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'car_payment_pending_remainder' and date='$due_date' and status='Done'"));
						if($sq_count==0)
						{
							$subject = 'Car Rental payment Reminder !';
							global $model;	
							$model->generic_payment_remainder_mail('87',$customer_name,$balance_amount, $tour_name, $car_id, $customer_id, $email_id, $subject,$total_cost,$due_date);
						}
				}
			}
		}
	}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','car_payment_pending_remainder','$due_date','Done')");
?>