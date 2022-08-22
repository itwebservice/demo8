<?php
include_once('../model.php');
$today = date('Y-m-d');
$end_date = date('Y-m-d', strtotime('-5 days', strtotime($today)));

global $secret_key,$encrypt_decrypt;
$sq_tour_group = mysqli_num_rows(mysqlQuery("select * from tour_groups where to_date='$end_date'"));
if($sq_tour_group>0){

	$sq_tour_group1 = mysqlQuery("select * from tour_groups where to_date='$end_date'");
	while($row_tour = mysqli_fetch_assoc($sq_tour_group1)){

		$tour_to_date = $row_tour['to_date'];
		$tour_id = $row_tour['tour_id'];
		$tour_group_id = $row_tour['group_id'];

		$sq_tour =  mysqlQuery("select * from tour_master where tour_id='$tour_id'");
		while ($row_tour1 = mysqli_fetch_assoc($sq_tour)){

			$tour_name = $row_tour1['tour_name'];
			$journey_date = date('d-m-Y',strtotime($row_tour['from_date'])).' To '.date('d-m-Y',strtotime($row_tour['to_date']));

			$sq_bookings = mysqlQuery("select * from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id'");
			while($row_bookings = mysqli_fetch_assoc($sq_bookings)){

				$tourwise_traveler_id = $row_bookings['id'];
				$customer_id = $row_bookings['customer_id'];

				$date = $row_bookings['form_date'];
				$yr = explode("-", $date);
				$year =$yr[0];
				$tourwise_traveler_id1 = get_group_booking_id($tourwise_traveler_id,$year);
				
				$row_cust = mysqli_fetch_assoc( mysqlQuery("select * from customer_master where customer_id ='$customer_id'"));
				$username = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
				$password = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
				$cust_name = $row_cust['first_name'].' '.$row_cust['last_name'];

				$sq_personal_info =  mysqlQuery("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_traveler_id'");
				while($row_per = mysqli_fetch_assoc($sq_personal_info)){
					
					$email_id = $row_per['email_id'];
					$mobile_no = $row_per['mobile_no'];

					$sq_count = mysqli_num_rows(mysqlQuery("SELECT * from  remainder_status where remainder_name = 'git_feedback_remainder' and date='$today' and status='Done'"));
					if($sq_count==0){

						feedback_email_send($email_id,$tourwise_traveler_id1,$tour_name,$journey_date,$username,$password,$row_cust['first_name'],$customer_id,$tourwise_traveler_id);
					}
					if($mobile_no!=""){
						feedback_sms_send($mobile_no);
					}
				}
			}
		}
	}
}
$row=mysqlQuery("SELECT max(id) as max from remainder_status");
$value=mysqli_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysqlQuery("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','git_feedback_remainder','$today','Done')");

function feedback_email_send($email_id,$tourwise_traveler_id,$tour_name,$journey_date,$username,$password,$cust_name,$customer_id,$atourwise_traveler_id)
{
	
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$theme_color;
	$link = BASE_URL.'view/customer';
	 
	

	$content = '
	<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Booking ID </td>   <td style="text-align:left;border: 1px solid #888888;">'.$tourwise_traveler_id.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$tour_name.'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;"> Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$journey_date.'</td></tr>
		</table>
		</tr>
		<tr>
		<td>
		<table style="padding:0 30px; margin:0px auto; margin-top:10px">
		<tr>
		<td colspan="2">
				<a style="font-weight:500;font-size:14px;display:inline-block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 15px;border-radius:25px;width:auto;text-align:center" href="'.BASE_URL.'view/customer/other/customer_feedback/customer_feedback_form.php?customer_id='.$customer_id.'&booking_id='.$atourwise_traveler_id.'&tour_name=Group Booking" target="_blank">Tour Feedback</a>
		</td>
	</tr>
	
	</table>
	</td>
	</tr> ';
	global $model;
	$subject = 'Invite you to leave us your FEEDBACK! (Tour Name : '.$tour_name.' , Customer Name : '.$cust_name.' .';
	$model->app_email_send('79',$cust_name,$password, $content,$subject,'1');
}


function feedback_sms_send($mobile_no)
{
	global $app_name,$model;
	
	$message = "We take the opportunity of your valuable feedback of ".".$app_name."." tours that will help to continue our high quality and to save precious customers.";
	$model->send_message($mobile_no, $message);
}
?>