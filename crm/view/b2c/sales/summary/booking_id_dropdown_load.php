<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];

?>
<option value="">Booking ID</option>
<?php
$query = "select * from b2c_sale where 1";
if($customer_id!=""){
	$query .="  and customer_id='$customer_id'";
}

$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){

	$booking_date = $row_booking['created_at'];
	$yr = explode("-", $booking_date);
	$year = $yr[0];
	?>
	<option value="<?= $row_booking['booking_id'] ?>"><?= get_b2c_booking_id($row_booking['booking_id'],$year) ?></option>
	<?php
}
?>