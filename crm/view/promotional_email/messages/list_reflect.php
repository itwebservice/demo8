<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$array_s = array();
$temp_arr = array();

$count = 0;
$query = "select * from email_send_master where 1";

if($branch_status=='yes' && $role=='Branch Admin'){
	$query .=" and branch_admin_id = '$branch_admin_id'";
}
$sq_sms_group = mysqlQuery($query);
while($row_sms_group = mysqli_fetch_assoc($sq_sms_group)){

    $sql_template = mysqli_fetch_assoc(mysqlQuery("select * from email_template_master where template_id='$row_sms_group[template_id]'"));
    $sql_grp = mysqli_fetch_assoc(mysqlQuery("select * from email_group_master where email_group_id='$row_sms_group[group_id]'"));
	$temp_arr = array( "data" => array(
		(int)(++$count),
		$sql_template['template_type'],
        $sql_grp['email_group_name'],
        $row_sms_group['subject'],
        date('d-m-Y',strtotime($row_sms_group['created_at'])),
		'<button class="btn btn-info btn-sm" onclick="view_modal(\''.$row_sms_group['template_id'] .'\')" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>'	
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
	
}
echo json_encode($array_s);
?>
	