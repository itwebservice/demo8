<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from package_tour_booking_master where financial_year_id = '$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
 
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){
	$date = $row_booking['booking_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		$customer_name = $sq_customer['company_name'];
	}else{
		$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
	}
	?>
	<option value="<?= $row_booking['booking_id'] ?>"><?= get_package_booking_id($row_booking['booking_id'],$year) ?> : <?= $customer_name ?></option>
	<?php
}