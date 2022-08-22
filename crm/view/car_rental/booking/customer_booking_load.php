<?php
include "../../../model/model.php";
$customer_id = $_POST['customer_id'];
echo '<option value="">Select Booking</option>';

$query = "select * from car_rental_booking where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";	
}
$query .= " and status!='Cancel'";
$query .= " and financial_year_id = '".$_SESSION['financial_year_id']."' order by booking_id desc";
$sq_booking = mysqlQuery($query);

while($row_booking = mysqli_fetch_assoc($sq_booking))
{
  $date = $row_booking['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));

    if($sq_customer['type']=='Corporate'||$sq_customer['type']=='B2B'){
            ?>
              <option value="<?= $row_booking['booking_id'] ?>"><?= get_car_rental_booking_id($row_booking['booking_id'],$year)." : ".$sq_customer['company_name'] ?></option>
            <?php }  else{ ?>
              <option value="<?= $row_booking['booking_id'] ?>"><?= get_car_rental_booking_id($row_booking['booking_id'],$year)." : ".$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
            <?php } ?>

  <?php
}
?>