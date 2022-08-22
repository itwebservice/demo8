<?php
include "../../../model/model.php";

$customer_id = $_POST['customer_id'];

$query = "select * from tourwise_traveler_details where tour_group_status != 'Cancel' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){
	
	$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
	$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));
	
	if($row_booking['tour_group_status']!="Cancel" && $pass_count!=$cancelpass_count){

		$date = $row_booking['form_date'];
		$yr = explode("-", $date);
		$year =$yr[0];
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
		if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
			$customer_name = $sq_customer['company_name'];
		}else{
			$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		?>
		<option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id'],$year) ?> : <?= $customer_name ?></option>
		<?php
	}
}