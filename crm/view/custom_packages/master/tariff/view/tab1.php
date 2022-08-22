<div class="panel panel-default panel-body fieldset profile_background">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="basic_information">
			<div class="row">
			<?php
			echo "<h5>".$sq_package['package_name'].'('.$sq_package['package_code'] .')'.'&nbsp;&nbsp;('.$sq_package['total_days'].'D/'.$sq_package['total_nights'].'N )'.'</h5>';
			?>
			</div>
			<div class="row mg_tp_10">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered no-marg">
						<thead>
							<tr class="table-heading-row">
								<th>S_No.</th>
								<th>Hotel_Type</th>
								<th>Min_pax</th>
								<th>Max_pax</th>
								<th>Valid_From_date</th>
								<th>Valid_To_date</th>
								<th>B2B_Adult_Cost</th>
								<th>B2B_CWB_Cost</th>
								<th>B2B_CWOB_Cost</th>
								<th>B2B_Infant_Cost</th>
								<th>B2B_ExtraBed_Cost</th>
								<th>B2C_Adult_Cost</th>
								<th>B2C_CWB_Cost</th>
								<th>B2C_CWOB_Cost</th>
								<th>B2C_Infant_Cost</th>
								<th>B2C_ExtraBed_Cost</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$count=1;
						while($row_query = mysqli_fetch_assoc($sq_query)){ ?>
							<tr>
							<td><?= $count++ ?></td>
							<td><?= $row_query['hotel_type'] ?></td>
							<td><?= $row_query['min_pax'] ?></td>
							<td><?= $row_query['max_pax'] ?></td>
							<td><?= get_date_user($row_query['from_date']) ?></td>
							<td><?= get_date_user($row_query['to_date']) ?></td>
							<td><?= $row_query['badult'] ?></td>
							<td><?= $row_query['bcwb'] ?></td>
							<td><?= $row_query['bcwob'] ?></td>
							<td><?= $row_query['binfant'] ?></td>
							<td><?= $row_query['bextra'] ?></td>
							<td><?= $row_query['cadult'] ?></td>
							<td><?= $row_query['ccwb'] ?></td>
							<td><?= $row_query['ccwob'] ?></td>
							<td><?= $row_query['cinfant'] ?></td>
							<td><?= $row_query['cextra'] ?></td>
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