<div class="row mg_bt_20">
	<div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block">
			<h3>Tour Details</h3>
			<div class="row">
				<div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
					<span class="main_block"> 
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Booking ID <em>:</em></label>" .get_b2c_booking_id($booking_id,$year) ?>
					</span>
					<span class="main_block"> 
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Tour Name <em>:</em></label>" .$enq_data[0]->package_name; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Travel Date <em>:</em></label>" .$enq_data[0]->travel_from.' To '.$enq_data[0]->travel_to ?> 
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Total Guest <em>:</em></label>" .$total_pax ?> 
					</span>
				</div>
				<?php
				if($sq_package_info['service'] == 'Holiday'){
					?>
					<div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
						<span class="main_block"> 
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Pickup Location <em>:</em></label>" .$enq_data[0]->pickup_from ?>
						</span>
						<span class="main_block"> 
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Pickup Date&Time <em>:</em></label>" .$enq_data[0]->pickup_time; ?>
						</span>
						<span class="main_block">
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Dropoff Location <em>:</em></label>" .$enq_data[0]->drop_to ?> 
						</span>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="profile_box main_block">

			<h3>Customer Details</h3>


			<div class="row">

				<div class="col-sm-6 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">

					<span class="main_block"> 

							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo  "<label>Customer Name <em>:</em></label> " .$sq_package_info['name'].'&nbsp'; ?>

					</span>

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Email <em>:</em></label> " .$sq_package_info['email_id']; ?>

					</span>	

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

						<?php echo "<label>Mobile No <em>:</em></label>" .$sq_package_info['phone_no']; ?> 

					</span>

				</div>

				<div class="col-sm-6 col-xs-12">


							<span class="main_block">

									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								<?php echo "<label>City <em>:</em></label> ".$sq_package_info['city']; ?>

							</span>

					<span class="main_block">

						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							<?php echo "<label>State <em>:</em></label> ".$sq_state['state_name']; ?> 

					</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mg_bt_20">
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
			<h3>Booking Details</h3>
			<div class="row">
				<div class="col-xs-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Booking Date&Time <em>:</em></label> ".get_datetime_user($sq_package_info['created_at']) ;?> 
					</span>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Other Specification <em>:</em></label> ".$enq_data[0]->specification;?> 
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
		<h3>Guest Details</h3>
			<div class="table-responsive">
			<table class="table table-bordered no-marg" id="tbl_emp_list">
				<thead>
					<tr class="table-heading-row">
					<th>Adolescence</th>
					<th>Full_Name</th>
					<th>DOB</th>
					</tr>
				</thead>
				<tbody>
				<?php
					for($i=0;$i<sizeof($guest_data[0]->adult);$i++){
					?>   
						<tr class="<?= $bg_clr ?>">
						<td>Adult</td>
						<td><?php echo $guest_data[0]->adult[$i]->honorific.' '.$guest_data[0]->adult[$i]->first_name.' '.$guest_data[0]->adult[$i]->last_name; ?></td>
						<td><?php echo $guest_data[0]->adult[$i]->birthdate; ?></td>
						</tr>
				<?php
				} ?>
				<?php
    				$guest_data[0]->chwob = ($guest_data[0]->chwob != '') ? $guest_data[0]->chwob : [];
					for($i=0;$i<sizeof($guest_data[0]->chwob);$i++){
					?>   
						<tr class="<?= $bg_clr ?>">
						<td>Child w/o bed</td>
						<td><?php echo $guest_data[0]->chwob[$i]->honorific.' '.$guest_data[0]->chwob[$i]->first_name.' '.$guest_data[0]->chwob[$i]->last_name; ?></td>
						<td><?php echo $guest_data[0]->chwob[$i]->birthdate; ?></td>
						</tr>
				<?php
				} ?>
				<?php
    				$guest_data[0]->chwb = ($guest_data[0]->chwb != '') ? $guest_data[0]->chwb : [];
					for($i=0;$i<sizeof($guest_data[0]->chwb);$i++){
					?>   
						<tr class="<?= $bg_clr ?>">
						<td>Child with bed</td>
						<td><?php echo $guest_data[0]->chwb[$i]->honorific.' '.$guest_data[0]->chwb[$i]->first_name.' '.$guest_data[0]->chwb[$i]->last_name; ?></td>
						<td><?php echo $guest_data[0]->chwb[$i]->birthdate; ?></td>
						</tr>
				<?php
				} ?>
				<?php
    				$guest_data[0]->extra_bed = ($guest_data[0]->extra_bed != '') ? $guest_data[0]->extra_bed : [];
					for($i=0;$i<sizeof($guest_data[0]->extra_bed);$i++){
					?>   
						<tr class="<?= $bg_clr ?>">
						<td>Extra Bed</td>
						<td><?php echo $guest_data[0]->extra_bed[$i]->honorific.' '.$guest_data[0]->extra_bed[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
						<td><?php echo $guest_data[0]->extra_bed[$i]->birthdate; ?></td>
						</tr>
				<?php
				} ?>
				<?php
    				$guest_data[0]->infant = ($guest_data[0]->infant != '') ? $guest_data[0]->infant : [];
					for($i=0;$i<sizeof($guest_data[0]->infant);$i++){
					?>   
						<tr class="<?= $bg_clr ?>">
						<td>Infant</td>
						<td><?php echo $guest_data[0]->infant[$i]->honorific.' '.$guest_data[0]->infant[$i]->first_name.' '.$guest_data[0]->infant[$i]->last_name; ?></td>
						<td><?php echo $guest_data[0]->infant[$i]->birthdate; ?></td>
						</tr>
				<?php
				} ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
