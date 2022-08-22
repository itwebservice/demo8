<?php
include "../../model/model.php";
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_GET['branch_status'];
$tour_id = $_GET['tour_id'];
$group_id = $_GET['group_id'];
$customer_id = $_GET['customer_id'];
$booking_id = $_GET['booking_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];

if($tour_id!=""){
  $sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$tour_id'"));
  $tour_str = $sq_tour['tour_name'];
}
else{
  $tour_str = "";
}

if($group_id!=""){
  $sq_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where tour_id='$tour_id'"));
  $group_str = get_date_user($sq_group['from_date']).' to '.get_date_user($sq_group['to_date']);
}
else{
  $group_str = "";
}

if($customer_id!=""){
  $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = ($sq_customer_info['type'] == 'Corporate' || $sq_customer_info['type'] == 'B2B') ? $sq_customer_info['company_name'] : $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
}
else{
  $cust_name = "";
}


if($company_name == 'undefined') { $company_name = ''; }

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}
$sq_group_tour = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where financial_year_id='$financial_year_id'"));
$date = $sq_group_tour['form_date'];
$yr = explode("-", $date);
$year =$yr[0];
// Add some data
$bookingid_show = ($booking_id != '') ? get_group_booking_id($booking_id,$year) : '';
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Group Booking')
            ->setCellValue('B3', 'Tour Name')
            ->setCellValue('C3', $tour_str)
            ->setCellValue('B4', 'Tour Date')
            ->setCellValue('C4', $group_str)
            ->setCellValue('B5', 'Customer Name')
            ->setCellValue('C5', $cust_name)
            ->setCellValue('B6', 'Booking ID')
            ->setCellValue('C6', $bookingid_show)
            ->setCellValue('B7', 'From-To-Date')
            ->setCellValue('C7', $date_str)
            ->setCellValue('B8', 'Customer Type')
            ->setCellValue('C8', $cust_type)
            ->setCellValue('B9', 'Company Name')
            ->setCellValue('C9', $company_name);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);   

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);   

$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($borderArray);  

$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B8:C8')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B9:C9')->applyFromArray($borderArray);      

$query = "select * from tourwise_traveler_details where financial_year_id='$financial_year_id'";
if($tour_id!=""){
  $query .=" and tour_id='$tour_id'";
}
if($group_id!=""){
  $query .=" and tour_group_id='$group_id'";
}
if($customer_id!=""){
  $query .=" and customer_id='$customer_id'";
}
if($booking_id!=""){
  $query .=" and id='$booking_id'";
}
if($from_date!="" && $to_date!=""){
  $from_date = get_date_db($from_date);
  $to_date = get_date_db($to_date);

  $query .= " and date(form_date) between '$from_date' and '$to_date'";
}
if($company_name != ""){
  $query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($cust_type != ""){
  $query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
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
$query .= ' order by id desc';

$count = 0;
$row_count = 11;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Invoice No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('E'.$row_count, "Tour")
        ->setCellValue('F'.$row_count, "Tour Date")
        ->setCellValue('G'.$row_count, "Total PAX")
        ->setCellValue('H'.$row_count, "Train Amount")
        ->setCellValue('I'.$row_count, "Flight Amount")
        ->setCellValue('J'.$row_count, "Cruise Amount")
        ->setCellValue('K'.$row_count, "Basic Amount") 
        ->setCellValue('L'.$row_count, "Tax Amount")
        ->setCellValue('M'.$row_count, "TCS")
        ->setCellValue('N'.$row_count, "Cancel Amount")
        ->setCellValue('O'.$row_count, "Total Amount")
        ->setCellValue('P'.$row_count, "Paid Amount")
        ->setCellValue('Q'.$row_count, "Balance Amount")
        ->setCellValue('R'.$row_count, "Due Date")
        ->setCellValue('S'.$row_count, "Created By");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    

$row_count++;

  $sq_booking = mysqlQuery($query);
  while($row_booking = mysqli_fetch_assoc($sq_booking)){

			$sq_emp =  mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id = '$row_booking[emp_id]'"));
      $emp_name = ($row_booking['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
      
      $sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$row_booking[tour_id]'"));
      $sq_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$row_booking[tour_group_id]'"));
      $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
      if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
        $customer_name = $sq_customer['company_name'];
      }else{
        $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
      }
      $date = $row_booking['form_date'];
      $yr = explode("-", $date);
      $year =$yr[0];
      $invoice_id = ($booking_id!="") ? get_group_booking_id($booking_id,$year): "";
      $tour = $sq_tour['tour_name'];
      $group = get_date_user($sq_group['from_date']).' to '.get_date_user($sq_group['to_date']);
      $sq_total_members = mysqli_num_rows(mysqlQuery("select * from travelers_details where traveler_group_id='$row_booking[id]'"));

      $visa_total_amount= ($row_booking['visa_total_amount']!="") ? $row_booking['visa_total_amount']: 0.00;
      $insuarance_total_amount= ($row_booking['insuarance_total_amount']!="") ? $row_booking['insuarance_total_amount']: 0.00;

      $basic_amount = $row_booking['basic_amount'];
      $sq_paid = mysqli_fetch_assoc(mysqlQuery("select sum(amount) as paid_amount,sum(`credit_charges`) as sumc from payment_master where tourwise_traveler_id='$row_booking[id]' and clearance_status !='Cancelled' and clearance_status !='Pending'"));
      $total_tour_amount = $row_booking['net_total'] + $sq_paid['sumc'];
      
    $pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
    $cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));
    
    $paid_amount = $sq_paid['paid_amount'] + $sq_paid['sumc'];
    $sq_est_count = mysqli_num_rows(mysqlQuery("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
    if($sq_est_count!='0'){
      $sq_tour_refund = mysqli_fetch_assoc(mysqlQuery("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
      $cancel_amount = $sq_tour_refund['cancel_amount'];
    }
    else{
      $sq_tour_refund = mysqli_fetch_assoc(mysqlQuery("select * from refund_traveler_estimate where tourwise_traveler_id='$row_booking[id]'"));
      $cancel_amount = $sq_tour_refund['cancel_amount'];
    }
    $cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
    if($row_booking['tour_group_status'] == 'Cancel'){
      if($cancel_amount > $paid_amount){
        $balance_amount = $cancel_amount - $paid_amount;
      }
      else{
        $balance_amount = 0;
      }
    }else{
      if($pass_count == $cancelpass_count){
        if($cancel_amount > $paid_amount){
          $balance_amount = $cancel_amount - $paid_amount;
        }
        else{
          $balance_amount = 0;
        }
      }
      else{
        $balance_amount = $total_tour_amount - $paid_amount;
      }
    }
    // currency conversion
    $currency_amount1 = currency_conversion($currency,$row_booking['currency_code'],floatval($total_tour_amount)-floatval($cancel_amount));
    if($row_booking['currency_code'] !='0' && $currency != $row_booking['currency_code']){
      $currency_amount = ' ('.$currency_amount1.')';
    }else{
      $currency_amount = '';
    }
    
	  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('B'.$row_count, $row_booking['invoice_pr_id'])
      ->setCellValue('C'.$row_count, get_group_booking_id($row_booking['id'],$year))
      ->setCellValue('D'.$row_count, $customer_name)
      ->setCellValue('E'.$row_count, $tour)
      ->setCellValue('F'.$row_count, $group)
      ->setCellValue('G'.$row_count, $sq_total_members)
      ->setCellValue('H'.$row_count, number_format($row_booking['total_train_expense'],2))
      ->setCellValue('I'.$row_count, number_format($row_booking['total_plane_expense'],2))
      ->setCellValue('J'.$row_count, number_format($row_booking['total_cruise_expense'],2))
      ->setCellValue('K'.$row_count, number_format($basic_amount,2))
      ->setCellValue('L'.$row_count, $row_booking['service_tax'])
      ->setCellValue('M'.$row_count, $row_booking['tcs_tax'])
      ->setCellValue('N'.$row_count, number_format($cancel_amount, 2))
      ->setCellValue('O'.$row_count, number_format(floatval($total_tour_amount)-floatval($cancel_amount), 2).$currency_amount)
      ->setCellValue('P'.$row_count, number_format($sq_paid['paid_amount']+$sq_paid['sumc'], 2))
      ->setCellValue('Q'.$row_count, number_format($balance_amount, 2))
      ->setCellValue('R'.$row_count, ($row_booking['balance_due_date']=='1970-01-01') ? 'NA' : date('d-m-Y',strtotime($row_booking['balance_due_date'])))
      ->setCellValue('S'.$row_count,$emp_name);

  $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);    

  $total_sale += floatval($total_tour_amount)-floatval($cancel_amount);
  $total_cancel += $cancel_amount;
  $total_paid += $sq_paid['paid_amount']+$sq_paid['sumc'];
  $total_balance += $balance_amount;

	$row_count++;
}
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B'.$row_count, '')
    ->setCellValue('C'.$row_count, '')
    ->setCellValue('D'.$row_count, '')
    ->setCellValue('E'.$row_count, '')
    ->setCellValue('F'.$row_count, '')
    ->setCellValue('G'.$row_count, '')
    ->setCellValue('H'.$row_count, '')
    ->setCellValue('I'.$row_count, '')
    ->setCellValue('J'.$row_count, '')
    ->setCellValue('K'.$row_count, '')
    ->setCellValue('L'.$row_count, '')
    ->setCellValue('M'.$row_count, 'Total')
    ->setCellValue('N'.$row_count, number_format($total_cancel,2))
    ->setCellValue('O'.$row_count, number_format($total_sale,2))
    ->setCellValue('P'.$row_count, number_format($total_paid,2))
    ->setCellValue('Q'.$row_count, number_format($total_balance, 2))
    ->setCellValue('R'.$row_count, '')
    ->setCellValue('S'.$row_count, '');

    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':S'.$row_count)->applyFromArray($borderArray);  

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
header('Content-Disposition: attachment;filename="Group Booking('.date('d-m-Y H:i').').xls"');
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
