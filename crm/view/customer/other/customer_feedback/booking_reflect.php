<?php
include_once('../../../../model/model.php');
$booking_type = $_POST['booking_type'];
$customer_id = $_POST['customer_id'];
if ($booking_type == "Group Booking") {
	$query = "select * from tourwise_traveler_details where customer_id='$customer_id'";
	$sq_booking = mysqlQuery($query);
	while ($row_booking = mysqli_fetch_assoc($sq_booking)) {

		$sq_tour = mysqli_fetch_assoc(mysqlQuery("select from_date,to_date from tour_groups where group_id='$row_booking[tour_group_id]'"));
		$tour_group_from = date("d-m-Y", strtotime($sq_tour['from_date']));
		$tour_group_to = date("d-m-Y", strtotime($sq_tour['to_date']));

		$created_at = $row_booking['form_date'];
		$year = explode("-", $created_at);
		$year = $year[0];

		$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
		$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));
		if ($row_booking['tour_group_status'] != "Cancel" && $pass_count != $cancelpass_count) {
?>
			<option value="<?php echo $row_booking['id']; ?>"><?php echo  get_group_booking_id($row_booking['id'], $year) . ' (' . $tour_group_from . " To " . $tour_group_to . ')' ?></option>;
		<?php
		}
	}
} elseif ($booking_type == "Package Booking") {
	$query = "select * from package_tour_booking_master where customer_id='$customer_id' and tour_status != 'Cancel'";
	$sq_booking = mysqlQuery($query);
	while ($row_booking = mysqli_fetch_assoc($sq_booking)) {
		$created_at = $row_booking['booking_date'];
		$year = explode("-", $created_at);
		$year = $year[0];
		$pass_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_booking[booking_id]'"));
		$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$row_booking[booking_id]' and status='Cancel'"));
		if ($pass_count != $cancelpass_count) {
		?>
		<option value="<?php echo $row_booking['booking_id']; ?>"><?php echo  get_package_booking_id($row_booking['booking_id'], $year) . ' (' . date('d-m-Y', strtotime($row_booking['tour_from_date'])) . ' To ' . date('d-m-Y', strtotime($row_booking['tour_to_date'])) . ')' ?></option>;
<?php
		}
	}
} ?>
<script>
	$('#booking_id').select2();
</script>