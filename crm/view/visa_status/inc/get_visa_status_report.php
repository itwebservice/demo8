<?php
include "../../../model/model.php";
$booking_id = $_POST['booking_id'];
$booking_type = $_POST['booking_type'];
$count = 0;

$sq_report = mysqlQuery("select * from visa_status_entries where booking_type ='$booking_type' and booking_id = '$booking_id'");
?>
<div class="row mg_tp_20">
<div class="table-responsive">

	<table class="table table-hover table-bordered" id="tbl_status_list" style="margin: 20px 0 !important;">
		<thead>
			<tr class="table-heading-row">
				<th>S_No.</th>
				<th>Status_Date</th>
				<th>Passenger_Name</th>
				<th>Visa_Status</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			while($row_report = mysqli_fetch_assoc($sq_report)) {
				$count++;
				?>
			<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo get_date_user($row_report['created_at']); ?></td>
			<?php
				if($booking_type=="visa_booking")
				{
					$sq_visa = mysqli_fetch_assoc(mysqlQuery("select * from visa_master_entries where entry_id='$row_report[traveler_id]' "));  ?>
				    <td><?php echo $sq_visa['first_name'].' '.$sq_visa['last_name']; ?></td>

				<?php }
				if($booking_type=="package_tour")
				{
					$sq_package = mysqli_fetch_assoc(mysqlQuery("select * from package_travelers_details where traveler_id='$row_report[traveler_id]' ")); 
					?>
				    <td><?php echo $sq_package['first_name'].' '.$sq_package['last_name'];?></td>

 				<?php }
				if($booking_type=="group_tour")
				{
					$sq_group = mysqli_fetch_assoc(mysqlQuery("select * from travelers_details where traveler_id='$row_report[traveler_id]' ")); 
					?>
				    <td><?php echo $sq_group['first_name'].' '.$sq_group['last_name'];?></td>

 				<?php }
				if($booking_type=="flight_booking")
				{
					$sq_flight = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master_entries where entry_id='$row_report[traveler_id]' ")); 
					?>
				    <td><?php echo $sq_flight['first_name'].' '.$sq_flight['last_name'];?></td>

 				<?php } ?>		

 				<!-- //document status -->
				   <td><?php echo $row_report['doc_status']; ?> </td>
				   <td><?php echo $row_report['comment']; ?> </td>
			</tr>

			<?php } ?>
		</tbody>
	</table>
</div>
</div>
<script type="text/javascript">
	$('#tbl_status_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>