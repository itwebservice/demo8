<?php
include "../../../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$enquiry_id = $_POST['enquiry_id'];

$quot_info_arr = array();

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));


$quot_info_arr['first_name'] = $sq_quotation['name'];
$quot_info_arr['contact_no'] = $sq_quotation['mobile_no'];
$quot_info_arr['email_id'] = $sq_quotation['email_id'];
$quot_info_arr['country_code'] = $sq_quotation['country_code'];
$quot_info_arr['city'] = $sq_quotation['location'];
$quot_info_arr['landline_no'] = $sq_quotation['landline_no'];
// str_replace($sq_customer['country_code'],"",$contact_no)
$quot_info_arr['branch_admin_id'] = $branch_admin_id;
$quot_info_arr['type'] = 'Regular';
$quot_info_arr['middle_name'] = '';
$quot_info_arr['last_name'] = '';
$quot_info_arr['age'] = '';
$quot_info_arr['alt_email'] = '';
$quot_info_arr['company_name'] = '';
$quot_info_arr['address'] = '';

$quot_info_arr['gl_id'] =  '';
$quot_info_arr['service_tax_no'] =  '';
$quot_info_arr['active_flag'] =  'Active';
$quot_info_arr['created_at'] =  date('Y-m-d');
$quot_info_arr['pan_no'] =  '';
$quot_info_arr['source'] =  '';


echo json_encode($quot_info_arr);
?>