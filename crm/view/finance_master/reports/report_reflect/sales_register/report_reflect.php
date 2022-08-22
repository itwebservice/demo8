<?php
include "../../../../../model/model.php"; 
$sale_type = $_POST['sale_type'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$financial_year_id = $_SESSION['financial_year_id'];

$array_s = array();
$temp_arr = array();
$count = 1;
$total_amount = 0;
$query = "SELECT * FROM `ledger_master` WHERE 1 and `group_sub_id` not in('20','105')"; 
$sq_query = mysqlQuery($query);
$finDate = mysqli_fetch_assoc(mysqlQuery("SELECT `from_date`, `to_date` FROM `financial_year` WHERE `financial_year_id` = '$financial_year_id'"));

while($row_query = mysqli_fetch_assoc($sq_query)){

	$f_query = "select * from finance_transaction_master where gl_id='$row_query[ledger_id]' and type='INVOICE' and module_name!='Journal Entry'";
	if($from_date != '' && $to_date != ''){
		$from_date = get_date_db($from_date);
		$to_date = get_date_db($to_date);
		$f_query .= " and payment_date between '$from_date' and '$to_date'";
	}else{
		$from_date = $finDate['from_date'];
		$to_date = $finDate['to_date'];
		$f_query .= " and payment_date between '$from_date' and '$to_date'";
	}
	if($sale_type != ''){
		$f_query .= " and module_name = '$sale_type'";
	}
	if($branch_status == 'yes'){
		if($role == 'Branch Admin' || $role == 'Accountant'){
			$f_query .= " and branch_admin_id='$branch_admin_id'";
		}
	}
	$sq_finance = mysqlQuery($f_query);
	while($row_finance = mysqli_fetch_assoc($sq_finance)){

		$total_amount += $row_finance['payment_amount'];
		$customer_name = get_customer_name($row_finance['module_name'],$row_finance['module_entry_id']);

		if($row_finance['module_name']=='Excursion Booking')
			$module_name = 'Activity Booking';
		else if($row_finance['module_name']=='Air Ticket Booking')
			$module_name = 'Flight Booking';
		else if($row_finance['module_name']=='Train Ticket Booking')
			$module_name = 'Train Booking';
		else
			$module_name = $row_finance['module_name'];
		
		$temp_arr = array( "data" => array(
			(int)($count++),
			$module_name,
			$customer_name,
			$row_finance['module_entry_id'],
			$row_finance['payment_amount'] 
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
	}
}
$footer_data = array("footer_data" => array(
	'total_footers' => 2,
	
	'foot0' => "Total",
	'col0' => 4,
	'class0' =>"text-right",

	'foot1' => number_format($total_amount,2),
	'col1' => 1,
	'class1' =>"text-right success"
));

array_push($array_s, $footer_data);
echo json_encode($array_s);
?>