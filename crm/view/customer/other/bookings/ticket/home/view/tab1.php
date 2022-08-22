<div class="row">
	<div class="col-md-6 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block">
			<h3>Customer Details</h3>
			<?php $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_visa_info[customer_id]'"));
			$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);  ?>
			<div class="row">
				<div class="col-sm-5 col-xs-12">
					<span class="main_block">
						<i class="fa fa-id-card-o" aria-hidden="true"></i>
						<?php echo get_ticket_booking_id($ticket_id, $year); ?>
					</span>
					<span class="main_block">
						<i class="fa fa-user-o" aria-hidden="true"></i>
						<?php echo $sq_customer['first_name'] . ' ' . $sq_customer['middle_name'] . ' ' . $sq_customer['last_name'] . '&nbsp'; ?>
					</span>
					<?php
					if ($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B') {
					?>
						<span class="main_block">
							<i class="fa fa-building-o" aria-hidden="true"></i>
							<?php echo $sq_customer['company_name'] ?>
						</span>
					<?php  } ?>
				</div>
				<div class="col-sm-7 col-xs-12">
					<span class="main_block">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<?php echo $email_id; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-phone" aria-hidden="true"></i>
						<?php echo $contact_no; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
			<h3>Booking Details</h3>
			<?php $sq_ticket = mysqli_fetch_assoc(mysqlQuery("select * from ticket_master where ticket_id='$ticket_id'")); ?>
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Trip Type <em>:</em></label> " . $sq_ticket['type_of_tour']; ?>
					</span>
					<!-- <span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php $supplier_id = $sq_ticket['supplier_id'];
						$sq_sup1 = mysqli_fetch_assoc(mysqlQuery("select * from ticket_vendor where vendor_id='$sq_ticket[supplier_id]'"));
						echo "<label>Supplier <em>:</em></label> " . $sq_sup1['vendor_name']; ?>
					</span> -->
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Booking Date <em>:</em></label> " . get_date_user($sq_ticket['created_at']); ?>
					</span>
				</div>
				<div class="col-sm-6 col-xs-12">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Adult(s) <em>:</em></label> " . $sq_ticket['adults']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Child(ren) <em>:</em></label> " . $sq_ticket['childrens']; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Infant(s) <em>:</em></label> " . $sq_ticket['infant']; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="profile_box main_block" style="min-height: 141px;margin-top: 25px">
			<h3 class="editor_title">Costing Details</h3>
			<div class="panel panel-default panel-body app_panel_style">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
						<span class="main_block">
							<div class="highlighted_cost"> <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i><?php echo "<label>Total Amount <em>:</em></label> "; ?><?php echo $sq_ticket['ticket_total_cost']; ?></div>
						</span>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
						<span class="main_block">
							<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
							<?php echo "<label>Due Date <em>:</em></label> " . get_date_user($sq_ticket['due_date']); ?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="profile_box main_block" style="margin-top: 25px">
			<h3 class="editor_title">Passenger Details</h3>
			<?php $query = "select * from ticket_master where 1 ";
			$query .= " and ticket_id='$ticket_id'"; ?>
			<div class="table-responsive">
				<table class="table table-hover table-bordered no-marg" id="tbl_ticket_report">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Name</th>
							<th>Adolescence</th>
							<th>Ticket_No.</th>
							<th>Baggage</th>
							<th>Gds_Pnr</th>
						</tr>

					</thead>
					<tbody>
						<?php
						$count = 0;
						$sq_ticket = mysqlQuery($query);
						while ($row_ticket = mysqli_fetch_assoc($sq_ticket)) {

							$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_ticket[customer_id]'"));

							$sq_entry = mysqlQuery("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
							while ($row_entry = mysqli_fetch_assoc($sq_entry)) {


								$bg = ($row_entry['status'] == 'Cancel') ? 'danger' : '';
						?>
								<tr class="<?= $bg ?>">
									<td><?= ++$count ?></td>
									<td><?= $row_entry['first_name'] . " " . $row_entry['last_name'] ?></td>
									<td><?= $row_entry['adolescence'] ?></td>
									<td><?= $row_entry['ticket_no'] ?></td>
									<td><?= $row_entry['baggage_info'] ?></td>
									<td><?= $row_entry['gds_pnr'] ?></td>
								</tr>
						<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>