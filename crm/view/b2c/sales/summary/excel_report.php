<?php
include "../../../../model/model.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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

$customer_id = $_GET['customer_id'];
$booking_id = $_GET['booking_id'];
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

if($booking_id!=""){
    $sql_booking_date = mysqli_fetch_assoc(mysqlQuery("select created_at from b2c_sale where booking_id = '$booking_id'")) ;
    $booking_date = $sql_booking_date['created_at'];
    $yr = explode("-", $booking_date);
    $year =$yr[0];
    $invoice_id = get_b2c_booking_id($booking_id,$year);
}else{
    $invoice_id = '';
}

if($from_date!="" && $to_date!=""){
	$date_str = $from_date.' to '.$to_date;
}
else{
	$date_str = "";
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'B2C Summary')
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

$query = "select * from b2c_sale where 1 ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
if($from_date!="" && $to_date!=""){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and created_at between '$from_date' and '$to_date'";
}
$query .= " order by booking_id desc";
$row_count = 7;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer_Name")
        ->setCellValue('E'.$row_count, "Contact")
        ->setCellValue('F'.$row_count, "EMAIL_ID")
        ->setCellValue('G'.$row_count, "Service")
        ->setCellValue('H'.$row_count, "Booking_Date")
        ->setCellValue('I'.$row_count, "Basic_Amount")        
        ->setCellValue('J'.$row_count, "Tax")
        ->setCellValue('K'.$row_count, "Coupon_amount")    
        ->setCellValue('L'.$row_count, "Credit card charges")
        ->setCellValue('M'.$row_count, "Sale")
        ->setCellValue('N'.$row_count, "Cancel")
        ->setCellValue('O'.$row_count, "Total")
        ->setCellValue('P'.$row_count, "Paid")
        ->setCellValue('Q'.$row_count, "Outstanding Balance")
        ->setCellValue('R'.$row_count, "Purchase")
        ->setCellValue('S'.$row_count, "Booked_By");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);      

$row_count++;
$count = 0;
$total_balance=0;
$total_refund=0;		
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;

$sq_exc = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_exc)){

	$bg = (($row_booking['status']=='Cancel')) ? "danger" : '';
	
	$date = $row_booking['created_at'];
	$yr = explode("-", $date);
	$year = $yr[0];
	$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	$contact_no = $sq_customer_info['country_code'].$encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);

	$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	$emp_name='Admin';

	$sq_paid_amount = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum,sum(credit_charges) as sumc from b2c_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];

	$costing_data = json_decode($row_booking['costing_data']);
	$enq_data = json_decode($row_booking['enq_data']);
	$total_cost = $costing_data[0]->total_cost;
	$net_total = $costing_data[0]->net_total;

	$total_tax = $costing_data[0]->total_tax;
	$taxes = explode(',',$total_tax);
	$tax_amount = 0;
	for($i=0; $i<sizeof($taxes);$i++){
		$single_tax = explode(':',$taxes[$i]);
		$tax_amount += floatval($single_tax[1]);
	}
	$grand_total = $costing_data[0]->grand_total;
	$coupon_amount = $costing_data[0]->coupon_amount;
	$coupon_amount = ($coupon_amount!='')?$coupon_amount:0;

	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum,sum(`credit_charges`) as sumc from b2c_payment_master where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$paid_amount = $sq_payment_info['sum'];
	$credit_card_charges = $sq_payment_info['sumc'];

	$cancel_amount = $row_booking['cancel_amount'];
	$total_cost1 = $net_total - $cancel_amount;
	if ($row_booking['status'] == 'Cancel') {
		if ($cancel_amount <= $paid_amount) {
			$balance_amount = 0;
		} else {
			$balance_amount =  $cancel_amount - $paid_amount;
		}
	} else {
		$cancel_amount = ($cancel_amount == '') ? '0' : $cancel_amount;
		$balance_amount = $net_total - $paid_amount;
	}
	
	$f_net_total += $net_total;
	$f_cancel_amount += $cancel_amount;
	$f_total_cost += $total_cost1;
	$f_paid_amount += $paid_amount;
	$f_balance_amount += $balance_amount;

    	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, get_b2c_booking_id($row_booking['booking_id'],$year))
            ->setCellValue('D'.$row_count, $customer_name)
            ->setCellValue('E'.$row_count, $contact_no)
            ->setCellValue('F'.$row_count, $email_id)
            ->setCellValue('G'.$row_count, $row_booking['service'])
            ->setCellValue('H'.$row_count, get_date_user($row_booking['created_at']))
            ->setCellValue('I'.$row_count, number_format($total_cost,2))
            ->setCellValue('J'.$row_count, number_format($tax_amount,2))
            ->setCellValue('K'.$row_count, number_format($coupon_amount,2))
            ->setCellValue('L'.$row_count, number_format($sq_paid_amount['sumc'],2))
            ->setCellValue('M'.$row_count, number_format($net_total,2))
            ->setCellValue('N'.$row_count, number_format($cancel_amount,2))
            ->setCellValue('O'.$row_count, number_format($total_cost1,2))
            ->setCellValue('P'.$row_count, number_format($paid_amount,2))
            ->setCellValue('Q'.$row_count, number_format($balance_amount,2))
            ->setCellValue('R'.$row_count, number_format($total_purchase,2))
            ->setCellValue('S'.$row_count, $emp_name);

        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, "")
        ->setCellValue('E'.$row_count, "")
        ->setCellValue('F'.$row_count, "")
        ->setCellValue('G'.$row_count, "")
        ->setCellValue('H'.$row_count, "")
        ->setCellValue('J'.$row_count, "")
        ->setCellValue('K'.$row_count, "")
        ->setCellValue('L'.$row_count, "")
        ->setCellValue('M'.$row_count, "")
        ->setCellValue('N'.$row_count, 'TOTAL CANCEL : '.number_format($f_cancel_amount,2))
        ->setCellValue('O'.$row_count, 'TOTAL SALE :'.number_format($f_total_cost,2))
        ->setCellValue('P'.$row_count, 'TOTAL PAID : '.number_format($f_paid_amount,2))
        ->setCellValue('Q'.$row_count, 'TOTAL BALANCE :'.number_format($f_balance_amount,2))
        ->setCellValue('R'.$row_count, "");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':R'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="B2CSummary('.date('d-m-Y H:i').').xls"');
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
