<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from bus_booking_master where 1 ";
if($customer_id!=""){
	$query .="  and customer_id='$customer_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
echo '<option value="">Select Booking</option>';
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){

	$booking_date = $row_booking['created_at'];
	$yr = explode("-", $booking_date);
	$year =$yr[0];

	$pass_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id='$row_booking[booking_id]'"));
	$cancel_count = mysqli_num_rows(mysqlQuery("select * from bus_booking_entries where booking_id='$row_booking[booking_id]' and status='Cancel'"));

	if($pass_count==$cancel_count){
	}else{
		?>
		<option value="<?= $row_booking['booking_id'] ?>"><?= get_bus_booking_id($row_booking['booking_id'],$year) ?></option>
		<?php
	}
	
}