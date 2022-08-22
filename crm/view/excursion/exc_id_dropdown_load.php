<?php
include "../../model/model.php";

$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
?>
<option value="">Booking ID</option>
<?php
$query = "select * from excursion_master where 1";
if($customer_id!=""){
	$query .="  and customer_id='$customer_id'";
}
include "../../model/app_settings/branchwise_filteration.php";

$sq_exc = mysqlQuery($query);
while($row_exc = mysqli_fetch_assoc($sq_exc)){

	$sq_entries = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id ='$row_exc[exc_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from excursion_master_entries where exc_id ='$row_exc[exc_id]' and status='Cancel'"));
	$booking_date = $row_exc['created_at'];
	$yr = explode("-", $booking_date);
	$year = $yr[0];
	if($sq_entries != $sq_entries_cancel){
		$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_exc[customer_id]'"));
		if($sq_customer['type']=='Corporate'||$sq_customer['type'] == 'B2B'){
			$customer_name = $sq_customer['company_name'];
		}else{
			$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
		}
		?>
		<option value="<?= $row_exc['exc_id'] ?>"><?= get_exc_booking_id($row_exc['exc_id'],$year).' : '.$customer_name ?></option>
		<?php
	}
}
?>