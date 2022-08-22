<?php include "../../../model/model.php"; ?>
<?php

$payment_id_arr = $_GET['payment_id_arr'];
$payment_id_arr = explode(',', $payment_id_arr);
$payment_id_arr = join("','", $payment_id_arr);

$sq_payment = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from car_rental_payment where payment_id in ('$payment_id_arr')"));

$total_amount = $sq_payment['sum'];

$bank_name_arr1 = array();
$branch_name1 = array();
$bank_id_arr1 = array();
$cheque_no1 = array();
$amount1 = array();
for ($i = 0; $i < 8; $i++) {
	$bank_name_arr1[$i] = "";
	$bank_id_arr1[$i] = "";
	$branch_name1[$i] = "";
	$cheque_no1[$i] = "";
	$amount1[$i] = "";
}

include_once('../layout/index.php');
?>
