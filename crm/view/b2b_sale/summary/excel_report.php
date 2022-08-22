<?php
include "../../../model/model.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

//This function generates the background color
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

//This array sets the font atrributes
$header_style_Array = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 12,
        'name'  => 'Verdana'
    ));
$table_header_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 11,
        'name'  => 'Verdana'
    ));
$content_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 9,
        'name'  => 'Verdana'
    ));

//This is border array
$borderArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


//////////////////////////****************Content start**************////////////////////////////////
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];

$customer_id = $_GET['customer_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];
$booker_id = $_GET['booker_id'];
$branch_id = $_GET['branch_id'];

$branch_status = $_GET['branch_status'];
$customer_id = $_GET['customer_id'];
$b2b_booking_master = $_GET['b2b_booking_master'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if($customer_id!=""){
	$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
	if($sq_customer_info['type'] == 'Corporate'||$sq_customer_info['type']=='B2B'){
		$cust_name = $sq_customer_info['company_name'];
	}else{
		$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	}
}
else{
	$cust_name = "";
}

if($b2b_booking_master!=""){
    
    $sq_booking = mysqli_fetch_assoc(mysqlQuery("select created_at from b2b_booking_master where booking_id='$b2b_booking_master'"));
    $yr = explode("-", get_datetime_db($sq_booking['created_at']));
    $invoice_id = get_b2b_booking_id($b2b_booking_master,$yr[0]);
}
else{
    $invoice_id = '';
}
if($from_date!="" && $to_date!=""){
	$date_str = $from_date.' to '.$to_date;
}
else{
	$date_str = "";
}
if($company_name == 'undefined') { $company_name = ''; }

if($booker_id != '')
{
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$booker_id'"));
    if($sq_emp['first_name'] == '') { $emp_name='Admin';}
    else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }
}

if($branch_id != '') { 
    $sq_branch = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id='$branch_id'"));
    $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'B2B Booking Summary')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
            ->setCellValue('B5', 'From-To Date')
            ->setCellValue('C5', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray); 


$query = "select * from b2b_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id' ";
}
if($b2b_booking_master!=""){
	$query .=" and booking_id='$b2b_booking_master' ";
}
if($from_date!="" && $to_date !=""){
	$from_date = get_datetime_db($from_date);
	$to_date = get_datetime_db($to_date);
	$query .=" and (created_at>='$from_date' and created_at<='$to_date') ";
}
$query .= " order by booking_id desc";
global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];
$count = 0;
$total_balance=0;
$total_refund=0;	
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;
$net_total = 0;
$row_count = 11;

       $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, "Sr. No")
                ->setCellValue('C'.$row_count, "Booking ID")
                ->setCellValue('D'.$row_count, "Agent Name")
                ->setCellValue('E'.$row_count, "Contact")
                ->setCellValue('F'.$row_count, "EMAIL ID")
                ->setCellValue('G'.$row_count, "Booking Date")
                ->setCellValue('H'.$row_count, "Sale")
                ->setCellValue('I'.$row_count, "Cancel")
                ->setCellValue('J'.$row_count, "Total")
                ->setCellValue('K'.$row_count, "Paid")
                ->setCellValue('L'.$row_count, "Outstanding Balance")
                ->setCellValue('M'.$row_count, "Purchase")
                ->setCellValue('N'.$row_count, "Purchased From")
                ->setCellValue('O'.$row_count, "Booked By");


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($borderArray);    

        $row_count++;

        $count = 0;
        

        $sq_customer = mysqlQuery($query);
        while($row_customer = mysqli_fetch_assoc($sq_customer)){

            $hotel_total = 0;
            $transfer_total = 0;
            $activity_total = 0;
            $tours_total = 0;
            $ferry_total = 0;
            $servie_total = 0;
            $yr = explode("-", get_datetime_db($row_customer['created_at']));
            $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_customer[customer_id]'"));
            $cart_checkout_data = json_decode($row_customer['cart_checkout_data']);

            $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_customer[emp_id]'"));
            if($sq_emp['first_name'] == '') { $emp_name='Admin';}
            else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

            $sq_branch = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id='$sq_emp[branch_id]'"));
            $branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
            
            for($i=0;$i<sizeof($cart_checkout_data);$i++){
                if($cart_checkout_data[$i]->service->name == 'Hotel'){
                    $hotel_flag = 1;
                    $tax_arr = explode(',',$cart_checkout_data[$i]->service->hotel_arr->tax);
                    $tax_amount = 0;
                    for($j=0;$j<sizeof($cart_checkout_data[$i]->service->item_arr);$j++){
                        $room_types = explode('-',$cart_checkout_data[$i]->service->item_arr[$j]);
                        $room_cost = $room_types[2];
                        $h_currency_id = $room_types[3];
                        
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                            if($tax_arr1[$t]!=''){
                                $tax_arr2 = explode(':',$tax_arr1[$t]);
                                if($tax_arr2[2] == "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                }else{
                                    $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                }
                            }
                        }
                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                        $hotel_total += $total_amount;
                    }
                }
                if($cart_checkout_data[$i]->service->name == 'Transfer'){

                    $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                    for($j=0;$j<count(array($services));$j++){
                        $tax_amount = 0;
                        $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                        $transfer_cost = explode('-',$services->service_arr[$j]->transfer_cost);
                        $room_cost = $transfer_cost[0];
                        $h_currency_id = $transfer_cost[1];
                        
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                            if($tax_arr1[$t]!=''){
                                $tax_arr2 = explode(':',$tax_arr1[$t]);
                                if($tax_arr2[2] == "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                }else{
                                    $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                }
                            }
                        }
                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                        $transfer_total += $total_amount;
                    }
                }
                if($cart_checkout_data[$i]->service->name == 'Activity'){
                    $activity_flag = 1;
                    $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                    for($j=0;$j<count(array($services));$j++){
                    
                        $tax_amount = 0;
                        $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                        $transfer_cost = explode('-',$services->service_arr[$j]->transfer_type);
                        $room_cost = $transfer_cost[1];
                        $h_currency_id = $transfer_cost[2];
                        
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                            if($tax_arr1[$t]!=''){
                                $tax_arr2 = explode(':',$tax_arr1[$t]);
                                if($tax_arr2[2] === "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                }else{
                                    $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                }
                            }
                        }
                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                        $activity_total += $total_amount;
                    }
                }
                if($cart_checkout_data[$i]->service->name == 'Combo Tours'){
                    $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                    for($j=0;$j<count(array($services));$j++){
                    
                        $tax_amount = 0;
                        $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                        $package_item = explode('-',$services->service_arr[$j]->package_type);
                        $room_cost = $package_item[1];
                        $h_currency_id = $package_item[2];

                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                            if($tax_arr1[$t]!=''){
                                $tax_arr2 = explode(':',$tax_arr1[$t]);
                                if($tax_arr2[2] == "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                }else{
                                    $tax_amount = $tax_amount + ($room_cost +$tax_arr2[1]);
                                }
                            }
                        }
                        $total_amount = $room_cost + $tax_amount;

                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                        $tours_total += $total_amount;
                    }
                }
                if($cart_checkout_data[$i]->service->name == 'Ferry'){
                    $services = ($cart_checkout_data[$i]->service!='') ? $cart_checkout_data[$i]->service : [];
                    for($j=0;$j<count(array($services));$j++){
                    
                        $tax_amount = 0;
                        $tax_arr = explode(',',$services->service_arr[$j]->taxation);
                        $package_item = explode('-',$services->service_arr[$j]->total_cost);
                        $room_cost = $package_item[0];
                        $h_currency_id = $package_item[1];
                        
                        $tax_arr1 = explode('+',$tax_arr[0]);
                        for($t=0;$t<sizeof($tax_arr1);$t++){
                            if($tax_arr1[$t]!=''){
                                $tax_arr2 = explode(':',$tax_arr1[$t]);
                                if($tax_arr2[2] == "Percentage"){
                                    $tax_amount = $tax_amount + ($room_cost * $tax_arr2[1] / 100);
                                }else{
                                    $tax_amount = $tax_amount + ($room_cost + $tax_arr2[1]);
                                }
                            }
                        }
                        $total_amount = $room_cost + $tax_amount;
        
                        //Convert into default currency
                        $sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$h_currency_id'"));
                        $from_currency_rate = $sq_from['currency_rate'];
                        $total_amount = ($from_currency_rate / $to_currency_rate * $total_amount);
                    
                        $ferry_total += $total_amount;
                    }
                }
            }

            $servie_total = $servie_total + $hotel_total + $transfer_total + $activity_total + $tours_total + $ferry_total;
            
            if($row_customer['coupon_code'] != ''){
                $sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_customer[coupon_code]'"));
                $sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_customer[coupon_code]'"));
                if($sq_hotel_count > 0){
                    $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$row_customer[coupon_code]'"));
                }else if($sq_exc_count > 0){
                    $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$row_customer[coupon_code]'"));
                }else{
                    $sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$row_customer[coupon_code]'"));
                }

                if($sq_coupon['offer']=="Flat"){
                    $servie_total = $servie_total - $sq_coupon['offer_amount'];
                }else{
                    $servie_total = $servie_total - ($servie_total*$sq_coupon['offer_amount']/100);
                }
            }
            
            $net_total += $servie_total;
            
            $sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum from b2b_payment_master where booking_id='$row_customer[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
            $payment_amount = $sq_payment_info['sum'];
            $paid_amount +=$sq_payment_info['sum'];

            //Invoice
            $invoice_no = get_b2b_booking_id($row_customer['booking_id'],$yr[0]);
            $booking_id = $row_customer['booking_id'];
            $invoice_date = date('d-m-Y',strtotime($row_customer['created_at']));
            $customer_id = $row_customer['customer_id'];
            $service_name = "B2B Invoice";
            $sq_sac = mysqli_fetch_assoc(mysqlQuery("select * from sac_master where service_name='Package Tour'"));
            $sac_code = $sq_sac['hsn_sac_code'];

            if($app_invoice_format == 4)
            $url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_tax_invoice.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";
            else
            $url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/b2b_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&booking_id=$booking_id&sac_code=$sac_code";

            //Receipt
            $payment_id_name = "Receipt ID";
            $booking_id = $row_customer['booking_id'];
            $customer_id = $row_customer['customer_id'];
            $receipt_type = "B2B Sale Receipt";

            /////// Purchase ////////
            $total_purchase = 0;
            $purchase_amt = 0;
            $i=0;
            $p_due_date = '';
            $sq_purchase_count = mysqli_num_rows(mysqlQuery("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));
            if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
            $sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'");
            while($row_purchase = mysqli_fetch_assoc($sq_purchase)){			
                $purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
                $total_purchase = $total_purchase + $purchase_amt;
            }
            $sq_purchase1 = mysqli_fetch_assoc(mysqlQuery("select * from vendor_estimate where estimate_type='B2B Booking' and estimate_type_id='$row_customer[booking_id]'"));		
            $vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
            if($vendor_name == ''){ $vendor_name1 = 'NA';  }
            else{ $vendor_name1 = $vendor_name; }
            
            $cancel_amount = $row_customer['cancel_amount'];
            $cancel_total += $cancel_amount;
            if($row_customer['status'] == 'Cancel'){
                if($payment_amount > 0){
                    if($cancel_amount >0){
                        if($payment_amount > $cancel_amount){
                            $balance_amount = 0;
                        }else{
                            $balance_amount = $cancel_amount - $payment_amount;
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
                $balance_amount = $servie_total - $payment_amount;
            }
            $balance_total += $balance_amount;

    	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, $invoice_no)
            ->setCellValue('D'.$row_count, $sq_cust['company_name'])
            ->setCellValue('E'.$row_count, $row_customer['contact_no'])
            ->setCellValue('F'.$row_count, $row_customer['email_id'])
            ->setCellValue('G'.$row_count, get_date_user($row_customer['created_at']))
            ->setCellValue('H'.$row_count, number_format($servie_total,2))
            ->setCellValue('I'.$row_count, number_format($row_customer['cancel_amount'],2))
            ->setCellValue('J'.$row_count, number_format($servie_total-$row_customer['cancel_amount'],2))
            ->setCellValue('K'.$row_count, number_format($payment_amount,2))
            ->setCellValue('L'.$row_count, number_format($balance_amount, 2))
            ->setCellValue('M'.$row_count, number_format($total_purchase,2))
            ->setCellValue('N'.$row_count, $vendor_name1)
            ->setCellValue('O'.$row_count, $emp_name);

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($content_style_Array);
    	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':O'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, "")
        ->setCellValue('G'.$row_count, "")
        ->setCellValue('H'.$row_count, "")
        ->setCellValue('I'.$row_count, 'TOTAL CANCEL : '.number_format($cancel_total,2))
        ->setCellValue('J'.$row_count, 'TOTAL SALE :'.number_format($net_total,2))
        ->setCellValue('K'.$row_count, 'TOTAL PAID : '.number_format($paid_amount,2))
        ->setCellValue('L'.$row_count, 'TOTAL BALANCE :'.number_format($balance_total,2))
        ->setCellValue('M'.$row_count, '')
        ->setCellValue('N'.$row_count, '')
        ->setCellValue('O'.$row_count, '')
        ->setCellValue('P'.$row_count, '')
        ->setCellValue('Q'.$row_count, '');

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Q'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':Q'.$row_count)->applyFromArray($borderArray);

}
	

//////////////////////////****************Content End**************////////////////////////////////
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="B2BBookingSummary('.date('d-m-Y H:i').').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
