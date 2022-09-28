<?php
class cancel_estimate_master{

public function cancel_estimate()
{
	$estimate_id = $_POST['estimate_id'];

	$sq_cancel = mysqlQuery("update vendor_estimate set status='Cancel' where estimate_id='$estimate_id'");
	if($sq_cancel){
		echo "Purchase has been successfully cancelled!";
		exit;
	}
	else{
		echo "error--Sorry, Purchase has not been successfully cancelled!";
		exit;
	}
}

}
?>