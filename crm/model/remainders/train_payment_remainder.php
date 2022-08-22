<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	 global $secret_key,$encrypt_decrypt;

 	$sq_train = mysqli_num_rows(mysqlQuery("select * from train_ticket_master where payment_due_date='$due_date'"));

 	if($sq_train>0){

	 	$sq_train_details =  mysqlQuery("select * from train_ticket_master where payment_due_date='$due_date'");

		while ($row_train = mysqli_fetch_assoc($sq_train_details)) {

			$train_id = $row_train['train_ticket_id'];
			$date = $row_train['created_at'];
			$yr = explode("-", $date);
			$year = $yr[0];
			$booking_id = get_train_ticket_booking_id($train_id,$year);
			$train_total_cost = $row_train['net_total'];
			$tour_name = 'NA';
			$customer_id = $row_train['customer_id'];

			$sq_cust = mysqlQuery("select * from customer_master where customer_id='$customer_id'");

			while($row_cust = mysqli_fetch_assoc($sq_cust)){

				$email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
				if($row_cust['type'] == 'Corporate'||$row_cust['type'] == 'B2B'){
					$customer_name = $row_cust['company_name'];
				}else{
					$customer_name = $row_cust['first_name'].' '.$row_cust['last_name'];
				}
				$sq_total_paid = mysqlQuery("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$train_id' and (clearance_status='Cleared' or clearance_status='')");

				while($row_paid = mysqli_fetch_assoc($sq_total_paid)){

				$paid_amount = $row_paid['sum'];

				$balance_amount = $train_total_cost - $paid_amount;

				if($balance_amount>0){
					$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'train_payment_pending_remainder' and date='$due_date' and status='Done'"));
					if($sq_count==0)
					{	
						$subject = 'Train Ticket payment Reminder !';
						global $model;	
					$model->generic_payment_remainder_mail('84', $customer_name,$balance_amount, $tour_name, $booking_id, $customer_id, $email_id, $subject,$train_total_cost,$due_date);
					}
				}
				}
		}
}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','train_payment_pending_remainder','$due_date','Done')");
?>