<?php
include "../../../../../model/model.php"; 
include "../../../../vendor/inc/vendor_generic_functions.php"; 
$purchase_type = $_POST['purchase_type'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$role = $_POST['role'];
$array_s = array();
$temp_arr = array();
$count = 1;
$total_amount = 0;

$query = "select * from vendor_estimate where status!='Cancel' ";

if($from_date != '' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and DATE(purchase_date) between '$from_date' and '$to_date'";
}
if($purchase_type != ''){
	$query .= " and vendor_type = '$purchase_type'";
}
if($branch_status == 'yes'){
	if($role == 'Branch Admin'){
		$query .= " and branch_admin_id='$branch_admin_id'";
	}
}
$sq_query = mysqlQuery($query);
while($row_finance = mysqli_fetch_assoc($sq_query))
{
		$total_amount += $row_finance['net_total'];
		$estimate_type_val = get_estimate_type_name($row_finance['estimate_type'], $row_finance['estimate_type_id']);
		$supplier_info_arr = get_supplier_info($row_finance['vendor_type'], $row_finance['estimate_id']);     
		$supplier_name = get_vendor_name_report($row_finance['vendor_type'],$row_finance['vendor_type_id']);  
		$temp_arr = array( "data" => array(
			(int)($count++),
			($supplier_info_arr['estimate_type'] == '') ? 'NA' : $supplier_info_arr['estimate_type'] ,
			$row_finance['vendor_type'],
			($supplier_name == '') ? 'NA' : $supplier_name,
			$estimate_type_val,
			$row_finance['net_total']
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);    
} 	
$footer_data = array("footer_data" => array(
	'total_footers' => 2,
	
	'foot0' => "Total",
	'col0' => 5,
	'class0' =>"text-right",

	'foot1' => number_format($total_amount,2),
	'col1' => 1,
	'class1' =>"text-right success"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);	 
?>