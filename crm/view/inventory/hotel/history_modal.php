<?php
include "../../../model/model.php";
$purchase_id = $_POST['purchase_id'];
$str="select * from hotel_inventory_master where entry_id='$purchase_id'";
$query = mysqlQuery($str);
?>
<div class="modal fade" id="history_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Hotel Inventory History</h4>
			</div>
			<div class="modal-body">
				<div class="row"> <div class="col-md-12"> <div class="table-responsive">
				<table class="table" id="table_paid" style="margin: 20px 0 !important;">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Service</th>
							<th>Booking_id</th>
							<th>Customer_name</th>
							<th>no_of_rooms</th>
							<th>Checkin_datetime</th>
							<th>Checkout_datetime</th>
							<th>Room_type</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 0;
						while($row_ser = mysqli_fetch_assoc($query)){
							$sql_temp=mysqlQuery("select * from package_hotel_accomodation_master where city_id= '$row_ser[city_id]' and hotel_id= '$row_ser[hotel_id]' and catagory='$row_ser[room_type]' and (from_date between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')");
							while($sql = mysqli_fetch_assoc($sql_temp)){
								
							$cancel_est = mysqli_num_rows(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$sql[booking_id]'"));
							if($cancel_est == 0){
								
								$check_in=$sql['from_date'];
								$check_out=$sql['to_date'];
								$str1="select * from package_tour_booking_master where booking_id=$sql[booking_id]";
								$sql_cust=mysqli_fetch_assoc(mysqlQuery($str1));
								$date = $sql_cust['booking_date'];
								$yr = explode("-", $date);
								$year = $yr[0];
								$sql_Cust_details=mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id=$sql_cust[customer_id]"));
								if($sql_Cust_details['type']=='Corporate'||$sql_Cust_details['type'] == 'B2B'){
									$customer_name = $sql_Cust_details['company_name'];
								}else{
									$customer_name = $sql_Cust_details['first_name'].' '.$sql_Cust_details['last_name'];
								}
								?>
								<tr class="<?= $bg ?>">
									<td><?= ++$count ?></td>
									<td>Package</td>
									<td><?= get_package_booking_id($sql_cust['booking_id'],$year)?></td>
									<td><?= $customer_name; ?></td>
									<td><?= $sql['rooms'] ?></td>
									<td><?= date("d-m-Y H:i", strtotime($check_in)) ?></td>
									<td><?= date("d-m-Y H:i", strtotime($check_out)) ?></td>
									<td><?= $sql['room_type'] ?></td>
								</tr>
								<?php
								}
							}
							$sql_temp=mysqlQuery("select * from hotel_booking_entries where status!='Cancel' and city_id= '$row_ser[city_id]' and hotel_id	= '$row_ser[hotel_id]' and category='$row_ser[room_type]' and (check_in between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')");
							while($sql = mysqli_fetch_assoc($sql_temp)){
								$check_in=$sql['check_in'];
								$check_out=$sql['check_out'];
								$str1="select * from hotel_booking_master where booking_id=$sql[booking_id]";
								$sql_cust=mysqli_fetch_assoc(mysqlQuery($str1));
								$date = $sql_cust['booking_date'];
								$yr = explode("-", $date);
								$year = $yr[0];
								$sql_Cust_details=mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id=$sql_cust[customer_id]"));
								if($sql_Cust_details['type']=='Corporate'||$sql_Cust_details['type'] == 'B2B'){
									$customer_name = $sql_Cust_details['company_name'];
								}else{
									$customer_name = $sql_Cust_details['first_name'].' '.$sql_Cust_details['last_name'];
								}
								?>
								<tr class="<?= $bg ?>">
									<td><?= ++$count ?></td>
									<td>Hotel</td>
									<td><?= get_hotel_booking_id($sql_cust['booking_id'],$year)?></td>
									<td><?= $customer_name; ?></td>
									<td><?= $sql['rooms'] ?></td>
									<td><?= date("d-m-Y H:i", strtotime($check_in)) ?></td>
									<td><?= date("d-m-Y H:i", strtotime($check_out)) ?></td>
									<td><?= $sql['room_type'] ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
				</div> </div> </div>
	</div>
</div>
</div>
</div>

<script>
$('#history_modal').modal('show');
</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>