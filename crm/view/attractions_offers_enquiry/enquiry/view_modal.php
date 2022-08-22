<?php

include "../../../model/model.php";



$enquiry_id = $_POST['enquiry_id'];



$sq_enq_info = mysqli_fetch_assoc(mysqlQuery("select * from enquiry_master where enquiry_id='$enquiry_id'"));



$sq_ref = mysqli_fetch_assoc(mysqlQuery("select * from references_master where reference_id='$sq_enq_info[reference_id]'"));

$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$sq_enq_info[assigned_emp_id]'"));

$user_name = ($sq_enq_info['assigned_emp_id']!='0')?$sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

$enquiry_content = $sq_enq_info['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	

?>

<div class="modal fade profile_box_modal" id="view_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

<div class="modal-dialog modal-lg" role="document">

<div class="modal-content">

	<div class="modal-body profile_box_padding">

	

	<div>

			<!-- Nav tabs -->

			<ul class="nav nav-tabs" role="tablist">

			<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Enquiry Information</a></li>

			<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>

			</ul>



			<div class="panel panel-default panel-body fieldset profile_background">



				<!-- Tab panes1 -->

				<div class="tab-content">



				    <!-- *****TAb1 start -->

				    <div role="tabpanel" class="tab-pane active" id="basic_information">

				     

						<h3 class="editor_title">General Information</h3>
						<div class="panel panel-default panel-body app_panel_style">
							<div class="row">

								<div class="col-md-12">

									<div class="profile_box main_block">

										

										<div class="row">

											<div class="col-md-6">

												<span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Booking Type <em>:</em></label> ".$sq_enq_info['enquiry_type']; ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Customer <em>:</em></label> ".$sq_enq_info['name']; ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Mobile No. <em>:</em></label> ".$sq_enq_info['mobile_no']; ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Whatsapp No <em>:</em></label> ".$sq_enq_info['country_code'].$sq_enq_info['landline_no']; ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Email ID <em>:</em></label> ".$sq_enq_info['email_id']; ?>

								                </span>

												<span class="main_block">

												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

												<?php echo "<label>Enquiry Type<em>:</em></label> ".$sq_enq_info['enquiry'] ?>

												</span>							                

											</div>

											<div class="col-md-6">
												<span class="main_block">

												<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

												<?php echo "<label>Location <em>:</em></label> ".$sq_enq_info['location']; ?>

												</span>

												<span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Enquiry Date <em>:</em></label> ".get_date_user($sq_enq_info['enquiry_date']); ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Followup Date & Time <em>:</em></label> ".get_datetime_user($sq_enq_info['followup_date']); ?>

								                </span>

								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Reference <em>:</em></label> ".$sq_ref['reference_name']; ?>

								                </span>
												<?php 
													if($sq_enq_info['reference_id']=='3')
													{
														$sq_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_enq_info[customer_name]'"));
												?>
								                <span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Customer Name <em>:</em></label> ".$sq_cust['first_name'].' '.$sq_cust['last_name']; ?>

								                </span>						                
											<?php } ?>
											</div>

										</div>

										<div class="row">

											<div class="col-md-12">

												<span class="main_block">

								                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

								                  <?php echo "<label>Specification <em>:</em></label> ".$sq_enq_info['enquiry_specification']; ?>

								                </span>

											</div>

										</div>



									</div>

								</div>

							</div>
						</div>
<?php
if($sq_enq_info['enquiry_type']=='Flight Ticket'){
	?>
	<h3 class="editor_title main_block">Flight Information</h3>
	<table class="table table-bordered">
		<thead>
			<tr class="table-heading-row">
				<th>Travel_datetime</th>
				<th>Sector From</th>
				<th>Sector To</th>
				<th>Airline</th>
				<th>Class</th>
				<th>Total_Adult(s)</th>
				<th>Total_Child(ren)</th>
				<th>Total_Infant(s)</th>
				<th>Budget</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$enquiry_content = json_decode($sq_enq_info['enquiry_content'], true);
		foreach($enquiry_content as $values){
			$sq_airline = mysqli_fetch_assoc(mysqlQuery("SELECT * from airline_master where airline_id=".$values['preffered_airline']))
			?>
			<tr>
				<td><?php echo $values['travel_datetime']; ?></td>
				<td><?php echo $values['sector_from']; ?></td>
				<td><?php echo $values['sector_to']; ?></td>
				<td><?= $sq_airline['airline_name'].' ('.$sq_airline['airline_code'].')' ?></td>
				<td><?= $values['class_type'] ?></td>
				<td><?= $values['total_adults_flight'] ?></td>
				<td><?= $values['total_child_flight'] ?></td>
				<td><?= $values['total_infant_flight'] ?></td>
				<td><?= number_format($values['budget'] ?: 0,2) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
<?php
}
if($sq_enq_info['enquiry_type']!='Flight Ticket'){
	?>
	<h3 class="editor_title">Tour Information</h3>
	<div class="panel panel-default panel-body app_panel_style">
		<div class="row">
			<div class="col-md-12">
				<div class="profile_box main_block">
					<div class="row">
					<?php
					foreach($enquiry_content_arr1 as $enquiry_content_arr2){
						
						$break = '';
						$name = explode('_', $enquiry_content_arr2['name']);
						$name = ucfirst(implode(' ', $name));
						if($name=="No of nights"){
							$name = "No of Nights";
						}
						if($name=="Total members"){
							$name = "Total Passenger";
						}
						if($name=="Tour name"){
							$name = "Interested Tour";
						}
						if($name=="Check in date"){
							$name="Check in";
						}
						if($name=="Check out date"){
							$name="Check out";
						}
						if($name=="Bus name and type"){
							$name="Bus name & type";
						}
						if($name=="Child with bed"){
							$name="With Bed";
						}
						if($name=="Child without bed"){
							$name="Without Bed";
						}
						if($name=="Total adult"){
							$name="Adult";
						}
						if($name=="Total infant"){
							$name="Infant";
						}
						if($name=="Total children"){
							$name="Children";
						}
						if($name=="Total cwob"){
							$name="Child Without Bed";
						}
						if($name=="Total cwb"){
							$name="Child With Bed";
						}
						if($name=="City id"){
							$name="City Name";
							$sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$enquiry_content_arr2[value]'"));
							$enquiry_content_arr2['value'] = $sq_city['city_name'];
						}
						if($name=="Travel datetime"){
							$name="Travel Date/Time";
						}
						if($name=="Accomodation type"){
							$name="Accommodation Type";
						}
						if($name == "Hotel requirements"){
							$name="Hotel requirements";
							$break = '&nbsp;&nbsp;';
						}
						if($name == "Hotel type"){
							$name="Hotel Category";
						}
						if($name=="Vehicle type"){
							$name="Vehicle Name";
						}
						if($sq_enq_info['enquiry_type']=='Car Rental' && $name == "Places to visit"){
							$name="Route";
						}
						if($name=="Traveling date"){
							$name="Travelling Date";
						}
						if($name=="Days of traveling"){
							$name="Days of travelling";
						}
						if($name!='Hotel requirements'){ ?>
							<div class="col-md-6">
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<label>".$name." <em>:</em></label> ".$enquiry_content_arr2['value']; ?>
								</span>
							</div>
						<?php }else{ ?>
							<div class="col-md-6">
								<span class="main_block">
									<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
									<?php echo "<div>".$name." <em>:</em></div> ".$enquiry_content_arr2['value']; ?>
								</span>
							</div>
						<?php
						}
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>					
	<?php
}
?>
</div>
<!-- ********Tab1 End******** -->
</div>
</div>

</div>
</div>
</div></div></div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#view_modal').modal('show');
</script>