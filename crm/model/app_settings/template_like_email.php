<?php
include_once('../model.php');
$email_id = $_GET['email_id'];
$template_id = $_GET['template_id'];
$today = date('Y-m-d');
$count = mysqli_num_rows(mysqlQuery("select * from email_promo_send_enteries where date='$today' and email_id='$email_id'")); 
$sq_email_template = mysqli_fetch_assoc(mysqlQuery("select * from email_template_master where template_id='$template_id'"));

$content ='
	<table style=" width:100%">
		<tr>
			<td>
				<p>New customer showing interest for your offer. </p>
				<p>Promotional Email : <strong>'.$sq_email_template['template_type'].'</strong> </p>
				<p>Email ID :- <strong>'.$email_id.'</strong></p>
			</td>
		</tr>
	</table>
';
$subject =  "Interest Promotional Email : ".$sq_email_template['template_type'];

if($sq_count==0){
	global $model;
	$model->app_email_master($app_email_id, $content, $subject);
}
$today = date('Y-m-d');

$value = mysqli_fetch_assoc(mysqlQuery("SELECT max(id) as max from email_promo_send_enteries"));
$max=$value['max']+1;
$sq_check_status = mysqlQuery("INSERT INTO `email_promo_send_enteries`(`id`, `date`, `email_id`, `status`) VALUES ('$max',' $today','$email_id','Sent')");	 
echo  "Your request is successfully delivered. The team will contact you soon.";
?>