<?php
include "../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
?>
<option value="">Select Booking ID</option>
<?php
$query = "select * from miscellaneous_master where 1";
$query .=" and customer_id='$customer_id' ";
include "../../model/app_settings/branchwise_filteration.php";

$sq_visa = mysqlQuery($query);
while($row_visa = mysqli_fetch_assoc($sq_visa)){
	
	$sq_entries = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries where misc_id ='$row_visa[misc_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from miscellaneous_master_entries where misc_id ='$row_visa[misc_id]' and status='Cancel'"));
	$created_at = $row_visa['created_at'];
	$yr = explode("-", $created_at);
	$year =$yr[0];
	if($sq_entries != $sq_entries_cancel){
		?>
		<option value="<?= $row_visa['misc_id'] ?>"><?= get_misc_booking_id($row_visa['misc_id'],$year) ?></option>
		<?php
	}
}
?>