<?php 
include_once('../../../model.php');
$quotation_id = $_GET['quotation_id'];

$quotation_id = base64_decode($quotation_id);

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
$date = $sq_quotation['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$email_id = $app_email_id;
}
else{
	$email_id = $sq_emp_info['email_id'];
}
$date = date('d-m-Y H:i');
global $app_name;
global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

$content = '
			<tr>
				<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
					<tr><td colspan="2" style="text-align:left;border: 1px solid #888888;">Customer viewed quotation but not further interested for tour</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;">Quotation ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.get_quotation_id($quotation_id,$year).'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['email_id'].'</td></tr>
					<tr><td style="text-align:left;border: 1px solid #888888;">Date/Time of review</td>   <td style="text-align:left;border: 1px solid #888888;">'.$date.'</td></tr>
				</table>
			</tr>
';

$subject = "Customer Not Interested!";
$model->app_email_master($email_id, $content, $subject);
?>
<script>
setTimeout(function () {
	window.history.back();
},10000);
</script>