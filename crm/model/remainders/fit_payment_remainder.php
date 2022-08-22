<?php
include_once('../model.php');
 
 	$due_date=date('Y-m-d');

 	$sq_package = mysqli_num_rows(mysqlQuery("select * from package_tour_booking_master where due_date='$due_date' and tour_status!='cancel'"));

	if($sq_package>0){

	 	$sq_tour_details = mysqlQuery("select * from package_tour_booking_master where due_date='$due_date' and tour_status!='cancel'");

		while($row_tour_details= mysqli_fetch_assoc($sq_tour_details)){

			$booking_id = $row_tour_details['booking_id'];
			$date = $row_tour_details['booking_date'];
			$yr = explode("-", $date);
			$year = $yr[0];
			$package_id = get_package_booking_id($booking_id,$year);

			$total_tour_fee = $row_tour_details['net_total'];
			$tour_name = $row_tour_details['tour_name'];
			$customer_id = $row_tour_details['customer_id'];
			$email_id = $row_tour_details['email_id'];

			$total_amount = $total_tour_fee;

			$sq_total_paid =  mysqlQuery("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");
			$customer_name = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
			if($customer_name['type'] == 'Corporate'||$customer_name['type'] == 'B2B'){
				$customer_name1 = $customer_name['company_name'];
			}else{
				$customer_name1 = $customer_name['first_name'].' '.$customer_name['last_name'];
			}
			while ($row_paid = mysqli_fetch_assoc($sq_total_paid)) {

				$paid_amount = $row_paid['sum'];
				$balance_amount = $total_amount - $paid_amount;

				if($balance_amount>0){
					$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'fit_payment_pending_remainder' and date='$due_date' and status='Done'"));
					if($sq_count==0)
					{	
						$subject = 'Package Tour Payment Reminder';
						global $model;
						$model->generic_payment_remainder_mail('81',$customer_name1,$balance_amount, $tour_name, $package_id, $customer_id, $email_id,$subject,$total_amount,$due_date );
					}
				}
			}
		}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','fit_payment_pending_remainder','$due_date','Done')");
?>