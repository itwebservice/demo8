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
$customer_id = $_GET['customer_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

if($customer_id != '') {
    $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
}

if($from_date!="" && $to_date !=""){
	$from_date = get_date_user($from_date);
    $to_date = get_date_user($to_date);
    $date_str  = $from_date.' To '.$to_date;
}
// Add some data

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'B2C Sale Report')
            ->setCellValue('B3', 'Customer Name')
            ->setCellValue('C3', $sq_cust['first_name'])
            ->setCellValue('B4', 'From-To Date')
            ->setCellValue('C4', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);

global $currency;
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$query = "select * from b2c_sale where 1 ";
if($from_date!='' && $to_date!=""){

	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));

	$query .= " and DATE(created_at) between '$from_date' and '$to_date' "; 
}
if($customer_id!=''){
	$query .= " and customer_id='$customer_id'";
}
$query .=" order by booking_id desc ";
$sq_customer = mysqlQuery($query);

$count = 0;
$net_total = 0;
$row_count = 8;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Service")
        ->setCellValue('E'.$row_count, "Customer name")
        ->setCellValue('F'.$row_count, "Booking date")
        ->setCellValue('G'.$row_count, "Total Amount")
        ->setCellValue('H'.$row_count, "Cancel Amount")
        ->setCellValue('I'.$row_count, "Net Amount")
        ->setCellValue('J'.$row_count, "Paid Amount")
        ->setCellValue('K'.$row_count, "Balance Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 0;
$quotation_cost = 0;
$row_sale1 = mysqlQuery($query);
$array_s = array();
$temp_arr = array();
$f_net_total = 0;
$f_cancel_amount = 0;
$f_total_cost = 0;
$f_paid_amount = 0;
$f_balance_amount = 0;
while($row_sale = mysqli_fetch_assoc($row_sale1)){
	
    $entry_id = $row_sale['entry_id'];
    $customer_id = $row_sale['customer_id'];
	$service_name = ($row_sale['service'] == 'Holiday') ? "Package Invoice" : "Group Invoice";
    $booking_date = get_date_user($row_sale['created_at']);
	$yr = explode("-", $row_sale['created_at']);
	$year = $yr[0];
	$booking_id = get_b2c_booking_id($row_sale['booking_id'],$year);

	$costing_data = json_decode($row_sale['costing_data']);
	$enq_data = json_decode($row_sale['enq_data']);
	$net_total = $costing_data[0]->net_total;

	$sq_payment_info = mysqli_fetch_assoc(mysqlQuery("SELECT sum(payment_amount) as sum,sum(`credit_charges`) as sumc from b2c_payment_master where booking_id='$row_sale[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$paid_amount = $sq_payment_info['sum'];
	$credit_card_charges = $sq_payment_info['sumc'];

	$cancel_amount = $row_sale['cancel_amount'];
	$total_cost1 = $net_total - $cancel_amount;
    
	if ($row_sale['status'] == 'Cancel') {
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
        ->setCellValue('C'.$row_count, $booking_id)
        ->setCellValue('D'.$row_count, $row_sale['service'])
        ->setCellValue('E'.$row_count, $row_sale['name'])
        ->setCellValue('F'.$row_count, get_date_user($row_sale['created_at']))
        ->setCellValue('G'.$row_count, number_format($net_total,2))
        ->setCellValue('H'.$row_count, number_format($cancel_amount,2))
        ->setCellValue('I'.$row_count, number_format($total_cost1,2))
        ->setCellValue('J'.$row_count, number_format($paid_amount,2))
        ->setCellValue('K'.$row_count, number_format($balance_amount,2));

	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);  

	$row_count++;
}
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('B'.$row_count, '')
->setCellValue('C'.$row_count, '')
->setCellValue('D'.$row_count, '')
->setCellValue('E'.$row_count, '')
->setCellValue('F'.$row_count, 'Total : ')
->setCellValue('G'.$row_count, number_format($f_net_total,2))
->setCellValue('H'.$row_count, number_format($f_cancel_amount,2))
->setCellValue('I'.$row_count, number_format($f_total_cost,2))
->setCellValue('J'.$row_count, number_format($f_paid_amount,2))
->setCellValue('K'.$row_count, number_format($f_balance_amount,2));

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray); 

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
header('Content-Disposition: attachment;filename="B2C Sale Report('.date('d-m-Y H:i').').xls"');
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