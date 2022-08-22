<?php
include "../../model/model.php";
global $encrypt_decrypt, $secret_key;

$username = addslashes($_POST['username']);
$password = $_POST['password'];
$password = $encrypt_decrypt->fnEncrypt($password, $secret_key);

$sq_login_count = mysqli_num_rows(mysqlQuery("select * from vendor_login where username='$username' and password='$password'"));
if($sq_login_count==0){
	$status = "Invalid login credentials!".$password;
	header('location:index.php?status='.$status);
	exit;
}
else{

	$sq_login = mysqli_fetch_assoc(mysqlQuery("select * from vendor_login where username='$username' and password='$password'"));
	$_SESSION['login_id'] = $sq_login['login_id'];
	$_SESSION['username'] = $sq_login['username'];
	$_SESSION['vendor_type'] = $sq_login['vendor_type'];
	$_SESSION['user_id'] = $sq_login['user_id'];
	$_SESSION['email'] = $sq_login['email'];
	$_SESSION['vendor_login'] = true;

	header('location:view/index.php');
	exit;
}

?>