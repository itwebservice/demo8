<?php 
include "../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$branch_status = $_POST['branch_status'];
$base_url = $_POST['base_url'];
$reference_id = $_POST['reference_id'];

if($reference_id=='3'){ 
	get_customer_dropdown($role,$branch_admin_id,$branch_status)
	?>
<?php }else{
	echo '<option value="">Select Customer</option>';
}
?>
