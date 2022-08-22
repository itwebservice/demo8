<?php
include_once("../../../model/model.php");
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$customer_id = $_POST['customer_id'];
$array_s = array();
$temp_arr = array();
$footer_data = array();
$financial_year_id = $_SESSION['financial_year_id'];

$query = "select * from finance_transaction_master where module_name='B2B Booking' and payment_amount!='0' and module_entry_id in(select booking_id from b2b_booking_master where customer_id='$customer_id')";
if($from_date!="" && $to_date !=""){
	$from_date = date('Y-m-d',strtotime($from_date));
	$to_date = date('Y-m-d',strtotime($to_date));
	$query .=" and (payment_date>='$from_date' and payment_date<='$to_date') ";
}
$query .= " order by finance_transaction_id desc";	
$count = 0;
$credit_total = 0;
$debit_total = 0;
$sq_customer = mysqlQuery($query);
while($row_customer = mysqli_fetch_assoc($sq_customer)){
    $credit_amount = ($row_customer['payment_side'] == 'Credit') ? $row_customer['payment_amount'] : '0';	
    $dedit_amount = ($row_customer['payment_side'] == 'Debit') ? $row_customer['payment_amount'] : '0';

    $bg = ($row_customer['payment_side'] == 'Credit') ? 'table-success' : 'table-danger';
    $temp_arr = array( "data" => array (
        (int)(++$count),
         date('d-m-Y',strtotime($row_customer['payment_date'])),
         $row_customer['payment_particular'],
         number_format($dedit_amount,2),
         number_format($credit_amount,2)), "bg" => $bg
    );
    $credit_total += $credit_amount;
    $debit_total += $dedit_amount;
    array_push($array_s,$temp_arr); 
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	'foot0' => '',
	'col0' => 2,
	'namecol0' => "",
	'foot1' => '',
	'col1' => 1,
	'namecol1' => "Total",
	'foot2' => number_format($debit_total,2),
	'col2' => 1,
	'namecol2' => "",
	'foot3' => number_format($credit_total,2),
	'col3' => 1,
	'namecol3' => ""
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>