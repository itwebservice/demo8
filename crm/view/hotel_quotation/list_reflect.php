<?php
include "../../model/model.php";
global $app_quot_format,$whatsapp_switch,$currency;
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$quotation_id = $_POST['quotation_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$query = "select * from hotel_quotation_master where financial_year_id='$financial_year_id' ";
if($from_date!='' && $to_date!=""){

	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and quotation_date between '$from_date' and '$to_date' "; 
}
if($quotation_id!=''){
	$query .= " and quotation_id='$quotation_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
	    $query .= " and branch_admin_id = '$branch_admin_id'";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	    $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and emp_id='$emp_id'";
}
$query .=" order by quotation_id desc ";

$count = 0;
$array_s = array();
	$temp_arr = array();
	$quotation_cost = 0;
	$sq_quotation = mysqlQuery($query);
	while($row_quotation = mysqli_fetch_assoc($sq_quotation)){

		$bg = ($row_quotation['clone'] == 1) ? 'warning': '';
		$sq_emp =  mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_quotation[emp_id]'"));
		$emp_name = ($row_quotation['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
		$quotation_date = $row_quotation['quotation_date'];
		$yr = explode("-", $quotation_date);
		$year =$yr[0];

		$quotation_id = $row_quotation['quotation_id'];
		if($app_quot_format == 2){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_2/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 3){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_3/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 4){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_4/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 5){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_5/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		else if($app_quot_format == 6){
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_6/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		else{
			$url1 = BASE_URL."model/app_settings/print_html/quotation_html/quotation_html_1/hotel_quotation_html.php?quotation_id=$quotation_id";
		}
		$whatsapp_show = "";
		if($whatsapp_switch == "on"){
			$whatsapp_show = '<button class="btn btn-info btn-sm" onclick="quotation_whatsapp('.$row_quotation['quotation_id'].')" title="What\'sApp Quotation to customer" data-toggle="tooltip"><i class="fa fa-whatsapp"></i></button>';
		}
		$enq_details = json_decode($row_quotation['enquiry_details'], true);
		$cost_details = json_decode($row_quotation['costing_details'], true);
		$cost_details['total_amount'] = ($cost_details['total_amount'] == "") ? 0 : $cost_details['total_amount'];
		
		$currency_amount1 = currency_conversion($currency,$row_quotation['currency_code'],$cost_details['total_amount']);
		if($row_quotation['currency_code'] !='0' && $currency != $row_quotation['currency_code']){
			$currency_amount = ' ('.$currency_amount1.')';
		}else{
			$currency_amount = '';
		}
		
		$temp_arr = array( "data" => array(
			(int)(++$count),
			get_quotation_id($row_quotation['quotation_id'],$year),
			get_date_user($row_quotation['quotation_date']),
			$enq_details['customer_name'],
			number_format($cost_details['total_amount'],2).$currency_amount,
			$emp_name,
			'<a data-toggle="tooltip" onclick="loadOtherPage(\''.$url1.'\')" class="btn btn-info btn-sm" title="Download Quotation PDF"><i class="fa fa-print"></i></a> <button class="btn btn-info btn-sm" onclick="send_mail(\''.trim($enq_details['email_id']).'\')" title="Send Email" data-toggle="tooltip"><i class="fa fa-envelope-o"></i></button><button class="btn btn-warning btn-sm" onclick="quotation_clone('.$row_quotation['quotation_id'].')" title="Clone Quotation" data-toggle="tooltip"><i class="fa fa-files-o"></i></button>'.$whatsapp_show.'<form  style="display:inline-block" action="update/index.php" id="frm_booking_'.$count.'" method="POST">
				<input  style="display:inline-block" type="hidden" id="quotation_id" name="quotation_id" value="'.$row_quotation['quotation_id'].'">
				<button data-toggle="tooltip"  style="display:inline-block" class="btn btn-info btn-sm" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>
			</form><form  style="display:inline-block" action="quotation_view.php" target="_blank" id="frm_booking_view_'.$count.'" method="GET">
				<input  style="display:inline-block" type="hidden" id="quotation_id" name="quotation_id" value="'.$row_quotation['quotation_id'].'">
				<button data-toggle="tooltip"  style="display:inline-block" class="btn btn-info btn-sm" title="View Details"><i class="fa fa-eye"></i></button>
			</form>',
		), "bg" =>$bg);
		array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>