<?php 
include_once('../../../../model/model.php');

$user_id = $_SESSION['user_id'];
$vendor_type = $_SESSION['vendor_type'];

if($vendor_type == 'Hotel Vendor'){
	$service='Hotel';
}
else if($vendor_type == 'Excursion Vendor'){
	$service='Activity';
}
else if($vendor_type == 'Car Rental Vendor'){
	$service='Transfer';
}
else if($vendor_type == 'Cruise Vendor'){
	$service='Ferry';
}
else{
	$service = '';
}
$query = "select * from b2b_booking_master ORDER BY booking_id DESC";
?>
<div class="row mg_tp_20"> 
	<div class="col-md-12"> 
	<div class="table-responsive">
			<table class="table table-hover" id="tbl_estimate_list" style="margin: 20px 0 !important;">
				<thead>
					<tr class="active table-heading-row">
						<th>S_No.</th>
						<th>Agent_Name</th>
						<th>Booking_id</th>
						<th>Booking_date</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sq_booking = mysqlQuery($query);
					$hotel_flag = 0;
					while($row_booking = mysqli_fetch_assoc($sq_booking)){
						$checkin = array();
						$checkout = array();
						$cart_checkout_data = json_decode($row_booking['cart_checkout_data']);
						foreach($cart_checkout_data as $values){
							if($values->service->name == $service){
								if($values->service->id == $user_id ){

									$customer_det = mysqli_fetch_assoc(mysqlQuery("select first_name,last_name,company_name,type from customer_master where customer_id = ".$row_booking['customer_id']));
									
									$cust_name = ($customer_det['type']=='B2B' || $customer_det['type']=='Corporate') ? $customer_det['company_name'] : $customer_det['first_name'].' '.$customer_det['last_name'];

									array_push($checkin, get_date_user($values->service->check_in));
									array_push($checkout, get_date_user($values->service->check_out));
									$hotel_flag = 1;
									$booking_id = $row_booking['booking_id'];
									$yr = explode("-", get_datetime_db($row_booking['created_at']));
								}
						}
					}
					if($hotel_flag === 1){
						?>
						<tr class="<?= $bg ?>">
								<td><?= ++$count ?></td>
								<td><?= ucfirst($cust_name) ?></td>
								<td><?= get_b2b_booking_id($booking_id,$yr[0]) ?></td>
								<td><?= get_date_user($row_booking['created_at']) ?></td>
								<td><button class="btn btn-info btn-sm" onclick="view_modal('<?= $booking_id ?>')" title="View Details"><i class="fa fa-eye"></i></button></td>		
						</tr>
						<?php
					}
					$hotel_flag = 0;
				}
				?>
			</tbody>	
		</table>
	</div>
	</div>
</div>
<script>
$('#tbl_estimate_list').dataTable({
		"pagingType": "full_numbers"
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>