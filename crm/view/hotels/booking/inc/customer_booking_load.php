<?php
include "../../../../model/model.php";
$customer_id = $_POST['customer_id'];
echo '<option value="">Select Booking</option>';

$query = "select * from hotel_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";	
}

$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){

  $date = $row_booking['created_at'];
  $yr = explode("-", $date);
  $year = $yr[0];
  $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
    $customer_name = $sq_customer['company_name'];
  }else{
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
  }
  ?>
  <option value="<?= $row_booking['booking_id'] ?>"><?= get_hotel_booking_id($row_booking['booking_id'],$year).' : '.$customer_name ?></option>
  <?php
}

?>