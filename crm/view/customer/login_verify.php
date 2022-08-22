<?php
include "../../model/model.php";
global $secret_key;
$mobile_no = $_POST['txt_mobile_no'];
$email_id = $_POST['txt_email_id'];

$mobile_no = $encrypt_decrypt->fnEncrypt($mobile_no, $secret_key);
$email_id = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
$sq_customer_count = mysqli_num_rows(mysqlQuery("select * from customer_master where contact_no='$mobile_no' and email_id='$email_id' and active_flag = 'Active'"));
if($sq_customer_count == 0){
	header("Location:index.php?status=false");
}
else{

	$_SESSION['contact_no'] = $mobile_no;
	$_SESSION['email_id'] = $email_id;
	$_SESSION['login_type'] = "Customer Login";

	$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where contact_no='$mobile_no' and email_id='$email_id' and active_flag = 'Active'"));
	$_SESSION['customer_id'] = $sq_customer_info['customer_id'];
	header("Location:other/dashboard_main.php");
}
?>