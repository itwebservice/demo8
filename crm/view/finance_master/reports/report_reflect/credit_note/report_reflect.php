<?php 
include "../../../../../model/model.php"; 
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
$count = 1;
$total_amount = 0;
$query = "SELECT * FROM `credit_note_master` where 1 and payment_amount!=0 "; 
if($to_date != ''){
$to_date = get_date_db($to_date);
$query .= " and created_at <= '$to_date'";
}
if($branch_status == 'yes' && $role == 'Branch Admin'){
	$query .= " and branch_admin_id='$branch_admin_id'";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type']=='Corporate'||$sq_cust['type'] == 'B2B'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}
	$total_amount += $row_query['payment_amount'];
	if($row_query['module_name']=='Excursion Booking')
		$module_name = 'Activity Booking';
	else if($row_query['module_name']=='Air Ticket Booking')
		$module_name = 'Flight Booking';
	else if($row_query['module_name']=='Train Ticket Booking')
		$module_name = 'Train Booking';
	else
		$module_name = $row_query['module_name'];
		
	$temp_arr = array( "data" => array(
		(int)($count++),
		get_date_user($row_query['created_at']) ,
		$cust_name,
		$module_name,
		$row_query['module_entry_id'],
		$row_query['payment_amount']
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 1,
	'foot0' => "Total : ".number_format($total_amount,2),
	'col0' => 6,
	'foot1' => "",
	'col1' => 1,
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);	 
?>