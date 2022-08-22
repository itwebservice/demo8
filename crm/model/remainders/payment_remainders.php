<?php
include_once('../model.php');
$due_date=date('Y-m-d');
$sq_tour = mysqli_num_rows(mysqlQuery("select * from tourwise_traveler_details where balance_due_date='$due_date' and tour_group_status!='cancel'"));
	if($sq_tour>0){
	 	$sq_tour_details = mysqlQuery("select * from tourwise_traveler_details where balance_due_date='$due_date' and tour_group_status!='cancel'");
		while($row_tour = mysqli_fetch_assoc($sq_tour_details)){

			$booking_id = $row_tour['id'];
			$date = $row_hotel['form_date'];
			$yr = explode("-", $date);
			$year = $yr[0];
			$booking_id1 = get_group_booking_id($booking_id,$year);

			$total_tour_fee = $row_tour['net_total'];
			$tour_id = $row_tour['tour_id'];
			$customer_id = $row_tour['customer_id'];

			$sq_tour_name = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$tour_id'"));
			$tour_name = $sq_tour_name['tour_name'];

			$total_amount =  $total_tour_fee;

			$sq_total_paid = mysqlQuery("select sum(amount) as sum from payment_master where tourwise_traveler_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");

			while($row_total_paid = mysqli_fetch_assoc($sq_total_paid)){
			
				$paid_amount = $row_total_paid['sum'];
				$payment_remain = $total_amount - $paid_amount;
				$sq_cust = mysqlQuery("select * from traveler_personal_info where tourwise_traveler_id='$booking_id'");

				while($row_cust = mysqli_fetch_assoc($sq_cust)){
					$email_id = $row_cust['email_id'];
					$t_id = $row_cust['tourwise_traveler_id'];
					$c_id = mysqli_fetch_assoc(mysqlQuery("select customer_id from tourwise_traveler_details"));
					$name = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$c_id[customer_id]'"));  
					if($name['type'] == 'Corporate'||$name['type'] == 'B2B'){
						$customer_name = $name['company_name'];
					}else{
						$customer_name = $name['first_name'].' '.$name['last_name'];
					}
					$payment_id = get_group_booking_payment_id($payment_id);

					if($payment_remain>0){
						$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'git_payment_pending_remainder' and date='$due_date' and status='Done'"));
						if($sq_count==0){
							$subject = 'Group Tour Payment Reminder ! (Booking ID : '.$booking_id.' ).';
							global $model;
							$model->generic_payment_remainder_mail('80',$customer_name,$payment_remain, $tour_name, $booking_id1, $customer_id, $email_id ,$subject,$total_amount,$due_date);
						}				
					}
				}
			}
	}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','git_payment_pending_remainder','$due_date','Done')");
?>