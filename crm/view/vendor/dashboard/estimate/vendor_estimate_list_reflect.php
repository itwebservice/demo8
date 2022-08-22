<?php
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$estimate_type = $_POST['estimate_type'];
$vendor_type = $_POST['vendor_type'];
$estimate_type_id = $_POST['estimate_type_id'];
$vendor_type_id = $_POST['vendor_type_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from vendor_estimate where financial_year_id='$financial_year_id' ";
if($estimate_type!=""){
	$query .= "and estimate_type='$estimate_type'";
}
if($vendor_type!=""){
	$query .= "and vendor_type='$vendor_type'";
}
if($estimate_type_id!=""){
	$query .= "and estimate_type_id='$estimate_type_id'";
}
if($vendor_type_id!=""){
	$query .= "and vendor_type_id='$vendor_type_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by `estimate_id` desc ";

$total_estimate_amt = 0;
$total_balance = 0;
$count = 0;
$sq_estimate = mysqlQuery($query);
while($row_estimate = mysqli_fetch_assoc($sq_estimate)){
	$sq_emp =  mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_estimate[emp_id]'"));
	$emp_name = ($row_estimate['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
	$date = $row_estimate['purchase_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$total_estimate_amt = $total_estimate_amt + $row_estimate['net_total'];
	$total_cancel_amt += $row_estimate['cancel_amount'];

	$estimate_type_val = get_estimate_type_name($row_estimate['estimate_type'], $row_estimate['estimate_type_id']);
	$vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);

	$purchase_amount=$row_estimate['net_total']-$row_estimate['cancel_amount'];
	$total_purchase_amt += $purchase_amount;

	$sq_paid_amount_query = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$row_estimate[vendor_type]' and vendor_type_id='$row_estimate[vendor_type_id]' and estimate_type='$row_estimate[estimate_type]' and estimate_type_id='$row_estimate[estimate_type_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$paid_amount = $sq_paid_amount_query['sum'];
	$total_paid_amt += $paid_amount;
	if($total_paid_amt==""){ $total_paid_amt = 0; }

	$cancel_amount = $row_estimate['cancel_amount'];
	if($row_estimate['status']=="Cancel"){
		if($paid_amount > 0){
			if($cancel_amount >0){
				if($paid_amount > $cancel_amount){
					$balance_amount = 0;
				}else{
					$balance_amount = $cancel_amount - $paid_amount;
				}
			}else{
				$balance_amount = 0;
			}
		}
		else{
			$balance_amount = $cancel_amount;
		}
	}
	else{
		$balance_amount = $row_estimate['net_total'] - $paid_amount;
	}

	$total_balance += $balance_amount;
	if($row_estimate['status']=="Cancel") {
		$bg = "danger";
		$cancel_button = '';
		$update_btn = '';
	}else{
		$bg = '';
		$cancel_button = '<button class="btn btn-danger btn-sm" onclick="vendor_estimate_cancel('.$row_estimate['estimate_id'] .')" data-toggle="tooltip" title="Cancel this Purchase"><i class="fa fa-ban"></i></button>';
		$update_btn = '<button class="btn btn-info btn-sm" onclick="vendor_estimate_update_modal('. $row_estimate['estimate_id'] .')" data-toggle="tooltip" title="Edit this Purchase"><i class="fa fa-pencil-square-o"></i></button>';
	}

	$newUrl = $row_estimate['invoice_proof_url'];
	if($newUrl!=""){
		$newUrl = preg_replace('/(\/+)/','/',$row_estimate['invoice_proof_url']); 
		$newUrl_arr = explode('uploads/', $newUrl);
		$newUrl1 = BASE_URL.'uploads/'.$newUrl_arr[1];	
	}	
	if($newUrl!=""){
		$evidence = '<a class="btn btn-info btn-sm" href="'. $newUrl1 .'" download data-toggle="tooltip" title="Download Invoice"><i class="fa fa-download"></i></a>';
	}else{
		$evidence = '';
	}					
	$temp_arr = array( "data" => array(
		$row_estimate['estimate_id'],
		$row_estimate['estimate_type'],
		$estimate_type_val,
		$row_estimate['vendor_type'],
		$vendor_type_val,
		$row_estimate['remark'],
		number_format($purchase_amount, 2),
		($cancel_amount=="") ? 0 : $cancel_amount,
		$row_estimate['net_total'],
		$emp_name,
		$update_btn.$evidence.$cancel_button
		), "bg" =>$bg);
	array_push($array_s,$temp_arr); 					
}
$footer_data = array("footer_data" => array(
	'total_footers' => 6,
	
	'foot0' => "Total : ",
	'col0' => 6,
	'class0' =>"text-right info",

	'foot1' => number_format($total_estimate_amt, 2),
	'col1' => 1,
	'class1' =>"text-right info",

	'foot2' => number_format($total_cancel_amt, 2),
	'col2' => 1,
	'class2' =>"text-left danger",

	'foot3' => number_format($total_purchase_amt, 2),
	'col3' => 1,
	'class3' =>"info",

	'foot4' => number_format($total_paid_amt, 2),
	'col4' => 1,
	'class4' =>"success",

	'foot5' => number_format($total_balance, 2),
	'col5' => 1,
	'class5' =>"warning"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
