<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$template_type = $_POST['template_type'];
$array_s = array();
$temp_arr = array();

$count = 0;
$query = "select * from email_template_master where 1";
if($template_type!=''){
    $query .= " and template_type='$template_type'";
}
// if($branch_status=='yes' && $role=='Branch Admin'){
// 	$query .=" and branch_admin_id = '$branch_admin_id'";
// }
$sq_sms_group = mysqlQuery($query);
while($row_sms_group = mysqli_fetch_assoc($sq_sms_group)){

	$temp_arr = array( "data" => array(
		
		(int)(++$count),
		$row_sms_group['template_type'],
        date('d-m-Y',strtotime($row_sms_group['created_at'])),
		'<button class="btn btn-info btn-sm" onclick="view_modal(\''.$row_sms_group['template_id'] .'\')" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>'	
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
	
}
echo json_encode($array_s);
?>
	