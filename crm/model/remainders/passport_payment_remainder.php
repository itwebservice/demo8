<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	global $secret_key,$encrypt_decrypt;
 	$sq_passport = mysqli_num_rows(mysqlQuery("select * from passport_master where due_date='$due_date'"));

 	if($sq_passport>0){

	 	$sq_passport_details = mysqlQuery("select * from passport_master where due_date='$due_date'");

	 	while($row_passport = mysqli_fetch_assoc($sq_passport_details)){

	 	$passport_id = $row_passport['passport_id'];
	 	$passport_total_cost = $row_passport['passport_total_cost'];
	 	$tour_name = 'NA';
	 	$customer_id = $row_passport['customer_id'];

	 	$sq_cust =  mysqlQuery("select * from customer_master where customer_id='$customer_id'");

	 	while ($row_cust = mysqli_fetch_assoc($sq_cust)) {
	 		 
		 
		   $email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
		   $sq_total_paid = mysqlQuery("select sum(payment_amount) as sum from passport_payment_master where passport_id='$passport_id' and (clearance_status='Cleared' or clearance_status='')");

		  while($row_paid = mysqli_fetch_assoc($sq_total_paid)){
		  $paid_amount = $row_paid['sum'];
		  $balance_amount = $passport_total_cost - $paid_amount;		  
		  if($balance_amount>0){
		  	$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'passport_payment_pending_remainder' and date='$due_date' and status='Done'"));
			if($sq_count==0){
				global $model;
				$subject = 'Passport Payment Reminder ( Booking ID :'.$booking_id.' ).';
				$model->generic_payment_remainder_mail('88', $row_cust['first_name'],$balance_amount, $tour_name, $passport_id, $customer_id, $email_id, $subject,$passport_total_cost,$due_date);
			}
		  }
	   }
	}
}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','passport_payment_pending_remainder','$due_date','Done')");

?>