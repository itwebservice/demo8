<?php
include "../../../model/model.php";

$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];

$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<option value="">Booking ID</option>
<?php
$query = "select * from ticket_master where 1";
$query .=" and customer_id='$customer_id' ";
include "../../../model/app_settings/branchwise_filteration.php";
$sq_ticket = mysqlQuery($query);
while($row_ticket = mysqli_fetch_assoc($sq_ticket)){
    
	$sq_entries = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id ='$row_ticket[ticket_id]'"));
	$sq_entries_cancel = mysqli_num_rows(mysqlQuery("select * from ticket_master_entries where ticket_id ='$row_ticket[ticket_id]' and status='Cancel'"));
	$date = $row_ticket['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
	if($sq_entries != $sq_entries_cancel){
        ?>
        <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
        <?php
    }
}
?>