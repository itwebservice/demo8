	<div class="row">
		
		<div class="col-md-4 col-sm-12 col-xs-12 mg_bt_20_xs">
			<div class="profile_box main_block">
	        	 <h3>Customer Details</h3>
	        		<?php
						$sq_customer = mysqli_fetch_assoc(mysqlQuery("select customer_id, first_name, last_name, contact_no, email_id,type, company_name from customer_master where customer_id='$sq_booking[customer_id]'"));
						$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
						$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	        		?>
    				<span class="main_block"> 
    				    <i class="fa fa-user-o" aria-hidden="true"></i>
    				    <?php echo $sq_customer['first_name'].' '.$sq_customer['middle_name'].' '.$sq_customer['last_name'].'&nbsp'.'('.get_bus_booking_id($booking_id,$year).')'; ?>
    				</span>
    				<?php  
		        	  if($sq_customer['type'] == 'Corporate'||$sq_customer['type'] == 'B2B'){
		        	?>
        	 		<span class="main_block">
		                  <i class="fa fa-building-o" aria-hidden="true"></i>
		                  <?php echo $sq_customer['company_name'] ?>
		            </span>
		            <?php  } ?>
    				<span class="main_block">
    				    <i class="fa fa-phone" aria-hidden="true"></i>
    				    <?php echo $contact_no; ?> 
    				</span>
    				<span class="main_block">
    				    <i class="fa fa-envelope-o" aria-hidden="true"></i>
    				    <?php echo $email_id; ?>
    				</span>
        	</div> 
		</div>
		<div class="col-md-8 col-sm-12 col-xs-12">
		    <div class="profile_box main_block" style="min-height: 141px;">
	        	<h3>Costing Details</h3>
	            <div class="row">
					<div class="col-sm-6 col-xs-12">
		        	    <span class="main_block">
		        	      <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        	      <div class="highlighted_cost"><?php echo "<label>Net Total <em>:</em></label> ".$sq_booking['net_total'] ?></div>
		        	    </span>
		        		<span class="main_block">
		        		  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
		        		  <?php echo "<label>Booking Date <em>:</em></label> ".get_date_user($sq_booking['created_at']);?> 
		        		</span>
		        	</div>
	        	</div>
			</div>
		</div>
	    <div class="col-xs-12">
		    <div class="profile_box main_block" style="margin-top: 25px">
       	 	<h3 class="editor_title">Bus Details</h3>
                <div class="table-responsive">
                	<table id="tbl_dynamic_bus_booking" name="tbl_dynamic_bus_booking" class="table table-bordered no-marg">
	                	<tr class="table-heading-row">
					     	<th>S_No</th>
					     	<th>Bus_Operator</th>
					     	<th>Seat_Type</th>
					     	<th>Bus_Type</th>
					     	<th>PNR_No.</th>
					     	<th>Source</th>
					     	<th>Destination</th>
					     	<th>Journey_Date&Time</th>
					     	<th>Reporting_Time</th>
					     	<th>Boarding_Point</th>
						</tr>
	                   <?php $update_form = true; ?>
	                   <?php include_once('bus_booking_tbl.php'); ?>                        
	                </table>
                </div>
        	</div>
	    </div>  

	</div>
	  
               