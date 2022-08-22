<?php 

$flag = true;

class miscellaneous_cancel{



public function miscellaneous_cancel_save()

{

	$entry_id_arr = $_POST['entry_id_arr'];
	for($i=0; $i<sizeof($entry_id_arr); $i++){

		$sq_cancel = mysqlQuery("update miscellaneous_master_entries set status='Cancel' where entry_id='$entry_id_arr[$i]'");

		if(!$sq_cancel){

			echo "error--Sorry, Cancelation not done!";

			exit;

		}

	}

	//Cancelation notification mail send

	$this->cancel_mail_send($entry_id_arr);



	//Cancelation notification sms send

	$this->cancelation_message_send($entry_id_arr);



	echo "Miscellaneous booking has been successfully cancelled.";

	

}

public function cancel_mail_send($entry_id_arr)

{
	global $app_name,$encrypt_decrypt,$secret_key;
	$sq_entry = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master_entries where entry_id='$entry_id_arr[0]'"));

	$sq_visa_info = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master where misc_id='$sq_entry[misc_id]'"));
	$booking_date = $sq_visa_info['created_at'];
	$yr = explode("-", $booking_date);
	$year =$yr[0];
	$misc_id = $sq_visa_info['misc_id'];
	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
	}


	$content1 = '';



	for($i=0; $i<sizeof($entry_id_arr); $i++)

	{

	$sq_entry = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master_entries where entry_id='$entry_id_arr[$i]'"));



	$content1 .= '<tr>

	                <td style="color: #22262e;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.($i+1).'</td>

	                <td style="color: #22262e;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.$sq_entry['first_name'].' '.$sq_entry['last_name'].'</td>

	              </tr>

	';



	}



	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

	$content = '	                    

        <tr>

          <td>

		  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">

                <tr>
					<th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
					<th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Passenger Name</th>

                </tr>

                '.$content1.'

            </table>

          </td>

        </tr>
	';


	$subject = "Miscellaneous Cancellation Confirmation (" .get_misc_booking_id($misc_id,$year)." )";
	global $model;

	$model->app_email_send('99',$customer_name,$email_id , $content,$subject);

}



public function cancelation_message_send($entry_id_arr)

{

	$sq_entry = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master_entries where entry_id='$entry_id_arr[0]'"));

	$sq_visa_info = mysqli_fetch_assoc(mysqlQuery("select * from miscellaneous_master where misc_id='$sq_entry[misc_id]'"));

	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));



	$message = 'We are accepting your cancellation request for Miscellaneous booking.';

  	global $model;

  	$model->send_message($sq_customer['contact_no'], $message);

}



}

?>