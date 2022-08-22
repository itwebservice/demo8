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





////////////////////////****************Content start**************////////////////////////////
$login_role = $_GET['login_role'];
$role = $_GET['role'];
$active_flag = $_GET['active_flag'];
$location_id = $_GET['location_id'];
$branch_id = $_GET['branch_id'];
$branch_status = $_GET['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq_location = mysqli_fetch_assoc(mysqlQuery("select location_name from locations where location_id = '$location_id'"));
$sq_branch = mysqli_fetch_assoc(mysqlQuery("select branch_name from branches where branch_id = '$branch_id'"));

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'User Information')
            ->setCellValue('B3', 'Role')
            ->setCellValue('C3', $role)
            ->setCellValue('B4', 'Location')
            ->setCellValue('C4', $sq_location['location_name'])
            ->setCellValue('B5', 'Branch')
            ->setCellValue('C5', $sq_branch['branch_name']);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);

$row_count = 7;
$row_count++;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$row_count, "User Id")
        ->setCellValue('B'.$row_count, "Name")
        ->setCellValue('C'.$row_count, "DOB")
        ->setCellValue('D'.$row_count, "Mobile_No")
        ->setCellValue('E'.$row_count, "Age")
        ->setCellValue('F'.$row_count, "Alternative_No")
        ->setCellValue('G'.$row_count, "Gender")
        ->setCellValue('H'.$row_count, "Email")
        ->setCellValue('I'.$row_count, "UAN")
        ->setCellValue('J'.$row_count, "Location")
        ->setCellValue('K'.$row_count, "Branch")
        ->setCellValue('L'.$row_count, "Address")
        ->setCellValue('M'.$row_count, "Username")
        ->setCellValue('N'.$row_count, "Password")
        ->setCellValue('O'.$row_count, "Role")
        ->setCellValue('P'.$row_count, "Joining_Date")
        ->setCellValue('Q'.$row_count, "Monthly_target_to_sale")
        ->setCellValue('R'.$row_count, "Incentive(%)")
        ->setCellValue('S'.$row_count, "SMTP Status")
        ->setCellValue('T'.$row_count, "SMTP Host")
        ->setCellValue('U'.$row_count, "SMTP Port")
        ->setCellValue('V'.$row_count, "SMTP Password")
        ->setCellValue('W'.$row_count, "SMTP Method")
        ->setCellValue('X'.$row_count, "Status");

$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':X'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':X'.$row_count)->applyFromArray($borderArray);

$row_count++;
$count = 0;

    
$query = "select * from emp_master where 1";

if($role != ""){
	$query_role = mysqli_fetch_assoc(mysqlQuery("select * from role_master where role_name = '$role'")); 
	$query .=" and role_id='$query_role[role_id]'";
}
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($location_id!=""){
	$query .=" and location_id='$location_id' ";
}
if($branch_id!=""){
	$query .=" and branch_id='$branch_id' ";
}
if($branch_status=='yes' && $login_role!='Admin' && $role!='Admin'){
	$query .= " and branch_id = '$branch_admin_id'";
}
global $secret_key,$encrypt_decrypt;
$sq_sal1 =mysqlQuery($query);
while($sq_sal = mysqli_fetch_assoc($sq_sal1))
{
    $location_name = mysqli_fetch_assoc(mysqlQuery('select location_name from locations where location_id='.$sq_sal['location_id']));
    $branch_name = mysqli_fetch_assoc(mysqlQuery('select branch_name from branches where branch_id='.$sq_sal['branch_id']));
    $sq_role = mysqli_fetch_assoc(mysqlQuery('select role_name from role_master where role_id='.$sq_sal['role_id']));
    $username = $encrypt_decrypt->fnDecrypt($sq_sal['username'], $secret_key);
    $password = $encrypt_decrypt->fnDecrypt($sq_sal['password'], $secret_key);

    $objPHPExcel->getActiveSheet()
        ->getStyle('I'.$row_count)
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$row_count, $sq_sal['emp_id'])
    ->setCellValue('B'.$row_count, $sq_sal['first_name'].' '.$sq_sal['last_name'])
    ->setCellValue('C'.$row_count, $sq_sal['dob'] )
    ->setCellValue('D'.$row_count, $sq_sal['mobile_no'])
    ->setCellValue('E'.$row_count, $sq_sal['age'])
    ->setCellValue('F'.$row_count, $sq_sal['mobile_no2'])
    ->setCellValue('G'.$row_count, $sq_sal['gender'])
    ->setCellValue('H'.$row_count, $sq_sal['email_id'])
    ->setCellValue('I'.$row_count,$sq_sal['uan_code'])
    ->setCellValue('J'.$row_count, $location_name['location_name'])
    ->setCellValue('K'.$row_count, $branch_name['branch_name'])
    ->setCellValue('L'.$row_count, $sq_sal['address'])
    ->setCellValue('M'.$row_count, $username)
    ->setCellValue('N'.$row_count, $password)
    ->setCellValue('O'.$row_count, $sq_role['role_name'])
    ->setCellValue('P'.$row_count, $sq_sal['date_of_join'])
    ->setCellValue('Q'.$row_count, $sq_sal['target'])
    ->setCellValue('R'.$row_count, $sq_sal['incentive_per'])
    ->setCellValue('S'.$row_count, $sq_sal['app_smtp_status'])
    ->setCellValue('T'.$row_count, $sq_sal['app_smtp_host'])
    ->setCellValue('U'.$row_count, $sq_sal['app_smtp_port'])
    ->setCellValue('V'.$row_count, $sq_sal['app_smtp_password'])
    ->setCellValue('W'.$row_count, $sq_sal['app_smtp_method'])
    ->setCellValue('X'.$row_count, $sq_sal['active_flag']);


    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':X'.$row_count)->applyFromArray($content_style_Array);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row_count.':X'.$row_count)->applyFromArray($borderArray);    

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

header('Content-Disposition: attachment;filename="User_Information('.date('d-m-Y H:i').').xls"');

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

