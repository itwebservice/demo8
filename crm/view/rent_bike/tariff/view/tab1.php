<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="basic_information">
			<?php
			$sq_tariff = mysqli_fetch_assoc(mysqlQuery("select * from bike_tariff where entry_id='$entry_id'"));
			$sq_veh = mysqli_fetch_assoc(mysqlQuery("select bike_name,bike_type from bike_master where entry_id='$sq_tariff[bike_id]'"));
			$sq_type = mysqli_fetch_assoc(mysqlQuery("select bike_type from bike_type_master where entry_id='$sq_veh[bike_type]'"));
			$sq_currency1 = mysqli_fetch_assoc(mysqlQuery("select currency_code,id from currency_name_master where id='$sq_tariff[currency_id]'"));
			echo $sq_veh['bike_name'].'('.$sq_type['bike_type'].')';
			echo ' /  Currency: '.$sq_currency1['currency_code'];
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="profile_box main_block">
						<div class="table-responsive">
							<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>S_No.</th>
									<th>City_Name</th>
									<th>Pickup_Location</th>
									<th>Valid_From_date</th>
									<th>Valid_To_date</th>
									<th>NO_OF_BIKES</th>
									<th>costing_type</th>
									<th>Total_cost</th>
									<th>Deposit</th>
									<th>Markup_In</th>
									<th>Markup_amount</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$count=1;
							while($row_query = mysqli_fetch_assoc($sq_query)){

								$row = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_query[city_id]'"));
							?>
								<tr>
								<td><?= $count++ ?></td>
								<td><?= $row['city_name'] ?></td>
								<td><?= $row_query['pickup_location'] ?></td>
								<td><?= get_date_user($row_query['from_date']) ?></td>
								<td><?= get_date_user($row_query['to_date']) ?></td>
								<td><?= $row_query['no_of_bikes'] ?></td>
								<td><?= $row_query['costing_type'] ?></td>
								<td><?= number_format($row_query['total_cost'],2) ?></td>
								<td><?= number_format($row_query['deposit'],2) ?></td>
								<td><?= $row_query['markup_in'] ?></td>
								<td><?= number_format($row_query['markup_amount'],2) ?></td>
								</tr>
							<?php } ?>
							</tbody>
							</table>
						</div>
					</div>
        		</div>
        	</div>
        </div>
	</div>
</div>
