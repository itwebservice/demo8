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
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_GET['branch_status'];

$customer_id = $_GET['customer_id'];
$ticket_id = $_GET['ticket_id'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];

$sql_booking_date = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id = '$ticket_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];

if($customer_id!=""){
    $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
    if($sq_customer_info['type'] == 'Corporate'||$sq_customer_info['type'] == 'B2B'){
        $cust_name = $sq_customer_info['company_name'];
    }else{
        $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
    }
}
else{
    $cust_name = "";
}

$invoice_id = ($ticket_id!="") ? get_ticket_booking_id($ticket_id,$year): "";
if($company_name == 'undefined') { $company_name = ''; }

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Flight Ticket Passenger Report')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
            ->setCellValue('B5', 'Customer Type')
            ->setCellValue('C5', $cust_type)
            ->setCellValue('B6', 'Company Name')
            ->setCellValue('C6', $company_name);

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

$query = "select * from ticket_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
    $query .=" and ticket_id in ( select ticket_id from ticket_master where customer_id='$customer_id' )";
}
if($ticket_id!=""){
    $query .=" and ticket_id='$ticket_id'";
}
if($company_name != ""){
    $query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($cust_type != ""){
    $query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and ticket_id in (select ticket_id from ticket_master where emp_id='$emp_id') and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and ticket_id in (select ticket_id from ticket_master where emp_id='$emp_id' ))";
}

$row_count = 8;
$count = 0;

$sq_ticket = mysqlQuery($query);

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('E'.$row_count, "Passenger Name")
        ->setCellValue('F'.$row_count, "Adolescence")
        ->setCellValue('G'.$row_count, "Ticket_No")
        ->setCellValue('H'.$row_count, "Main Ticket No")
        ->setCellValue('I'.$row_count, "Baggage")
        ->setCellValue('J'.$row_count, "Seat_No")
        ->setCellValue('K'.$row_count, "Meal_plan");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

$row_count++;

while($row_ticket =mysqli_fetch_assoc($sq_ticket)){

    $date = $row_ticket['created_at'];
    $yr = explode("-", $date);
    $year = $yr[0];

    $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
    if($sq_customer_info['type'] == 'Corporate'||$sq_customer_info['type'] == 'B2B'){
        $cust_name = $sq_customer_info['company_name'];
    }else{
        $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
    }

    $from_city_arr = array();
    $to_city_arr = array();
    $sq_trip = mysqlQuery("SELECT * FROM ticket_trip_entries WHERE ticket_id='$row_ticket[ticket_id]'");
    while($row_trip = mysqli_fetch_assoc($sq_trip)){

        $dep_city = explode('(',$row_trip['departure_city']);
        $arr_city = explode('(',$row_trip['arrival_city']);

        $dep_city1 = explode(')',$dep_city[1]);
        $arr_city1 = explode(')',$arr_city[1]);
        array_push($from_city_arr,$dep_city1[0]);
        array_push($to_city_arr,$arr_city1[0]);
    }
    
    $sq_entry = mysqlQuery("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
    while($row_entry = mysqli_fetch_assoc($sq_entry)){

        $seat_no_string = '';
        $meal_plan_string = '';
        $seat_nos = explode('/',$row_entry['seat_no']);
        for($i = 0; $i < sizeof($seat_nos); $i++){
            $seat_no_string .= $seat_nos[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
            if($i != (sizeof($seat_nos)-1)){
                $seat_no_string .= ', ';
            }
        }
        $meal_plans = explode('/',$row_entry['meal_plan']);
        for($i = 0; $i < sizeof($meal_plans); $i++){
            $meal_plan_string .= $meal_plans[$i].' ('.$from_city_arr[$i].'-'.$to_city_arr[$i].')';
            if($i != (sizeof($meal_plans)-1)){
                $meal_plan_string .= ', ';
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$row_count, ++$count)
            ->setCellValue('C'.$row_count, get_ticket_booking_id($row_ticket['ticket_id'],$year))
            ->setCellValue('D'.$row_count, $cust_name)
            ->setCellValue('E'.$row_count, $row_entry['first_name']." ".$row_entry['middle_name']." ".$row_entry['last_name'])
            ->setCellValue('F'.$row_count, $row_entry['adolescence'])
            ->setCellValue('G'.$row_count, $row_entry['ticket_no'])
            ->setCellValue('H'.$row_count, ($row_entry['main_ticket']!='') ? $row_entry['main_ticket'] : 'NA')
            ->setCellValue('I'.$row_count, ($row_entry['baggage_info']!='') ? $row_entry['baggage_info'] : 'NA')
            ->setCellValue('J'.$row_count, ($row_entry['seat_no'] != '' ) ? $seat_no_string : 'NA')
            ->setCellValue('K'.$row_count, ($row_entry['meal_plan'] != '' ) ? $meal_plan_string : 'NA');
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($content_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':K'.$row_count)->applyFromArray($borderArray);    

        $row_count++;
    }
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
header('Content-Disposition: attachment;filename="FlightTicketMembers('.date('d-m-Y H:i:s').').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
