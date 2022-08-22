<?php
include_once('../model.php');

class sms_message{
public function sms_message_send()
{
	$template_id = $_POST['template_type'];
	$group_id = $_POST['group_name'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$subject = $_POST['subject'];
	$created_at = date('Y-m-d H:i');
	$subject1 = addslashes($subject);

	$sq_email_group_count = mysqli_num_rows(mysqlQuery("select * from email_send_master where template_id='$template_id' and group_id='$group_id' and created_at='$created_at'"));
	if($sq_email_group_count>0){
		echo "error--Sorry, This Email template already Send to this Group!";
		exit;
	}
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(id) as max from email_send_master"));
	$email_group_id = $sq_max['max'] + 1;

	$sq_email_group = mysqlQuery("insert into email_send_master ( id, branch_admin_id, group_id,template_id ,subject,created_at ) values ( '$email_group_id', '$branch_admin_id' ,'$group_id','$template_id','$subject1' ,'$created_at' )");
	if($sq_email_group){
	
		$this->send_mail($group_id,$template_id,$subject);
		echo "Message has been successfully sent";
		exit;
	}
	else{
		echo "error--Sorry, Email Not send successfully!";
		exit;
	}

	
}
public function send_mail($group_id,$template_id,$subject)
{
	$sql_template = mysqli_fetch_assoc(mysqlQuery("select * from email_template_master where template_id='$template_id'"));
	$newUrl1 = preg_replace('/(\/+)/','/',$sql_template['template_url']);
	$newUrl = explode('uploads', $newUrl1);
	$download_url = BASE_URL.'uploads'.$newUrl[1];
	$content = ' 
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr>
					<td style="text-align:left;border: 1px solid #888888;width:20%"><img src="'.$download_url .'" class="img-responsive" ></td>
				</tr>
			</table>
		</tr>	';
	$sql_grp = mysqlQuery("select * from email_group_entries where email_group_id='$group_id'");
	while($row_group = mysqli_fetch_assoc($sql_grp))
	{
		global $model;
		$email_id = $row_group['email_id_id'];
		$sql_email_id = mysqli_fetch_assoc(mysqlQuery("select * from sms_email_id where email_id_id = '$email_id'"));
		$model->app_email_send('','',$sql_email_id['email_id'], $content,$subject,'1');
	}

	echo "Email successfully sent.";
	exit;
}

}

?>