<?php
include "../../../../../../model/model.php";
include_once('../gst_sale/sale_generic_functions.php');
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$taxation_id='';
$branch_status = $_GET['branch_status'];

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('B2', 'Report Name')
          ->setCellValue('C2', 'TCS On Sale')
          ->setCellValue('B3', 'From-To-Date')
          ->setCellValue('C3', $date_str);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$row_count = 7;      

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr.No")
        ->setCellValue('C'.$row_count, "Service Name")
        ->setCellValue('D'.$row_count, "SAC/HSN Code")
        ->setCellValue('E'.$row_count, "Customer Name")
        ->setCellValue('F'.$row_count, "TAX No")
        ->setCellValue('G'.$row_count, "Account State")
        ->setCellValue('H'.$row_count, "Booking ID")
        ->setCellValue('I'.$row_count, "Booking Date")
        ->setCellValue('J'.$row_count, "Type_Of_Supplies")
        ->setCellValue('K'.$row_count, "Place of Supply")
        ->setCellValue('L'.$row_count, "Net Amount")
        ->setCellValue('M'.$row_count, "TCS(%)")
        ->setCellValue('N'.$row_count, "TCS Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);    

$row_count++;
$count = 1;
$tax_total = 0;
$markup_tax_total = 0;
$sq_setting = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id='1'"));
$sq_supply = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_setting[state_id]'"));

//GIT Booking
$query = "select * from tourwise_traveler_details where 1 and tcs_tax!='0' ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and DATE(form_date) between '$from_date' and '$to_date' ";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
  //Total count
	$sq_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as booking_count from travelers_details where traveler_group_id ='$row_query[id]'"));
	//Group cancel or not
	$sq_group = mysqli_fetch_assoc(mysqlQuery("select status from tour_groups where group_id ='$row_query[tour_group_id]'"));

	//Cancelled count
	$sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as cancel_count from travelers_details where traveler_group_id ='$row_query[id]' and status ='Cancel'"));
	$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
	if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
		$cust_name = $sq_cust['company_name'];
	}else{
		$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	}

	if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'] && $row_query['tour_group_status']!="Cancel")
	{
		$sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
		$hsn_code = get_service_info('Group Tour');

		$tax_total += $row_query['tcs_tax'];

		$yr = explode("-",$row_query['form_date']);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, $count++)
        ->setCellValue('C'.$row_count, "Group Booking")
        ->setCellValue('D'.$row_count, $hsn_code)
        ->setCellValue('E'.$row_count, $cust_name)
        ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
        ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
        ->setCellValue('H'.$row_count, get_group_booking_id($row_query['id'],$yr[0]))
        ->setCellValue('I'.$row_count, get_date_user($row_query['form_date']))
        ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
        ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
        ->setCellValue('L'.$row_count, $row_query['net_total'])
        ->setCellValue('M'.$row_count, $row_query['tcs_per'].' %')
        ->setCellValue('N'.$row_count, number_format($row_query['tcs_tax'],2));


    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':M'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);    
    $row_count++;
	}
}
//FIT Booking
$query = "select * from package_tour_booking_master where 1 and tcs_tax!='0' ";
if($from_date !='' && $to_date != ''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .= " and booking_date between '$from_date' and '$to_date' ";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
	
  //Total count
  $sq_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as booking_count from package_travelers_details where booking_id ='$row_query[booking_id]'"));
  //Cancelled count
  $sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(traveler_id) as cancel_count from package_travelers_details where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

  $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
  if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
    $cust_name = $sq_cust['company_name'];
  }else{
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  }

  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
      $yr = explode("-",$row_query['booking_date']);
      $hsn_code = get_service_info('Package Tour');  	
    
    $tax_total += $row_query['tcs_tax'];

    $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('B'.$row_count, $count++)
      ->setCellValue('C'.$row_count, "Package Booking")
      ->setCellValue('D'.$row_count, $hsn_code)
      ->setCellValue('E'.$row_count, $cust_name)
      ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
      ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
      ->setCellValue('H'.$row_count, get_package_booking_id($row_query['booking_id'],$yr[0]))
      ->setCellValue('I'.$row_count, get_date_user($row_query['booking_date']))
      ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
      ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
      ->setCellValue('L'.$row_count, $row_query['net_total'])
      ->setCellValue('M'.$row_count, $row_query['tcs_per'].' %')
      ->setCellValue('N'.$row_count, number_format($row_query['tcs_tax'],2));

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);   
    $row_count++;
  }
}
//Hotel Booking
$query = "select * from hotel_booking_master where 1 and tcs_tax!='0' ";
if($from_date !='' && $to_date != ''){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);
  $query .= " and created_at between '$from_date' and '$to_date' ";
}
$sq_query = mysqlQuery($query);
while($row_query = mysqli_fetch_assoc($sq_query))
{
  //Total count
  $sq_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as booking_count from hotel_booking_entries where booking_id ='$row_query[booking_id]'"));

  //Cancelled count
  $sq_cancel_count = mysqli_fetch_assoc(mysqlQuery("select count(entry_id) as cancel_count from hotel_booking_entries where booking_id ='$row_query[booking_id]' and status ='Cancel'"));

  if($sq_count['booking_count'] != $sq_cancel_count['cancel_count'])
  {
      $sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_query[customer_id]'"));
      if($sq_cust['type'] == 'Corporate'||$sq_cust['type'] == 'B2B'){
        $cust_name = $sq_cust['company_name'];
      }else{
        $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
      }
      $hsn_code = get_service_info('Hotel / Accommodation');
      $sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_cust[state_id]'"));
      
      $tax_total += $row_query['tcs_tax'];
      $yr = explode("-",$row_query['created_at']);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, $count++)
            ->setCellValue('C'.$row_count, "Hotel Booking")
            ->setCellValue('D'.$row_count, $hsn_code)
            ->setCellValue('E'.$row_count, $cust_name)
            ->setCellValue('F'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'NA' : $sq_cust['service_tax_no'])
            ->setCellValue('G'.$row_count, ($sq_supply['state_name'] == '') ? 'NA' : $sq_supply['state_name'])
            ->setCellValue('H'.$row_count, get_hotel_booking_id($row_query['booking_id'],$yr[0]))
            ->setCellValue('I'.$row_count, get_date_user($row_query['created_at']))
            ->setCellValue('J'.$row_count, ($sq_cust['service_tax_no'] == '') ? 'Unregistered' : 'Registered')
            ->setCellValue('K'.$row_count, ($sq_state['state_name'] == '') ? 'NA' : $sq_state['state_name'])
            ->setCellValue('L'.$row_count, $row_query['total_fee'])
            ->setCellValue('M'.$row_count, $row_query['tcs_per'].' %')
            ->setCellValue('N'.$row_count, number_format($row_query['tcs_tax'],2));


        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);

        $row_count++;  
    }
}

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count,'' )
        ->setCellValue('C'.$row_count, '')
        ->setCellValue('D'.$row_count, '')
        ->setCellValue('E'.$row_count,'' )
        ->setCellValue('F'.$row_count, '')
        ->setCellValue('G'.$row_count,'' )
        ->setCellValue('H'.$row_count,'' )
        ->setCellValue('I'.$row_count,'' )
        ->setCellValue('J'.$row_count,'' )
        ->setCellValue('K'.$row_count,'' )
        ->setCellValue('L'.$row_count,' ')
        ->setCellValue('M'.$row_count,'Total TAX :' )
        ->setCellValue('N'.$row_count,number_format($tax_total,2));

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':N'.$row_count)->applyFromArray($borderArray);

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
header('Content-Disposition: attachment;filename="TCS On Sale Report('.date('d-m-Y H:i').').xls"');
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
