<?php 
include_once('../../../model/model.php');

$branch_id = $_POST['branch_id'];
if($branch_id !=''){
	$sq_address = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id='$branch_id' "));
	if($sq_address['address1']!=''|| $sq_address['address2']!=''){
		echo  $sq_address['address1'].' '.$sq_address['address2'];
	}
	else{
		echo '';
	}
}
else{
	echo '';
}
 
?>