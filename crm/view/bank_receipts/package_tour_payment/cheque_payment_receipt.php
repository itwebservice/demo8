<?php include "../../../model/model.php"; ?>
<?php

$payment_id = $_GET['payment_id'];
$branch_name = $_GET['branch_name'];
$total_amount = $_GET['total_amount'];
$currency_code_arr = $_GET['currency_code_arr'];

$payment_id_arr = explode(',',$payment_id);
$branch_name_arr = explode(',',$branch_name);
$currency_code_arr = explode(',',$currency_code_arr);

$bank_name_arr1 = array();
$bank_id_arr1 = array();
$branch_name1 = array();
$cheque_no1 = array();
$amount1 = array();
for($i=0; $i<8; $i++)
{
	$bank_name_arr1[$i] = "";
	$bank_id_arr1[$i] = "";
	$branch_name1[$i] = "";
	$cheque_no1[$i] = "";
	$amount1[$i] = "";
}
for($i=0; $i<sizeof($payment_id_arr); $i++)
{
	$sq = mysqlQuery("select * from package_payment_master where payment_id='$payment_id_arr[$i]'");
	while($row = mysqli_fetch_assoc($sq))
	{
		$bank_name_arr1[$i] = $row['bank_name'];
		$bank_id_arr1[$i] = $row['bank_id'];
		$branch_name1[$i] = $branch_name_arr[$i];
		$cheque_no1[$i] = $row['transaction_id'];
		$amount1[$i] = $row['amount'];
	}	
}


include_once('../layout/index.php');
?>
