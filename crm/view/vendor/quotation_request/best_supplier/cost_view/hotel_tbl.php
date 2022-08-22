<?php  if($quotation_for=="Hotel Vendor"): ?>
<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
        	<div class="row"> <div class="col-md-12"> <div class="table-responsive">
			
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>hotel_cost</th>
							<th>total_cost</th>
							<th>currency_code</th>
						</tr>
					</thead>
					<tbody>
			        	<?php
			        	$count=0;
				        	$query = "select * from vendor_reply_master where 1 ";
				        	//$query .=" and supplier_id='$supplier_id'";
				        	$query .=" and quotation_for='$quotation_for'";
				        	$query .=" and request_id = '$request_id'";
				        	$sq_req = mysqlQuery($query);
				            while($row= mysqli_fetch_assoc($sq_req)){
				            	$sq_currency1 = mysqli_fetch_assoc(mysqlQuery("select * from currency_name_master where id = '$row[currency_code]'"));
				            	$count++;
								?>
								<tr>
									<td><?= $count ?></td>
									<td><?= $row['hotel_cost'] ?></td>
									<td><?= $row['total_cost'] ?></td>
									<td><?= $sq_currency1['currency_code'] ?></td>
								</tr>
								<?php

							}
			        	?>
	        		</tbody>
	        	</table>

        	</div> </div> </div>

        </div>
    </div>
</div>
<?php endif; ?>