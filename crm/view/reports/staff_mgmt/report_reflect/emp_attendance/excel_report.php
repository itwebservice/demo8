<?php
include "../../../../../model/model.php";
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

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
$year = $_GET['year'];
$month = $_GET['month'];
$emp_id = $_GET['emp_id'];
$branch_status = $_GET['branch_status'];
$month_days = $_GET['mdays'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$from_date = "1-$month-$year";
$from_date = get_date_db($from_date);
$days = date("t", strtotime($from_date));
$to_date = "$days-$month-$year";
$to_date = get_date_db($to_date);
$new = array();

if($month != ''){

    if($month == '1'){
        $month_name = 'January';
    }
    else if($month == '2'){
        $month_name = 'February';
    }
    else if($month == '3'){
        $month_name = 'March';
    }
    else if($month == '4'){
        $month_name = 'April';
    }
    else if($month == '5'){
        $month_name = 'May';
    }
    else if($month == '6'){
        $month_name = 'June';
    }
    else if($month == '7'){
        $month_name = 'July';
    }
    else if($month == '8'){
        $month_name = 'August';
    }
    else if($month == '9'){
        $month_name = 'September';
    }
    else if($month == '10'){
        $month_name = 'October';
    }
    else if($month == '11'){
        $month_name = 'November';
    }
    else if($month == '12'){
        $month_name = 'December';
    }
}

if($emp_id != ''){
    $sq_user = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
    $emp_name = $sq_user['first_name'].' '.$sq_user['last_name'];
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'User Attendance')
            ->setCellValue('B3', 'Year')
            ->setCellValue('C3', $year)
            ->setCellValue('B4', 'Month')
            ->setCellValue('C4', $month_name)
            ->setCellValue('B5', 'User Name')
            ->setCellValue('C5', $emp_name);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);  

$query = "select * from emp_master where 1 and active_flag!='Inactive'";
if($emp_id!=''){
    $query .= " and emp_id = '$emp_id'";
} 
if($branch_status=='yes' && $role!='Admin'){
    $query .=" and branch_id='$branch_admin_id'";
}
$sq_a = mysqlQuery($query);
$total_paid_amt = 0;

$row_count = 8;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "User_ID")
        ->setCellValue('C'.$row_count, "User Name");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':C'.$row_count)->applyFromArray($borderArray);  

$char = '68';

for($i = 1; $i <= 31; $i++){

    $temp = chr($char);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($temp.$row_count, $i);

    $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($borderArray);  
    $char++;
}

$attendance = array("Present","Absent","On Tour","Half Day","Work From Home","Holiday OFF","Weekly OFF");
for($i = 0; $i < sizeof($attendance); $i++){

    $temp = chr($char);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($temp.$row_count, $attendance[$i]);

    $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($header_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($borderArray);  
    $char++;
}

$row_count++;
$count = 0;

while($row_emp = mysqli_fetch_assoc($sq_a)){

    $temp_arr = array(
    (int)($row_emp['emp_id']),
    $row_emp['first_name'].' '.$row_emp['last_name']);
    $i=0;
    while($i<$days) {

        $p_count=0;
        $a_count=0;
        $ot_count=0;
        $hd_count=0;
        $wfh_count=0;
        $ho_count=0;
        $wo_count=0;
        $j = $i+1;
        $query1 =mysqli_fetch_assoc(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and day(att_date)='$j'"));

        if($query1['status']!=""){ $status = $query1['status']; }
        else{ $status = '-';}
        array_push($temp_arr, $status);
        $i++; 
    }
    $p_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Present'"));
    $a_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Absent'"));
    $ot_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='On Tour'"));
    $hd_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Half Day'"));
    $wfh_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Work From Home'"));
    $ho_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Holiday Off'"));
    $wo_count =mysqli_num_rows(mysqlQuery( "select * from employee_attendance_log where emp_id='$row_emp[emp_id]' and month(att_date)= '$month' and year(att_date) = '$year' and status='Weekly Off'"));

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, (int)($row_emp['emp_id']))
        ->setCellValue('C'.$row_count, $row_emp['first_name'].' '.$row_emp['last_name']);
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':'.'C'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':'.'C'.$row_count)->applyFromArray($borderArray);
    
    $char = '68';
    foreach($temp_arr as $val){

        $char = '68';
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($temp.$row_count, $val);
        $char++;

        $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($header_style_Array);
        $objPHPExcel->getActiveSheet()->getStyle($temp.$row_count.':'.$temp.$row_count)->applyFromArray($borderArray);   
    }

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $p_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $a_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $ot_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $hd_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $wfh_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $ho_count);

    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);
    $char++;

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue(chr($char).$row_count, $wo_count);
    $objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($content_style_Array);
	$objPHPExcel->getActiveSheet()->getStyle(chr($char).$row_count.':'.chr($char).$row_count)->applyFromArray($borderArray);

    $row_count++;
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
header('Content-Disposition: attachment;filename="USER ATTENDANCE('.date('d-m-Y H:i').').xls"');
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
