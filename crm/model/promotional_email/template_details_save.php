<?php
class template{

public function template_details_save()
{
	$invoice_url = $_POST['invoice_url'];
	$email_template_type = addslashes($_POST['email_template_type']);
	$created_at = date('Y-m-d');
	
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(template_id) as max from email_template_master"));
	$template_id = $sq_max['max'] + 1;

	$sq_email_id_count = mysqli_num_rows(mysqlQuery("select * from email_template_master where template_type='$email_template_type'"));
	if($sq_email_id_count>0){
		echo "error--Sorry, This Template Type already exists!";
		exit;
	}
	else
	{
		$sq_email_id = mysqlQuery("insert into email_template_master ( template_id, template_type,template_url, created_at ) values ( '$template_id', '$email_template_type','$invoice_url', '$created_at' )");
		
		if($sq_email_id){
			echo "Template has been successfully saved.";
			exit;
		}
		else{
			echo "error--Sorry, Template Details Not Saved!";
			exit;
		}
	}
}

}
?>