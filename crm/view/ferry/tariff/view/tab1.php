<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="basic_information">
	    <div class="row">
				<div class="col-md-12">
					<div class="profile_box main_block">
						<div class="table-responsive">
							<table class="table table-bordered no-marg">
							<thead>
								<tr class="table-heading-row">
									<th>S_No.</th>
									<th>No_of_seats</th>
									<th>Valid_From_date</th>
									<th>Valid_To_date</th>
									<th>From_Location</th>
									<th>To_location</th>
									<th>Departure_Datetime</th>
									<th>Arrival_Datetime</th>
									<th>Ferry_Class</th>
									<th>Adult_Cost</th>
									<th>child_cost</th>
									<th>Infant_cost</th>
									<th>Markup_In</th>
									<th>Markup_cost</th>
									<th>Currency</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$count=1;
							while($row_query = mysqli_fetch_assoc($sq_query)){

								$sq_from_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_query[from_location]'"));
								$sq_to_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_query[to_location]'"));
								$sq_currency = mysqli_fetch_assoc(mysqlQuery("select * from currency_name_master where id='$row_query[currency_id]'"));
							?>
								<tr>
								<td><?= $count++ ?></td>
								<td><?= $row_query['no_of_seats'] ?></td>
								<td><?= get_date_user($row_query['valid_from_date']) ?></td>
								<td><?= get_date_user($row_query['valid_to_date']) ?></td>
								<td><?= $sq_from_city['city_name'] ?></td>
								<td><?= $sq_to_city['city_name'] ?></td>
								<td><?= get_datetime_user($row_query['dep_date']) ?></td>
								<td><?= get_datetime_user( $row_query['arr_date']) ?></td>
								<td><?= $row_query['category'] ?></td>
								<td><?= number_format($row_query['adult_cost'],2) ?></td>
								<td><?= number_format($row_query['child_cost'],2) ?></td>
								<td><?= number_format($row_query['infant_cost'],2) ?></td>
								<td><?= $row_query['markup_in'] ?></td>
								<td><?= number_format($row_query['markup_cost'],2) ?></td>
								<td><?= $sq_currency['currency_code'] ?></td>
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
