<?php
if($sq_package_info['service'] == 'Holiday'){
	$sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from custom_package_hotels where package_id='$package_id'"));
	if($sq_c_hotel != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-xs-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Accommodation Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>City</th>
									<th>Hotel_Name</th>
									<th>Hotel_Category</th>
									<th>Total_Night(s)</th>
								</tr>
							</thead>
							<tbody>   
							<?php 
							$sq_hotel = mysqlQuery("select * from custom_package_hotels where package_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
							$hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
							$city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
							?>
							<tr>
								<td><?php echo $city_name['city_name']; ?></td>
								<td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
								<td><?php echo $row_hotel['hotel_type']; ?></td>
								<td></span><?php echo $row_hotel['total_days']; ?></td>
							</tr>
							<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php } ?>

	<?php 
	$sq_tr_count = mysqli_num_rows(mysqlQuery("select * from custom_package_transport where package_id='$package_id'"));
	if($sq_tr_count != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-md-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Transport Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>VEHICLE</th>
									<th>Pickup_location</th>
									<th>Dropoff_location</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$count = 0;
							$sq_hotel = mysqlQuery("select * from custom_package_transport where package_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
								$transport_name = mysqli_fetch_assoc(mysqlQuery("select * from b2b_transfer_master where entry_id ='$row_hotel[vehicle_name]'"));
								// Pickup
								if($row_hotel['pickup_type'] == 'city'){
								$row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[pickup]'"));
								$pickup = $row['city_name'];
								}
								else if($row_hotel['pickup_type'] == 'hotel'){
								$row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[pickup]'"));
								$pickup = $row['hotel_name'];
								}
								else{
								$row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[pickup]'"));
								$airport_nam = clean($row['airport_name']);
								$airport_code = clean($row['airport_code']);
								$pickup = $airport_nam." (".$airport_code.")";
								$html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
								}
								// Drop
								if($row_hotel['drop_type'] == 'city'){
								$row = mysqli_fetch_assoc(mysqlQuery("select city_id,city_name from city_master where city_id='$row_hotel[drop]'"));
								$drop = $row['city_name'];
								}
								else if($row_hotel['drop_type'] == 'hotel'){
								$row = mysqli_fetch_assoc(mysqlQuery("select hotel_id,hotel_name from hotel_master where hotel_id='$row_hotel[drop]'"));
								$drop = $row['hotel_name'];
								}
								else{
								$row = mysqli_fetch_assoc(mysqlQuery("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_hotel[drop]'"));
								$airport_nam = clean($row['airport_name']);
								$airport_code = clean($row['airport_code']);
								$drop = $airport_nam." (".$airport_code.")";
								$html = '<optgroup value="airport" label="Airport Name"><option value="'.$row['airport_id'].'">'.$pickup.'</option></optgroup>';
								}
								?>
								<tr>
								<td><?= $transport_name['vehicle_name'].$similar_text ?></td>
								<td><?= $pickup ?></td>
								<td><?= $drop ?></td>
								</tr>
						<?php } ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php }
}
else{
	// Hotel
	$sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'"));
	if($sq_c_hotel != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-xs-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Accommodation Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>City</th>
									<th>Hotel_Name</th>
									<th>Hotel_Category</th>
									<th>Total_Night(s)</th>
								</tr>
							</thead>
							<tbody>   
							<?php 
							$sq_hotel = mysqlQuery("select * from group_tour_hotel_entries where tour_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
								$hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_id]'"));
								$city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_id]'"));
							?>
							<tr>
								<td><?php echo $city_name['city_name']; ?></td>
								<td><?php echo $hotel_name['hotel_name'].$similar_text; ?></td>
								<td><?php echo $row_hotel['hotel_type']; ?></td>
								<td></span><?php echo $row_hotel['total_nights']; ?></td>
							</tr>
							<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php }
	// Train
	$sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_train_entries where tour_id='$package_id'"));
	if($sq_c_hotel != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-xs-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Train Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>From_Location</th>
									<th>To_Location</th>
									<th>Class</th>
								</tr>
							</thead>
							<tbody>   
							<?php 
							$sq_hotel = mysqlQuery("select * from group_train_entries where tour_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
								$hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_id]'"));
								$city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_id]'"));
							?>
							<tr>
								<td><?= $row_hotel['from_location'].$similar_text ?></td>
								<td><?= $row_hotel['to_location'] ?></td>
								<td><?= $row_hotel['class'] ?></td>
							</tr>
							<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php }
	// Flight
	$sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'"));
	if($sq_c_hotel != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-xs-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Flight Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>From_sector</th>
									<th>To_sector</th>
									<th>Airline</th>
									<th>Class</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$sq_hotel = mysqlQuery("select * from group_tour_plane_entries where tour_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
								$sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_hotel[airline_name]'"));
								$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[from_city]'"));
								$sq_city1 = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_hotel[to_city]'"));
							?>
							<tr>
								<td><?= $sq_city['city_name'].' ('.$row_hotel['from_location'].')' ?></td>
								<td><?= $sq_city1['city_name'].' ('.$row_hotel['to_location'].')' ?></td>
								<td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
								<td><?= $row_hotel['class'] ?></td>
							</tr>
							<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php }
	// Cruise
	$sq_c_hotel = mysqli_num_rows(mysqlQuery("select * from group_cruise_entries where tour_id='$package_id'"));
	if($sq_c_hotel != '0'){
		?>
		<div class="row mg_bt_20">
			<div class="col-xs-12">
				<div class="profile_box main_block">
					<h3 class="editor_title">Cruise Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>Route</th>
									<th>Cabin</th>
								</tr>
							</thead>
							<tbody>   
							<?php 
							$sq_hotel = mysqlQuery("select * from group_cruise_entries where tour_id='$package_id'");
							while($row_hotel = mysqli_fetch_assoc($sq_hotel)){
							?>
							<tr>
								<td><?= $row_hotel['route'] ?></td>
								<td><?= $row_hotel['cabin'] ?></td>
							</tr>
							<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div> 
			</div>
		</div>
	<?php }
}
?>