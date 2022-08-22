<?php 
class sms_group{

public function sms_group_save()
{

	$sms_group_name = addslashes($_POST['sms_group_name']);
	$created_at = date('Y-m-d');
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(sms_group_id) as max from sms_group_master"));
	$sms_group_id = $sq_max['max'] + 1;

	$sq_sms_group_count = mysqli_num_rows(mysqlQuery("select * from sms_group_master where sms_group_name='$sms_group_name'"));
	if($sq_sms_group_count>0){
		echo "error--Sorry, This Sms group already exists!";
		exit;
	}

	$sq_sms_group = mysqlQuery("insert into sms_group_master ( sms_group_id, branch_admin_id, sms_group_name, created_at ) values ( '$sms_group_id', '$branch_admin_id', '$sms_group_name', '$created_at' )");
	if($sq_sms_group){
		echo " SMS group has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Sms group not saved!";
		exit;
	}

}

public function sms_group_update()
{
	$sms_group_id = $_POST['sms_group_id'];
	$sms_group_name = addslashes($_POST['sms_group_name']);

	$sq_sms_group_count = mysqli_num_rows(mysqlQuery("select * from sms_group_master where sms_group_name='$sms_group_name' and sms_group_id!='$sms_group_id'"));
	if($sq_sms_group_count>0){
		echo "error--Sorry, This Sms group already exists!";
		exit;
	}

	$sq_sms_group = mysqlQuery("update sms_group_master set sms_group_name='$sms_group_name' where sms_group_id='$sms_group_id'");
	if($sq_sms_group){
		echo "SMS group has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Sms group not updated!";
		exit;
	}
}

}
?>