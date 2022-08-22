<?php
class visa_status
{
	public function visa_status_save()
	{
		$booking_type = $_POST['booking_type'];
		$doc_status = $_POST['doc_status'];
		$traveler_id = $_POST['traveler_id'];
		$booking_id = $_POST['booking_id'];
		$comment = $_POST['comment'];

		$status_date = date('Y-m-d H:i');
		$count = mysqli_num_rows(mysqlQuery("select * from visa_status_entries where booking_type='$booking_type' and traveler_id = '$traveler_id'"));	
		$comment = addslashes($comment);	
		if($count == 0){
			//insert
			$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from visa_status_entries"));
            $id = $sq_max['max'] + 1;
			$sq = mysqlQuery("insert into visa_status_entries(id,booking_type,booking_id, doc_status,traveler_id, comment, created_at)values ('$id','$booking_type','$booking_id','$doc_status','$traveler_id','$comment','$status_date')");
		}
		else{
			//update if exist
			$sq = mysqlQuery("update visa_status_entries set doc_status='$doc_status',comment = '$comment',created_at = '$status_date' where (booking_type = '$booking_type' and traveler_id = '$traveler_id')");
		}		
	    if($sq)
		 {
		 	echo "Visa Status has been successfully saved.";
		    
		    //send mail
		    $this->visa_status_send($booking_type,$booking_id,$traveler_id);
		 }

	}

	public function visa_status_send($booking_type,$booking_id,$traveler_id)
	{
		global $app_name;	
		global $secret_key,$encrypt_decrypt;
		$query = "select * from visa_status_entries where booking_type ='$booking_type' and booking_id = '$booking_id' and traveler_id = '$traveler_id'";
		$sq_report = mysqli_fetch_assoc(mysqlQuery($query));

		//get passenger name
		if($booking_type=="visa_booking")
		{
			$sq_visa = mysqli_fetch_assoc(mysqlQuery("select * from visa_master_entries where entry_id='$traveler_id' and status != 'Cancel'"));  
			$passenger_name =  $sq_visa['first_name'].' '.$sq_visa['last_name'];
			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from visa_master where visa_id='$booking_id'"));
			$sq_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_customer[customer_id]'"));
			if($sq_email['type']=='Corporate'||$sq_email['type'] == 'B2B'){
				$customer_name = $sq_email['company_name'];
			}else{
				$customer_name = $sq_email['first_name'].' '.$sq_email['last_name'];
			}
			$mobile_no = $encrypt_decrypt->fnDecrypt($sq_email['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_email['email_id'], $secret_key); 
		}
		if($booking_type=="package_tour")
		{
			$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from package_travelers_details where traveler_id='$traveler_id' and status != 'Cancel'")); 
			
			$passenger_name =  $sq_package['first_name'].' '.$sq_package['last_name'];
			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$booking_id'"));
			$sq_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_customer[customer_id]'"));
			if($sq_email['type']=='Corporate'||$sq_email['type'] == 'B2B'){
				$customer_name = $sq_email['company_name'];
			}else{
				$customer_name = $sq_email['first_name'].' '.$sq_email['last_name'];
			}
			$mobile_no = $encrypt_decrypt->fnDecrypt($sq_email['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_email['email_id'], $secret_key); 
		}
		if($booking_type=="group_tour")
		{
			$sq_group = mysqli_fetch_assoc(mysqlQuery("select * from travelers_details where traveler_id='$traveler_id' and status != 'Cancel'")); 
			$passenger_name =  $sq_group['first_name'].' '.$sq_group['last_name'];
			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where id='$booking_id'"));
			$sq_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_customer[customer_id]'"));
			if($sq_email['type']=='Corporate'||$sq_email['type'] == 'B2B'){
				$customer_name = $sq_email['company_name'];
			}else{
				$customer_name = $sq_email['first_name'].' '.$sq_email['last_name'];
			}
			$mobile_no = $encrypt_decrypt->fnDecrypt($sq_email['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_email['email_id'], $secret_key); 

		}
		if($booking_type=="flight_booking")
		{
			$sq_flight = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master_entries where entry_id='$traveler_id' and status != 'Cancel'")); 

			$passenger_name =  $sq_flight['first_name'].' '.$sq_flight['last_name'];
			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$booking_id'"));
			$sq_email = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_customer[customer_id]'"));
			if($sq_email['type']=='Corporate'||$sq_email['type'] == 'B2B'){
				$customer_name = $sq_email['company_name'];
			}else{
				$customer_name = $sq_email['first_name'].' '.$sq_email['last_name'];
			}
			$mobile_no = $encrypt_decrypt->fnDecrypt($sq_email['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_email['email_id'], $secret_key); 
		}

			$content = '
			<table style="color:#22262e;font-size:13px;width:90%;margin-bottom:20px">	
			
			<tr>
				<td colspan="2"><strong>Passenger Name : '.$passenger_name.'</strong></td>
			</tr>	      
			<tr>
				<td colspan="2"><strong>Current visa status : '.$sq_report['doc_status'].'</strong></td>
			</tr>	      
			<tr>
				<td colspan="2"><strong>Description : '.$sq_report['comment'].'</strong></td>
			</tr>
			</table>';

		global $model;
		$subject = "Visa Status Details!";
		$model->app_email_send('91',$customer_name,$email_id, $content, $subject);

		$message = "Hello... Greeting from  Company Name. Thank you for applying Visa with ".$app_name.". Passenger Name : ".$passenger_name." . Current visa status : ".$sq_report['doc_status'].".  Description : ".$sq_report['comment']." .";

		$model->send_message($mobile_no, $message);


	}

}
?>