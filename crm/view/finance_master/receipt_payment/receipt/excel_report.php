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
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$branch_status = $_GET['branch_status']; 
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$bank_id = $_GET['bank_id'];
$financial_year_id = $_SESSION['financial_year_id'];

if($bank_id!=""){
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from bank_master where bank_id='$bank_id'"));
    $name_str = $sq_cust['bank_name'].' '.$sq_cust['branch_name'] ;
}
else{
	$name_str = "";
}

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}

if($financial_year_id != ""){ 
    $query_year = mysqli_fetch_assoc(mysqlQuery("Select * from financial_year where financial_year_id='$financial_year_id'")); 
    $fin_year = $query_year['year_name_long'];   
}
else{
    $fin_year = "";
}

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Receipt/Payment')
            ->setCellValue('B3', 'Bank Name')
            ->setCellValue('C3', $name_str)
            ->setCellValue('B4', 'From-To Date')
            ->setCellValue('C4', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);   

$query = "select * from receipt_payment_master where 1 and payment_amount!='0'";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and payment_date between '$from_date' and '$to_date'";
}
if($bank_id!=""){
	$query .= " and bank_id='$bank_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
$query .= " order by id desc";
include "../../../../model/app_settings/branchwise_filteration.php";

$row_count = 6;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Receipt Type")
        ->setCellValue('D'.$row_count, "Date")
        ->setCellValue('E'.$row_count, "Amount")
        ->setCellValue('F'.$row_count, "Payment Mode")
        ->setCellValue('G'.$row_count, "Created by");
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 0;
$total_amount=0;
$sq_deposit = mysqlQuery($query);
while($row_deposit = mysqli_fetch_assoc($sq_deposit)){

    $sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from bank_master where bank_id='$row_deposit[bank_id]'"));
    $sq_emp = mysqli_fetch_assoc(mysqlQuery("select first_name,last_name from emp_master where emp_id='$row_deposit[emp_id]'"));

    $total_amount = $total_amount + $row_deposit['payment_amount'];
    if($row_deposit['url']!=""){
        $url = explode('uploads', $row_deposit['url']);
        $url = BASE_URL.'uploads'.$url[1];
    }
    else{
        $url = "";
    }

	$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, ++$count)
        ->setCellValue('C'.$row_count, $row_deposit['receipt_type'])
        ->setCellValue('D'.$row_count, get_date_user($row_deposit['payment_date']))
        ->setCellValue('E'.$row_count, number_format($row_deposit['payment_amount'],2))
        ->setCellValue('F'.$row_count, $row_deposit['payment_mode'])        
        ->setCellValue('G'.$row_count, ($sq_emp['first_name'] !='')?$sq_emp['first_name'].' '.$sq_emp['last_name']:'Admin');

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);    

		$row_count++;

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "")
        ->setCellValue('C'.$row_count, "")
        ->setCellValue('D'.$row_count, '')
        ->setCellValue('E'.$row_count, 'Total Amount : '.number_format($total_amount,2))
        ->setCellValue('F'.$row_count, '')
        ->setCellValue('G'.$row_count, '');

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':G'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="Receipt/Payment Entries('.date('d-m-Y H:i').').xls"');
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
