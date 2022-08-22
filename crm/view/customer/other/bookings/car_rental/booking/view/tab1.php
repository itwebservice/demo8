<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
        	 	<h3>Customer Details</h3>
				<?php $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'")); 
				$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
				$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
				?>
				<span class="main_block"> 
				    <i class="fa fa-user-o" aria-hidden="true"></i>
				    <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'.'('.get_car_rental_booking_id($booking_id,$year).')'; ?>
				</span>
				<?php if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){?>
				<span class="main_block">
						<i class="fa fa-building-o" aria-hidden="true"></i>
						<?php echo $sq_customer['company_name'] ?>
					</span>
				<?php  } ?>
				<span class="main_block">
				    <i class="fa fa-envelope-o" aria-hidden="true"></i>
				    <?php echo $email_id; ?>
				</span>	
				<span class="main_block">
				    <i class="fa fa-phone" aria-hidden="true"></i>
				    <?php echo $contact_no; ?> 
				</span>
				<span class="main_block">
				    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
				    <?php echo "<label>Passenger <em>:</em></label> ".$sq_booking['pass_name']; ?>
				</span>
	    </div>
	</div>
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="profile_box main_block">
        	 	<h3>Costing Details</h3>  	 	
	        	<div class="col-sm-6 col-xs-12">          	 	
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <div class="highlighted_cost"><?php echo "<label>Net Total <em>:</em></label> ".$sq_booking['total_fees'];?> </div>
	        		</span> 
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Due Date <em>:</em></label> ".get_date_user($sq_booking['due_date']);?> 
	        		</span>
	        		<span class="main_block">
	        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_booking['created_at']);?> 
	        		</span>
				</div>	        		

        </div>
    </div>
</div>
<?php
$sq_vehicle_count = mysqli_num_rows(mysqlQuery("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'"));
if($sq_vehicle_count!=0){
?>
<!-- <div class="row">    
  	<div class="col-xs-12">
  		<div class="profile_box main_block" style="margin-top: 25px">
           	<h3 class="editor_title">Vehicle Details</h3>
                <div class="table-responsive">
                    <table id="tbl_dynamic_visa_update" name="tbl_dynamic_visa_update" class="table table-bordered no-marg">
                     <thead>
                       <tr class="table-heading-row">
                       	<th>S_No.</th>
                       	<th>Vehicle_Name</th>
                       	<th>Vehicle_No</th>
                       	<th>Driver_Name</th>
                       	<th>Mobile_No</th>
                       	<th>Type</th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php 
                        $count = 1;
                       $sq_vehicle_entries = mysqlQuery("select * from car_rental_booking_vehicle_entries where booking_id='$booking_id'");
					   while($row_vehicle = mysqli_fetch_assoc($sq_vehicle_entries)){				   	
					   	
						$sq_vehicle = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_vendor_vehicle_entries where vehicle_id='$row_vehicle[vehicle_id]'"));
                       			?>
								 <tr>
								    <td><?php echo $count; ?></td>
								    <td><?php echo$sq_vehicle['vehicle_name']; ?></td>
								    <td><?php echo strtoupper($sq_vehicle['vehicle_no']) ?></td>
									<td><?php echo $sq_vehicle['vehicle_driver_name']; ?></td>
								    <td><?php echo $sq_vehicle['vehicle_mobile_no']; ?></td>
								    <td><?php echo $sq_vehicle['vehicle_type']; ?></td>
								</tr>   
                       			<?php
                       			$count++;
                       }
                       ?>
                     </tbody>
                    </table>
                </div>
                
        </div>  
    </div>
</div> -->
<?php } ?>
           