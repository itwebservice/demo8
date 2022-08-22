<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from tourwise_traveler_details where tour_group_status != 'Cancel' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($branch_status=='yes' && $role!='Admin'){
$query .=" and branch_admin_id = '$branch_admin_id'";
}
 
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysqlQuery($query);
while($row_booking = mysqli_fetch_assoc($sq_booking)){
	$date = $row_booking['form_date'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
		$cust_name = $sq_customer['company_name'];
	}else{
		$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
	}
	?>
	<option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id'], $year) ?> : <?= $cust_name ?></option>
	<?php
}?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>