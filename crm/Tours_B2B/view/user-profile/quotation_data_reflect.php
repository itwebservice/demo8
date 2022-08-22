<?php
include_once("../../../model/model.php");
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$register_id = $_SESSION['register_id'];

$array_s = array();
$temp_arr = array();
$footer_data = array();

$query = "select * from b2b_quotations where 1 and register_id = '$register_id'";
if($from_date!='' && $to_date!=""){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and created_at between '$from_date' and '$to_date' "; 
}
$query .=" order by quotation_id desc ";

$count = 1;
$array_s = array();
$temp_arr = array();
$quotation_cost = 0;
$sq_quotation = mysqlQuery($query);
while($row_quotation = mysqli_fetch_assoc($sq_quotation)){

	$sq_customer =  mysqli_fetch_assoc(mysqlQuery("select company_name from b2b_registration where register_id = '$row_quotation[register_id]'"));

	$cart_list_arr1 = $row_quotation['cart_list_arr'];
	$cart_list_arr = ($cart_list_arr1 != '' && $cart_list_arr1 != 'null') ? $cart_list_arr1 : [];

	$pdf_data_array = json_decode($row_quotation['pdf_data_array']);
	$cust_name = $pdf_data_array[0]->cust_name;
	$email_id = $pdf_data_array[0]->email_id;
	
	$markup_in = $pdf_data_array[0]->markup_in;
	$markup_amount = $pdf_data_array[0]->markup_amount;
	$tax_in = $pdf_data_array[0]->tax_in;
	$tax_amount = $pdf_data_array[0]->tax_amount;
	$grand_total = $pdf_data_array[0]->grand_total;
	if($markup_in == 'Percentage'){
		$markup = $grand_total*($markup_amount/100);
	}
	else{
		$markup = $markup_amount;
	}
	$grand_total += $markup;
	if($tax_in == 'Percentage'){
		$tax_amt = ($grand_total*($tax_amount/100));
	}
	else{
		$tax_amt = $tax_amount;
	}
	$quotation_cost = $grand_total + $tax_amt;
	$quotation_no = base64_encode($row_quotation['quotation_id']);

	$pdf_data_array = json_encode($pdf_data_array);
	$currency = $row_quotation['currency'];
	$url1 = BASE_URL.'model/app_settings/print_html/quotation_html/quotation_html_2/b2b_quotation_html.php?pdf_data_array='.urlencode($pdf_data_array).'&cart_list_arr='.urlencode($cart_list_arr).'&quotation_currency='.$currency.'&flag_value='.'true'.'&created_at='.get_date_user($row_quotation['created_at']);
	$url2 = BASE_URL.'model/app_settings/print_html/quotation_html/quotation_html_2/b2b_quotation_portal.php?quotation_id='.$quotation_no;
	
	$sq_curr = mysqli_fetch_assoc(mysqlQuery("select currency_code from currency_name_master where id='$currency'"));
	$temp_arr = array(
		$count++,
		get_date_user($row_quotation['created_at']),
		$cust_name,
		$sq_curr['currency_code'].' '.number_format($quotation_cost,2),
		'<a style="color: white !important;" data-toggle="tooltip" onclick="loadOtherPage(\''.$url1.'\')" class="btn btn-info btn-sm" title="Download Quotation PDF"><i class="fa fa-print"></i></a>&nbsp;&nbsp;<button style="color: white !important;" data-toggle="tooltip" id="send-'.$row_quotation['quotation_id'].'" onclick="send_quotation(\''.$row_quotation['quotation_id'].'+'.$email_id.'+'.$url2.'\')" class="btn btn-info btn-sm" title="Mail & Whatsapp Quotation"><i class="fa fa-envelope-o"></i></button>',
	);
array_push($array_s,$temp_arr); 
}
$footer_data = array("footer_data" => array());
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>